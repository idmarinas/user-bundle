<?php

/**
 * Copyright 2023-2024 (C) IDMarinas - All Rights Reserved
 *
 * Last modified by "IDMarinas" on 21/12/2024, 11:55
 *
 * @project IDMarinas User Bundle
 * @see     https://github.com/idmarinas/user-bundle
 *
 * @file    AbstractUserRepository.php
 * @date    27/12/2023
 * @time    18:41
 *
 * @author  Iván Diaz Marinas (IDMarinas)
 * @license BSD 3-Clause License
 *
 * @since   1.0.0
 */

namespace Idm\Bundle\User\Repository;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Idm\Bundle\User\Model\Entity\AbstractUser;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\PasswordUpgraderInterface;

/**
 * @extends ServiceEntityRepository<AbstractUser>
 *
 * @method AbstractUser|null find($id, $lockMode = null, $lockVersion = null)
 * @method AbstractUser|null findOneBy(array $criteria, array $orderBy = null)
 * @method AbstractUser[]    findAll()
 * @method AbstractUser[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
abstract class AbstractUserRepository extends ServiceEntityRepository implements PasswordUpgraderInterface
{
	/**
	 * Used to upgrade (rehash) the user's password automatically over time.
	 */
	public function upgradePassword (PasswordAuthenticatedUserInterface $user, string $newHashedPassword): void
	{
		if (!$user instanceof AbstractUser) {
			throw new UnsupportedUserException(sprintf('Instances of "%s" are not supported.', $user::class));
		}

		$user->setPassword($newHashedPassword);

		$this->getEntityManager()->persist($user);
		$this->getEntityManager()->flush();
	}

	/**
	 * Function to determine if there is another user with the same email address
	 * by taking into account those marked as deleted.
	 */
	public function uniqueUserEmail ($value): array
	{
		$filters = $this->getEntityManager()->getFilters();

		if ($filters->isEnabled('softdeleteable')) {
			$filters->disable('softdeleteable');
		}

		$result = $this->findBy(criteria: $value, limit: 1);

		if (!$filters->isEnabled('softdeleteable')) {
			$filters->enable('softdeleteable');
		}

		return $result;
	}

	/**
	 * All users marked as deleted 7 or more days ago are collected.
	 *
	 * @return AbstractUser[]
	 */
	public function getUserMarkedAsDeleted (): array
	{
		$filters = $this->getEntityManager()->getFilters();

		// -- Disable softDeleteable filtering
		if ($filters->isEnabled('softdeleteable')) {
			$filters->disable('softdeleteable');
		}

		$query = $this->createQueryBuilder('u');
		$query
			->select('u')
			->where($query->expr()->lte("date_add(u.deletedAt,7,'day')", 'current_timestamp()'))
		;

		$result = $query->getQuery()->getResult();

		// -- Enable softDeleteable filtering
		if (!$filters->isEnabled('softdeleteable')) {
			$filters->enable('softdeleteable');
		}

		return $result;
	}

	/** Mark users as inactive if they have not logged on for more than TWELVE MONTHS. */
	public function markUsersAsInactives (): int
	{
		$query = $this->createQueryBuilder('u');

		$query
			->update()
			->set('u.isInactive', true)
			->where($query->expr()->lte("date_add(u.lastConnection,12,'month')", 'current_timestamp()'))
			->andWhere($query->expr()->eq('u.isInactive', false))
		;

		return (int)$query->getQuery()->execute();
	}

	/**
	 * Get inactive users who meet the requirement for the first notice.
	 *
	 * @return AbstractUser[]
	 */
	public function getInactiveUsersFirstNotice (): array
	{
		$query = $this->createQueryBuilder('u');

		$query
			->select('u')
			->where($query->expr()->lte("date_add(u.lastConnection,15,'month')", 'current_timestamp()'))
			->andWhere($query->expr()->gte("date_add(u.lastConnection,18,'month')", 'current_timestamp()'))
			->andWhere($query->expr()->eq('u.isInactive', true))
		;

		return $query->getQuery()->getResult();
	}

	/**
	 * Get inactive users who meet the requirement for the second notice.
	 *
	 * @return AbstractUser[]
	 */
	public function getInactiveUsersSecondNotice (): array
	{
		$query = $this->createQueryBuilder('u');

		$query
			->select('u')
			->where($query->expr()->lte("date_add(u.lastConnection,18,'month')", 'current_timestamp()'))
			->andWhere($query->expr()->gte("date_add(u.lastConnection,21,'month')", 'current_timestamp()'))
			->andWhere($query->expr()->eq('u.isInactive', true))
		;

		return $query->getQuery()->getResult();
	}

	/**
	 * Get inactive users who meet the requirement for the last notice.
	 *
	 * @return AbstractUser[]
	 */
	public function getInactiveUsersLastNotice (): array
	{
		$query = $this->createQueryBuilder('u');

		$query
			->select('u')
			->where($query->expr()->lte("date_add(u.lastConnection,21,'month')", 'current_timestamp()'))
			->andWhere($query->expr()->eq('u.isInactive', true))
		;

		return $query->getQuery()->getResult();
	}

	/**
	 * We are looking for users who have been inactive for 24 months.
	 * And proceed to delete the user
	 *
	 * @return AbstractUser[]
	 */
	public function getUserInactives (): array
	{
		$query = $this->createQueryBuilder('u');
		$query
			->select('u')
			->where($query->expr()->lte("date_add(u.lastConnection,24,'month')", 'current_timestamp()'))
			->andWhere($query->expr()->eq('u.isInactive', true))
		;

		return $query->getQuery()->getResult();
	}
}
