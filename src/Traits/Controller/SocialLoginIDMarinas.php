<?php
/**
 * Copyright 2024 (C) IDMarinas - All Rights Reserved
 *
 * Last modified by "idmarinas" on 26/12/2024, 18:14
 *
 * @project IDMarinas User Bundle
 * @see     https://github.com/idmarinas/user-bundle
 *
 * @file    SocialLoginIDMarinas.php
 * @date    26/12/2024
 * @time    18:08
 *
 * @author  Iván Diaz Marinas (IDMarinas)
 * @license BSD 3-Clause License
 *
 * @since   2.0.0
 */

namespace Idm\Bundle\User\Traits\Controller;

use KnpU\OAuth2ClientBundle\Client\ClientRegistry;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

/**
 * @method boolean isGranted(mixed $attribute, mixed $subject = null)
 * @method RedirectResponse redirectToRoute(string $route, array $parameters = [], int $status = 302)
 */
trait SocialLoginIDMarinas
{
	/** Connect from the IDMarinas community. */
	#[Route(path: '/connect/idmarinas', name: 'connect_idmarinas_start', methods: ['GET'])]
	public function connectIdmarinas (ClientRegistry $clientRegistry): Response
	{
		//-- Do not allow reconnecting if you are already logged in.
		if ($this->isGranted('ROLE_USER')) {
			return $this->redirectToRoute('idm_user_profile_index');
		}

		// Leads to the IDMarinas community page.
		return $clientRegistry
			->getClient('idmarinas_oauth') // key used in config/packages/knpu_oauth2_client.yaml
			->redirect([
				'profile email', // the scopes you want to access
			], [])
		;
	}
}
