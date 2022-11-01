<?php
/**
 * Equaltrue (shuvoenr@gmail.com)
 *
 * This source file is subject to the Equaltrue license
 *
 * @category  Core
 * @package   Equaltrue_Core
 * @copyright Copyright (c) Equaltrue (https://equaltrue.com)
 * @author    Suvankar Paul
 */

declare(strict_types=1);

use Magento\Framework\Component\ComponentRegistrar;

ComponentRegistrar::register(
    ComponentRegistrar::MODULE,
    'Equaltrue_Core',
    __DIR__
);
