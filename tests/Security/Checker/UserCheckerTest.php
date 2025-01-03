<?php
/**
 * Copyright 2025 (C) IDMarinas - All Rights Reserved
 *
 * Last modified by "IDMarinas" on 03/01/2025, 16:08
 *
 * @project IDMarinas User Bundle
 * @see     https://github.com/idmarinas/user-bundle
 *
 * @file    UserCheckerTest.php
 * @date    03/01/2025
 * @time    15:57
 *
 * @author  Iván Diaz Marinas (IDMarinas)
 * @license BSD 3-Clause License
 *
 * @since   2.0.0
 */

namespace Idm\Bundle\User\Tests\Security\Checker;

use App\Entity\User\FakeUser;
use Idm\Bundle\User\Security\Checker\UserChecker;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Session\Flash\FlashBagInterface;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Security\Core\Authorization\AccessDecisionManagerInterface;

class UserCheckerTest extends TestCase
{

	public function testCheckFail (): void
	{
		$access = $this->createMock(AccessDecisionManagerInterface::class);
		$requestStack = $this->createMock(RequestStack::class);
		$session = $this->createMock(Session::class);
		$flashBag = $this->createMock(FlashBagInterface::class);

		$session->method('getFlashBag')->willReturn($flashBag);
		$requestStack->method('getSession')->willReturn($session);

		$user = new FakeUser();

		$checker = new UserChecker($access, $requestStack);

		$checker->checkPostAuth($user);
		$checker->checkPreAuth($user);

		$this->assertTrue(true);
	}
}
