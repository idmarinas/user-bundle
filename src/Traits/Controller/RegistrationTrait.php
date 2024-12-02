<?php
/**
 * Copyright 2024 (C) IDMarinas - All Rights Reserved
 *
 * Last modified by "IDMarinas" on 17/10/24, 18:30
 *
 * @project IDMarinas User Bundle
 * @see     https://github.com/idmarinas/user-bundle
 *
 * @file    RegistrationControllerTrait.php
 * @date    02/12/2024
 * @time    18:30
 *
 * @author  Iván Diaz Marinas (IDMarinas)
 * @license BSD 3-Clause License
 *
 * @since   1.1.0
 */

namespace Idm\Bundle\User\Traits\Controller;

use Doctrine\ORM\EntityManagerInterface;
use Idm\Bundle\User\Entity\AbstractUser;
use Idm\Bundle\User\Security\EmailVerifier;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

trait RegistrationTrait
{
	protected function getUserObject (AbstractUser $user): AbstractUser
	{
		$displayName = preg_replace('/[^A-Za-z0-9]/', '', uniqid('User' . uniqid(), true));
		$user->setDisplayName($displayName);

		return $user;
	}

	protected function registerUser (
		EntityManagerInterface      $entityManager,
		AbstractUser                $user,
		UserPasswordHasherInterface $userPasswordHasher,
		EmailVerifier               $emailVerifier,
		TemplatedEmail              $templatedEmail,
		string                      $plainPassword,
		string                      $verifyEmailRouteName = 'app_user_registration_verify_email',
	): void {
		// encode the plain password
		$user->setPassword($userPasswordHasher->hashPassword($user, $plainPassword));

		$entityManager->persist($user);
		$entityManager->flush();

		// generate a signed url and email it to the user
		$emailVerifier->sendEmailConfirmation($verifyEmailRouteName, $user, $templatedEmail);
		// do anything else you need here, like send an email
	}
}