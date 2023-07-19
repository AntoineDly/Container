<?php

declare(strict_types=1);

/*
 * This file is part of the AntoineDly/Container package.
 *
 * (c) Antoine Delaunay <antoine.delaunay333@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace AntoineDly\Container;

use AntoineDly\Container\Exception\ContainerException;
use AntoineDly\Container\Exception\NotFoundException;
use Psr\Container\ContainerInterface;
use ReflectionClass;
use ReflectionNamedType;
use ReflectionParameter;
use ReflectionType;
use ReflectionUnionType;

final class Container implements ContainerInterface
{
    /** @var Callable[]|Object[] $instances */
    private array $instances = [];

    public function get(string $id): object|callable
    {
        if (!$this->has(id: $id)) {
            $this->set(id: $id, concrete: $id);
        }

        return $this->instances[$id];
    }

    public function has(string $id): bool
    {
        return isset($this->instances[$id]);
    }

    public function set(string $id, callable|string $concrete): void
    {
        if (is_callable($concrete)) {
            $this->instances[$id] = $concrete;
        } else {
            $this->instances[$id] = $this->resolve(id: $concrete);
        }
    }

    private function getReflectionClass(string $id): ReflectionClass
    {
        if (!class_exists(class: $id)) {
            throw new NotFoundException(message: "Class {$id} was not found");
        }
        $reflectionClass = new ReflectionClass(objectOrClass: $id);
        if (!$reflectionClass->isInstantiable()) {
            throw new ContainerException(message: "Class {$id} is not instantiable");
        }

        return $reflectionClass;
    }

    private function resolve(string $id): object
    {
        $reflectionClass = $this->getReflectionClass(id: $id);
        $constructor = $reflectionClass->getConstructor();

        if (!$constructor || !$parameters = $constructor->getParameters()) {
            return new $id();
        }

        $dependencies = array_map(
            function (ReflectionParameter $param) use ($id) {
                if ($param->isDefaultValueAvailable() || $param->isOptional()) {
                    return $param->getDefaultValue();
                }
                $className = $param->getName();
                $classType = $param->getType();
                return $this->resolveClass(name: $className, type: $classType, id :$id);
            },
            $parameters
        );

        return $reflectionClass->newInstanceArgs(args: $dependencies);
    }

    private function resolveClass(
        bool|string|ReflectionNamedType|ReflectionUnionType $name,
        ReflectionType|null $type,
        string $id
    ): callable|object {
        if ($type instanceof ReflectionNamedType) {
            return $this->get(id: $type->getName());
        }

        if (!$type) {
            throw new ContainerException(
                message: "Failed to resolve class {$id} because param {$name} is missing a type hint"
            );
        }

        if ($type instanceof ReflectionUnionType) {
            throw new ContainerException(
                message: "Failed to resolve class {$id} because of union type for param {$name}"
            );
        }

        throw new ContainerException(message: "Failed to resolve class {$id} because invalid param {$name}");
    }
}
