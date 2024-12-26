<?php
/**
 * Copyright 2024 (C) IDMarinas - All Rights Reserved
 *
 * Last modified by "idmarinas" on 26/12/2024, 20:47
 *
 * @project IDMarinas User Bundle
 * @see     https://github.com/idmarinas/user-bundle
 *
 * @file    AbstractUserChecker.php
 * @date    26/12/2024
 * @time    20:40
 *
 * @author  Iván Diaz Marinas (IDMarinas)
 * @license BSD 3-Clause License
 *
 * @since   2.0.0
 */

namespace Idm\Bundle\User\Model\Security\Checker;

use Idm\Bundle\User\Model\Entity\AbstractUser;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Session\Flash\FlashBagInterface;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Security\Core\Authorization\AccessDecisionManagerInterface;
use Symfony\Component\Security\Core\Exception\CustomUserMessageAccountStatusException;
use Symfony\Component\Security\Core\User\UserCheckerInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use function Symfony\Component\Translation\t;

abstract class AbstractUserChecker implements UserCheckerInterface
{
	protected FlashBagInterface $flash;

	public function __construct (
		protected AccessDecisionManagerInterface $accessDecisionManager,
		protected RequestStack                   $request
	) {
		/** @var Session $session */
		$session = $request->getSession();
		$this->flash = $session->getFlashBag();
	}

	public function checkPreAuth (UserInterface $user): void
	{
		if (!$user instanceof AbstractUser) {
			return;
		}

		if ($user->isDeleted()) {
			throw new CustomUserMessageAccountStatusException('idm_user_bundle.account.no_exist');
		}

		if ($user->isBanned()) {
			throw new CustomUserMessageAccountStatusException('idm_user_bundle.account.banned');
		}
	}

	public function checkPostAuth (UserInterface $user): void
	{
		if (!$user instanceof AbstractUser) {
			return;
		}

		if (!$user->isVerified()) {
			$this->flash->add('warning', t('idm_user_bundle.email.not_verified', [], 'security'));
		}

		// user account is expired, the user may be notified
		// if ($user->isExpired())
		// {
		//     throw new AccountExpiredException('...');
		// }
	}
}
