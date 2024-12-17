<?php
/**
 * Copyright 2024 (C) IDMarinas - All Rights Reserved
 *
 * Last modified by "IDMarinas" on 17/12/2024, 11:56
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
 * @since   2.0.0
 */

namespace Idm\Bundle\User\Traits\Controller;

use KnpU\OAuth2ClientBundle\Client\ClientRegistry;
use Symfony\Component\HttpFoundation\Response;

trait LoginTrait
{
	/**
	 * @param ClientRegistry $clientRegistry Client registry
	 * @param string         $clientKey      Client Key used in config/packages/knpu_oauth2_client.yaml
	 * @param string         $scopes         The scopes you want to access
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
