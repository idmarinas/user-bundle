<?php
/**
 * Copyright 2024 (C) IDMarinas - All Rights Reserved
 *
 * Last modified by "IDMarinas" on 17/12/2024, 11:54
 *
 * @project IDMarinas User Bundle
 * @see     https://github.com/idmarinas/user-bundle
 *
 * @file    bootstrap.php
 * @date    05/12/2024
 * @time    19:26
 *
 * @author  Iván Diaz Marinas (IDMarinas)
 * @license BSD 3-Clause License
 *
 * @since   2.0.0
 */

use Idm\Bundle\User\Tests\TestKernel;
use Symfony\Component\Filesystem\Filesystem;

require dirname(__DIR__) . '/vendor/autoload.php';

$kernel = new TestKernel('test', true);
$filesystem = new Filesystem();

if ($filesystem->exists($kernel->getCacheDir())) {
	$filesystem->remove($kernel->getCacheDir());
}

if ($filesystem->exists($kernel->getLogDir())) {
	$filesystem->remove($kernel->getLogDir());
}
