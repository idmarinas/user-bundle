<?php

/**
 * Copyright 2024 (C) IDMarinas - All Rights Reserved
 *
 * Last modified by "IDMarinas" on 1/12/24, 18:44
 *
 * @project IDMarinas User Bundle
 * @see     https://github.com/idmarinas/user-bundle
 *
 * @file    UserPremiumRepository.php
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
use Idm\Bundle\User\Entity\AbstractUserPremium;

/**
 * @extends ServiceEntityRepository<AbstractUserPremium>
 *
 * @method AbstractUserPremium|null find($id, $lockMode = null, $lockVersion = null)
 * @method AbstractUserPremium|null findOneBy(array $criteria, array $orderBy = null)
 * @method AbstractUserPremium[]    findAll()
 * @method AbstractUserPremium[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AbstractUserPremiumRepository extends ServiceEntityRepository {}