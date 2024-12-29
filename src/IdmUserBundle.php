<?php

/**
 * Copyright 2023-2024 (C) IDMarinas - All Rights Reserved
 *
 * Last modified by "IDMarinas" on 29/12/2024, 21:26
 *
 * @project IDMarinas User Bundle
 * @see     https://github.com/idmarinas/user-bundle
 *
 * @file    IdmUserBundle.php
 * @date    20/12/2023
 * @time    22:28
 *
 * @author  Iván Diaz Marinas (IDMarinas)
 * @license BSD 3-Clause License
 *
 * @since   1.0.0
 */

namespace Idm\Bundle\User;

use Symfony\Component\HttpKernel\Bundle\Bundle;
use function dirname;

class IdmUserBundle extends Bundle
{
	public function getPath (): string
	{
		return dirname(__DIR__);
	}
}
