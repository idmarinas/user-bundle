<?php
/**
 * Copyright 2024 (C) IDMarinas - All Rights Reserved
 *
 * Last modified by "idmarinas" on 26/12/2024, 14:41
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

use DateTimeInterface;
use Doctrine\Persistence\ManagerRegistry;
use Idm\Bundle\User\Entity\ResetPasswordRequest;
use Idm\Bundle\User\Model\Repository\AbstractResetPasswordRequestRepository;
use SymfonyCasts\Bundle\ResetPassword\Model\ResetPasswordRequestInterface;

/**
 * @extends AbstractResetPasswordRequestRepository<ResetPasswordRequest>
 */
class ResetPasswordRequestRepository extends AbstractResetPasswordRequestRepository
{
	public function __construct (ManagerRegistry $registry)
	{
		parent::__construct($registry, ResetPasswordRequest::class);
	}

	/** @inheritDoc */
	public function getMostRecentNonExpiredRequestDate (object $user): ?DateTimeInterface
	{
		// Normally there is only 1 max request per use, but written to be flexible
		/** @var ResetPasswordRequestInterface $resetPasswordRequest */
		$resetPasswordRequest = $this
			->createQueryBuilder('t')
			->where('t.user = :user')
			->setParameter('user', $user->getId(), 'uuid')
			->orderBy('t.requestedAt', 'DESC')
			->setMaxResults(1)
			->getQuery()
			->getOneOrNullResult()
		;

		if (null !== $resetPasswordRequest && !$resetPasswordRequest->isExpired()) {
			return $resetPasswordRequest->getRequestedAt();
		}

		return null;
	}
}
