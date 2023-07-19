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

namespace AntoineDly\Container\Mock;

final class Class1 implements ClassInterface
{
    public function __construct(
        Class2 $class2
    ) {
    }
}