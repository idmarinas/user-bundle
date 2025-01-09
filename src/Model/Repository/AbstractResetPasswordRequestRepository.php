<?php
/**
 * Copyright 2024-2025 (C) IDMarinas - All Rights Reserved
 *
 * Last modified by "IDMarinas" on 09/01/2025, 19:20
 *
 * @project IDMarinas User Bundle
 * @see     https://github.com/idmarinas/user-bundle
 *
 * @file    AbstractResetPasswordRequestRepository.php
 * @date    23/12/2024
 * @time    17:26
 *
 * @author  Iván Diaz Marinas (IDMarinas)
 * @license BSD 3-Clause License
 *
 * @since   2.0.0
 */

namespace Idm\Bundle\User\Model\Repository;

use App\Entity\User\ResetPasswordRequest;
use DateTimeInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Idm\Bundle\User\Model\Entity\AbstractUser;
use SymfonyCasts\Bundle\ResetPassword\Model\ResetPasswordRequestInterface;
use SymfonyCasts\Bundle\ResetPassword\Persistence\Repository\ResetPasswordRequestRepositoryTrait;
use SymfonyCasts\Bundle\ResetPassword\Persistence\ResetPasswordRequestRepositoryInterface;

class AbstractResetPasswordRequestRepository extends ServiceEntityRepository
	implements ResetPasswordRequestRepositoryInterface
{
	use ResetPasswordRequestRepositoryTrait;

	/**
	 * @param AbstractUser $user
	 */
	public function createResetPasswordRequest (
		object            $user,
		DateTimeInterface $expiresAt,
		string            $selector,
		string            $hashedToken
	): ResetPasswordRequestInterface {
		return new ResetPasswordRequest($user, $expiresAt, $selector, $hashedToken);
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
