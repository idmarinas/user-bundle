<?php
/**
 * Copyright 2024 (C) IDMarinas - All Rights Reserved
 *
 * Last modified by "IDMarinas" on 2/12/24, 18:22
 *
 * @project IDMarinas User Bundle
 * @see     https://github.com/idmarinas/user-bundle
 *
 * @file    LoginTrait.php
 * @date    02/12/2024
 * @time    18:22
 *
 * @author  Iván Diaz Marinas (IDMarinas)
 * @license BSD 3-Clause License
 *
 * @since   1.1.0
 */

namespace Idm\Bundle\User\Traits\Controller;

use KnpU\OAuth2ClientBundle\Client\ClientRegistry;
use Symfony\Component\HttpFoundation\Response;

trait LoginTrait
{
	/**
	 * @param \KnpU\OAuth2ClientBundle\Client\ClientRegistry $clientRegistry Client registry
	 * @param string                                         $clientKey      Client Key used in
	 *                                                                       config/packages/knpu_oauth2_client.yaml
	 * @param string                                         $scopes         The scopes you want to access
	 *
	 * @return \Symfony\Component\HttpFoundation\Response
	 */
	public function socialLogin (ClientRegistry $clientRegistry, string $clientKey, string $scopes = 'profile email'):
	Response {
		//-- Leads to IDMarinas community page
		return $clientRegistry
			->getClient($clientKey) // key used in config/packages/knpu_oauth2_client.yaml
			->redirect([
				$scopes, // the scopes you want to access
			], [])
		;
	}
}