<?php
/**
 * Copyright 2024-2025 (C) IDMarinas - All Rights Reserved
 *
 * Last modified by "IDMarinas" on 11/02/2025, 22:49
 *
 * @project IDMarinas User Bundle
 * @see     https://github.com/idmarinas/user-bundle
 *
 * @file    AbstractLoginController.php
 * @date    26/12/2024
 * @time    17:57
 *
 * @author  Iván Diaz Marinas (IDMarinas)
 * @license BSD 3-Clause License
 *
 * @since   2.0.0
 */

namespace Idm\Bundle\User\Model\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

abstract class AbstractLoginController extends AbstractController
{
	#[Route(path: '/web', name: 'web', methods: ['GET', 'POST'])]
	public function login (AuthenticationUtils $authenticationUtils): Response
	{
		if ($this->getUser() instanceof UserInterface) {
			return $this->redirectToRoute('idm_user_profile_index');
		}

		// get the login error if there is one
		$error = $authenticationUtils->getLastAuthenticationError();
		// last username entered by the user
		$lastUsername = $authenticationUtils->getLastUsername();

		$params = [
			'last_username' => $lastUsername,
			'error'         => $error,
		];

		return $this->render('@IdmUser/login/index.html.twig', $params);
	}
}
