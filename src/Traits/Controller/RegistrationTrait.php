<?php
/**
 * Copyright 2024 (C) IDMarinas - All Rights Reserved
 *
 * Last modified by "IDMarinas" on 28/12/2024, 11:22
 *
 * @project IDMarinas User Bundle
 * @see     https://github.com/idmarinas/user-bundle
 *
 * @file    RegistrationTrait.php
 * @date    02/12/2024
 * @time    18:30
 *
 * @author  Iván Diaz Marinas (IDMarinas)
 * @license BSD 3-Clause License
 *
 * @since   2.0.0
 */

namespace Idm\Bundle\User\Traits\Controller;

use Idm\Bundle\User\Model\Entity\AbstractUser;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;

trait RegistrationTrait
{
	protected function getUserObject (): AbstractUser
	{
		$repository = $this->entityManager->getRepository(AbstractUser::class);

		$displayName = 'User' . mt_rand();
		$user = new ($repository->getClassName())();
		$user->setDisplayName($displayName);

		return $user;
	}

	protected function registerUser (
		AbstractUser   $user,
		TemplatedEmail $templatedEmail,
		string         $plainPassword
	): void {
		// encode the plain password
		$user->setPassword($this->passwordHasher->hashPassword($user, $plainPassword));

		$this->entityManager->persist($user);
		$this->entityManager->flush();

		$templatedEmail
			->to($user->getEmail())
			->subject($this->translator->trans('email.verify_email.subject', [], 'IdmUserBundle'))
			->htmlTemplate('@IdmUser/registration/email.html.twig')
			->textTemplate('@IdmUser/registration/email.txt.twig')
		;
		// generate a signed url and email it to the user
		$this->emailVerifier->sendEmailConfirmation('idm_user_registration_verify_email', $user, $templatedEmail);
		// do anything else you need here, like send an email
	}
}
