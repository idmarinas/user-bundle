<?php
/**
 * Copyright 2024 (C) IDMarinas - All Rights Reserved
 *
 * Last modified by "idmarinas" on 26/12/2024, 18:15
 *
 * @project IDMarinas User Bundle
 * @see     https://github.com/idmarinas/user-bundle
 *
 * @file    LoginController.php
 * @date    26/12/2024
 * @time    17:57
 *
 * @author  Iván Diaz Marinas (IDMarinas)
 * @license BSD 3-Clause License
 *
 * @since   2.0.0
 */

namespace Idm\Bundle\User\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

final class LoginController extends AbstractController
{
	#[Route(path: '/login', name: 'login', methods: ['GET', 'POST'])]
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
