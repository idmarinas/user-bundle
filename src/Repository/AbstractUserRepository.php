<?php

/**
 * This file is part of Bundle "IdmUserBundle".
 *
 * @see https://github.com/idmarinas/user-bundle/
 *
 * @license https://github.com/idmarinas/user-bundle/blob/master/LICENSE.txt
 * @author Iván Diaz Marinas (IDMarinas)
 *
 * @since 1.0.0
 */

namespace Idm\Bundle\User\Repository;

use Idm\Bundle\User\Model\AbstractUser;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
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
    public function save(AbstractUser $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(AbstractUser $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    /**
     * Used to upgrade (rehash) the user's password automatically over time.
     */
    public function upgradePassword(PasswordAuthenticatedUserInterface $user, string $newHashedPassword): void
    {
        if ( ! $user instanceof AbstractUser) {
            throw new UnsupportedUserException(sprintf('Instances of "%s" are not supported.', $user::class));
        }

        $newPassword = $this->userPasswordHasher->hashPassword($user, $newHashedPassword);

        $user->setPassword($newPassword);

        $this->save($user, true);
    }

    /** Función para determinar si hay otro usuario con el mismo email teniendo en cuenta los marcados como borrados */
    public function uniqueUserEmail($value): array
    {
        $filters = $this->getEntityManager()->getFilters();

        if ($filters->isEnabled('softdeleteable')) {
            $filters->disable('softdeleteable');
        }

        $result = $this->findBy(criteria: $value, limit: 1);

        if ( ! $filters->isEnabled('softdeleteable')) {
            $filters->enable('softdeleteable');
        }

        return $result;
    }

    /**
     * Se recopilan todos los usuarios marcados como borrados hace 7 o más días.
     *
     * @return AbstractUser[]
     */
    public function getUserMarkedAsDeleted(): array
    {
        $filters = $this->_em->getFilters();

        // -- Desactivar el filtro de softDeleteable
        if ($filters->isEnabled('softdeleteable')) {
            $filters->disable('softdeleteable');
        }

        $query = $this->createQueryBuilder('u');
        $query->select('u')
            ->where($query->expr()->lte("date_add(u.deletedAt,7,'day')", 'current_timestamp()'))
        ;

        $result = $query->getQuery()->getResult();

        // -- Activar el filtro de softDeleteable
        if ( ! $filters->isEnabled('softdeleteable')) {
            $filters->enable('softdeleteable');
        }

        return $result;
    }

    /** Marcar usuarios como inactivos si llevan más de DOCE MESES sin conectar */
    public function markUsersAsInactives(): int
    {
        $query = $this->createQueryBuilder('u');

        $query->update()
            ->set('u.isInactive', true)
            ->where($query->expr()->lte("date_add(u.lastConnection,12,'month')", 'current_timestamp()'))
            ->andWhere($query->expr()->eq('u.isInactive', false))
        ;

        return (int) $query->getQuery()->execute();
    }

    /**
     * Obtener usuarios inactivos que cumplen el requisito para el primer aviso.
     *
     * @return AbstractUser[]
     */
    public function getInactiveUsersFirstNotice(): array
    {
        $query = $this->createQueryBuilder('u');

        $query->select('u')
            ->where($query->expr()->lte("date_add(u.lastConnection,15,'month')", 'current_timestamp()'))
            ->andWhere($query->expr()->gte("date_add(u.lastConnection,18,'month')", 'current_timestamp()'))
            ->andWhere($query->expr()->eq('u.isInactive', true))
        ;

        return $query->getQuery()->getResult();
    }

    /**
     * Obtener usuarios inactivos que cumplen el requisito para el segundo aviso.
     *
     * @return AbstractUser[]
     */
    public function getInactiveUsersSecondNotice(): array
    {
        $query = $this->createQueryBuilder('u');

        $query->select('u')
            ->where($query->expr()->lte("date_add(u.lastConnection,18,'month')", 'current_timestamp()'))
            ->andWhere($query->expr()->gte("date_add(u.lastConnection,21,'month')", 'current_timestamp()'))
            ->andWhere($query->expr()->eq('u.isInactive', true))
        ;

        return $query->getQuery()->getResult();
    }

    /**
     * Obtener usuarios inactivos que cumplen el requisito para el último aviso.
     *
     * @return AbstractUser[]
     */
    public function getInactiveUsersLastNotice(): array
    {
        $query = $this->createQueryBuilder('u');

        $query->select('u')
            ->where($query->expr()->lte("date_add(u.lastConnection,21,'month')", 'current_timestamp()'))
            ->andWhere($query->expr()->eq('u.isInactive', true))
        ;

        return $query->getQuery()->getResult();
    }

    /**
     * Se buscan usuarios que lleven 24 meses inactivos.
     * Y se procede a borrar al usuario
     *
     * @return AbstractUser[]
     */
    public function getUserInactives(): array
    {
        $query = $this->createQueryBuilder('u');
        $query->select('u')
            ->where($query->expr()->lte("date_add(u.lastConnection,24,'month')", 'current_timestamp()'))
            ->andWhere($query->expr()->eq('u.isInactive', true))
        ;

        return $query->getQuery()->getResult();
    }
}
