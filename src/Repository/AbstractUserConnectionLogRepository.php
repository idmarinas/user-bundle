<?php
/**
 * Copyright 2024 (C) IDMarinas - All Rights Reserved
 *
 * Last modified by "IDMarinas" on 1/12/24, 18:44
 *
 * @project IDMarinas User Bundle
 * @see     https://github.com/idmarinas/user-bundle
 *
 * @file    UserConnectionLogRepository.php
 * @date    01/12/2024
 * @time    18:40
 *
 * @author  Iván Diaz Marinas (IDMarinas)
 * @license BSD 3-Clause License
 *
 * @since   1.1.0
 */

namespace Idm\Bundle\User\Repository;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Idm\Bundle\User\Entity\AbstractUserConnectionLog;

/**
 * @extends ServiceEntityRepository<AbstractUserConnectionLog>
 *
 * @method AbstractUserConnectionLog|null find($id, $lockMode = null, $lockVersion = null)
 * @method AbstractUserConnectionLog|null findOneBy(array $criteria, array $orderBy = null)
 * @method AbstractUserConnectionLog[]    findAll()
 * @method AbstractUserConnectionLog[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AbstractUserConnectionLogRepository extends ServiceEntityRepository {}