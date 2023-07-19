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

use AntoineDly\Container\Mock\Class1;
use AntoineDly\Container\Mock\ClassInterface;
use PHPUnit\Framework\TestCase;

final class ContainerTests extends TestCase
{
    private Container $container;

    public function setUp(): void
    {
        $this->container = new Container();
    }

    public function testContainerGet(): void
    {
        $this->container->set(id: ClassInterface::class, concrete: Class1::class);
        $this->assertInstanceOf(expected: Class1::class, actual: $this->container->get(id: ClassInterface::class));
    }
}