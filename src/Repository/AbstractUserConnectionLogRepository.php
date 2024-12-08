<?php
/**
 * Copyright 2024 (C) IDMarinas - All Rights Reserved
 *
 * Last modified by "IDMarinas" on 08/12/2024, 20:22
 *
 * @project IDMarinas User Bundle
 * @see     https://github.com/idmarinas/user-bundle
 *
 * @file    AbstractUserConnectionLogRepository.php
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
use Idm\Bundle\User\Model\AbstractUserConnectionLog;

/**
 * @extends ServiceEntityRepository<AbstractUserConnectionLog>
 *
 * @method AbstractUserConnectionLog|null find($id, $lockMode = null, $lockVersion = null)
 * @method AbstractUserConnectionLog|null findOneBy(array $criteria, array $orderBy = null)
 * @method AbstractUserConnectionLog[]    findAll()
 * @method AbstractUserConnectionLog[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AbstractUserConnectionLogRepository extends ServiceEntityRepository {}
