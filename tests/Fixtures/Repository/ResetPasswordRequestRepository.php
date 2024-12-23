<?php
/**
 * Copyright 2024 (C) IDMarinas - All Rights Reserved
 *
 * Last modified by "IDMarinas" on 23/12/2024, 17:33
 *
 * @project IDMarinas User Bundle
 * @see     https://github.com/idmarinas/user-bundle
 *
 * @file    ResetPasswordRequestRepository.php
 * @date    23/12/2024
 * @time    17:31
 *
 * @author  Iván Diaz Marinas (IDMarinas)
 * @license BSD 3-Clause License
 *
 * @since   2.0.0
 */

namespace Idm\Bundle\User\Tests\Fixtures\Repository;

use DateTimeInterface;
use Idm\Bundle\User\Model\Repository\AbstractResetPasswordRequestRepository;
use SymfonyCasts\Bundle\ResetPassword\Model\ResetPasswordRequestInterface;

class ResetPasswordRequestRepository extends AbstractResetPasswordRequestRepository
{

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
