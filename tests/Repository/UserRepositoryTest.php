<?php
/**
 * Copyright 2024 (C) IDMarinas - All Rights Reserved
 *
 * Last modified by "IDMarinas" on 30/12/2024, 17:17
 *
 * @project IDMarinas User Bundle
 * @see     https://github.com/idmarinas/user-bundle
 *
 * @file    UserRepositoryTest.php
 * @date    03/12/2024
 * @time    16:27
 *
 * @author  Iván Diaz Marinas (IDMarinas)
 * @license BSD 3-Clause License
 *
 * @since   2.0.0
 */

namespace Idm\Bundle\User\Tests\Repository;

use App\Entity\User\FakeUser;
use App\Entity\User\User;
use App\Repository\User\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Mapping\ClassMetadata;
use Doctrine\ORM\Persisters\Entity\EntityPersister;
use Doctrine\ORM\Query;
use Doctrine\ORM\Query\Expr;
use Doctrine\ORM\Query\FilterCollection;
use Doctrine\ORM\QueryBuilder;
use Doctrine\ORM\UnitOfWork;
use Doctrine\Persistence\ManagerRegistry;
use Idm\Bundle\Common\Traits\Tool\FakerTrait;
use PHPUnit\Framework\TestCase;
use ReflectionException;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;

class UserRepositoryTest extends TestCase
{
	use FakerTrait;

	/**
	 * @throws ReflectionException
	 */
	public function testUpgradePasswordSuccess ()
	{
		/** @var User $userO */
		$userO = $this->populateEntity(new User());

		// Check change password
		$user = clone $userO;
		$password = $this->faker->password();
		$repository = $this->getRepository();
		$repository->upgradePassword($user, $password);

		$this->assertNotEquals($userO, $user);
		$this->assertNotEquals($password, $userO->getPassword());
		$this->assertEquals($password, $user->getPassword());
	}

	public function testUpgradePasswordFail ()
	{
		$this->expectException(UnsupportedUserException::class);
		$repository = $this->getRepository();
		$password = $this->faker()->password();
		$repository->upgradePassword(new FakeUser(), $password);
	}

	public function testUniqueUserEmailSuccess ()
	{
		$repository = $this->getRepository();
		$result = $repository->uniqueUserEmail(['email' => 'test@test.com']);
		$this->assertEmpty($result);
	}

	public function testInactiveUsersFirstNotice ()
	{
		$repository = $this->getRepository();

		$result = $repository->getInactiveUsersFirstNotice();

		$this->assertCount(3, $result);
	}

	public function testInactiveUsersSecondNotice ()
	{
		$repository = $this->getRepository();

		$result = $repository->getInactiveUsersSecondNotice();

		$this->assertCount(3, $result);
	}

	public function testInactiveUsersLastNotice ()
	{
		$repository = $this->getRepository();

		$result = $repository->getInactiveUsersLastNotice();

		$this->assertCount(3, $result);
	}

	public function testUserInactives ()
	{
		$repository = $this->getRepository();

		$result = $repository->getUserInactives();

		$this->assertCount(3, $result);
	}

	public function testUserMarkedAsDeleted ()
	{
		$repository = $this->getRepository();

		$result = $repository->getUserMarkedAsDeleted();

		$this->assertCount(3, $result);
	}

	public function testMarkUsersAsInactives ()
	{
		$repository = $this->getRepository();

		$result = $repository->markUsersAsInactives();

		$this->assertEquals(5, $result);
	}

	private function getRepository (): UserRepository
	{
		// Create mocks
		$classMetadata = $this->getMockBuilder(ClassMetadata::class)->setConstructorArgs([User::class])->getMock();
		$entityManager = $this->createMock(EntityManagerInterface::class);
		$managerRegistry = $this->createMock(ManagerRegistry::class);
		$entityRepository = $this->createMock(EntityRepository::class);
		$filters = $this->createMock(FilterCollection::class);
		$persister = $this->createMock(EntityPersister::class);
		$unitOfWork = $this->createMock(UnitOfWork::class);
		$queryBuilder = $this->createMock(QueryBuilder::class);
		$expr = $this->createMock(Expr::class);
		$query = $this->createMock(Query::class);

		// Configure FilterCollection
		$filters->method('isEnabled')->with('softdeleteable')->willReturn(true, false);

		// Configure EntityPersister
		$persister->method('loadAll')->willReturn([]);

		// Configure QueryBuilder
		$queryBuilder->method('select')->willReturn($queryBuilder);
		$queryBuilder->method('update')->willReturn($queryBuilder);
		$queryBuilder->method('from')->willReturn($queryBuilder);
		$queryBuilder->method('set')->willReturn($queryBuilder);
		$queryBuilder->method('where')->willReturn($queryBuilder);
		$queryBuilder->method('orWhere')->willReturn($queryBuilder);
		$queryBuilder->method('andWhere')->willReturn($queryBuilder);
		$queryBuilder->method('expr')->willReturn($expr);
		$queryBuilder->method('getQuery')->willReturn($query);

		// Configure Query
		$query->method('getResult')->willReturn([[], [], []]);
		$query->method('execute')->willReturn(5);

		// Configure EntityManagerInterface
		$entityManager->method('getClassMetadata')->willReturn($classMetadata);
		$entityManager->method('getFilters')->willReturn($filters);
		$entityManager->method('getUnitOfWork')->willReturn($unitOfWork);
		$entityManager->method('createQueryBuilder')->willReturn($queryBuilder);

		// Configure UnitOfWork
		$unitOfWork->method('getEntityPersister')->willReturn($persister);

		//Configure ManagerRegistry
		$managerRegistry->method('getRepository')->willReturn($entityRepository);
		$managerRegistry->method('getManagerForClass')->willReturn($entityManager);

		return new UserRepository($managerRegistry, User::class);
	}
}
