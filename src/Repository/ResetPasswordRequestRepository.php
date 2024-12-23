<?php
/**
 * Copyright 2024 (C) IDMarinas - All Rights Reserved
 *
 * Last modified by "IDMarinas" on 23/12/2024, 17:29
 *
 * @project IDMarinas User Bundle
 * @see     https://github.com/idmarinas/user-bundle
 *
 * @file    ResetPasswordRequestRepository.php
 * @date    05/12/2024
 * @time    21:38
 *
 * @author  Iván Diaz Marinas (IDMarinas)
 * @license BSD 3-Clause License
 *
 * @since   2.0.0
 */

namespace Idm\Bundle\User\Repository;

use Doctrine\Persistence\ManagerRegistry;
use Idm\Bundle\User\Entity\ResetPasswordRequest;
use Idm\Bundle\User\Model\Repository\AbstractResetPasswordRequestRepository;

/**
 * @extends AbstractResetPasswordRequestRepository<ResetPasswordRequest>
 */
class ResetPasswordRequestRepository extends AbstractResetPasswordRequestRepository
{
	public function __construct (ManagerRegistry $registry)
	{
		parent::__construct($registry, ResetPasswordRequest::class);
	}
}
