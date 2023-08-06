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
use AntoineDly\Container\Mock\ClassA;
use AntoineDly\Container\Mock\ClassB;
use AntoineDly\Container\Mock\ClassC;
use AntoineDly\Container\Mock\ClassD;
use AntoineDly\Container\Mock\ClassAInterface;
use AntoineDly\Container\Mock\ClassBInterface;
use PHPUnit\Framework\TestCase;

final class ContainerTests extends TestCase
{
    private Container $container;

    public function setUp(): void
    {
        $this->container = new Container();
    }

    public function testContainerGetSuccessfull(): void
    {
        $this->container->set(id: ClassBInterface::class, concrete: ClassB::class);
        $this->container->set(id: ClassAInterface::class, concrete: ClassC::class);
        $this->assertInstanceOf(expected: ClassC::class, actual: $this->container->get(id: ClassAInterface::class));
        $this->assertInstanceOf(expected: ClassB::class, actual: $this->container->get(id: ClassBInterface::class));
    }

    public function testContainerGetErrorAbstractClass(): void
    {
        $this->container->set(id: ClassBInterface::class, concrete: ClassB::class);
        $this->expectException(ContainerException::class);
        $this->expectExceptionMessage(message: 'Class AntoineDly\Container\Mock\ClassA is not instantiable');
        $this->container->set(id: ClassAInterface::class, concrete: ClassA::class);
    }

    public function testContainerGetErrorParameters(): void
    {
        $this->expectException(NotFoundException::class);
        $this->expectExceptionMessage(message: 'Class string was not found');
        $this->container->set(id: ClassD::class, concrete: ClassD::class);
    }

    public function testContainerSetError(): void
    {
        $this->expectException(NotFoundException::class);
        $this->expectExceptionMessage(message: 'Class a string was not found');
        $this->container->set(id: ClassD::class, concrete: 'a string');
    }
}
