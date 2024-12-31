<?php
/**
 * Copyright 2024 (C) IDMarinas - All Rights Reserved
 *
 * Last modified by "IDMarinas" on 31/12/2024, 11:24
 *
 * @project IDMarinas User Bundle
 * @see     https://github.com/idmarinas/user-bundle
 *
 * @file    UserAdminChecker.php
 * @date    26/12/2024
 * @time    20:45
 *
 * @author  Iván Diaz Marinas (IDMarinas)
 * @license BSD 3-Clause License
 *
 * @since   2.0.0
 */

namespace Idm\Bundle\User\Security\Checker;

use Idm\Bundle\User\Model\Security\Checker\AbstractUserChecker;
use Symfony\Component\Security\Core\Authentication\Token\PreAuthenticatedToken;
use Symfony\Component\Security\Core\Exception\CustomUserMessageAccountStatusException;
use Symfony\Component\Security\Core\User\UserInterface;

final class UserAdminChecker extends AbstractUserChecker
{
	public function checkPreAuth (UserInterface $user): void
	{
		$token = new PreAuthenticatedToken($user, 'admin', $user->getRoles());

		if (!$this->accessDecisionManager->decide($token, ['ROLE_ADMIN'], null)) {
			throw new CustomUserMessageAccountStatusException('idm_user_bundle.role.insufficient');
		}

		parent::checkPreAuth($user);
	}
}
