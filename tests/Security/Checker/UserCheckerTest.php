<?php
/**
 * Copyright 2026-2026 (C) IDMarinas - All Rights Reserved
 *
 * Last modified by "IDMarinas" on 27/09/2026, 22:14
 *
 * @project IDMarinas User Bundle
 * @see     https://github.com/idmarinas/user-bundle
 *
 * @file    UserCheckerTest.php
 * @date    27/09/2026
 * @time    20:11
 *
 * @author  Iván Diaz Marinas (IDMarinas)
 * @license BSD 3-Clause License
 *
 * @since   2.2.0
 */

declare(strict_types=1);

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

final class UserCheckerTest extends TestCase
{

	public function testCheckFail(): void
	{
		$access = $this->createStub(AccessDecisionManagerInterface::class);
		$requestStack = $this->createStub(RequestStack::class);
		$session = $this->createStub(Session::class);
		$flashBag = $this->createStub(FlashBagInterface::class);

		$session->method('getFlashBag')->willReturn($flashBag);
		$requestStack->method('getSession')->willReturn($session);

		$user = new FakeUser();

		$checker = new UserChecker($access, $requestStack);

		$checker->checkPostAuth($user);
		$checker->checkPreAuth($user);

		$this->assertTrue(true);
	}
}
