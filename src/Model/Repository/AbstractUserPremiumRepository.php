<?php

/**
 * Copyright 2024 (C) IDMarinas - All Rights Reserved
 *
 * Last modified by "IDMarinas" on 22/12/2024, 23:01
 *
 * @project IDMarinas User Bundle
 * @see     https://github.com/idmarinas/user-bundle
 *
 * @file    AbstractUserPremiumRepository.php
 * @date    01/12/2024
 * @time    18:40
 *
 * @author  Iván Diaz Marinas (IDMarinas)
 * @license BSD 3-Clause License
 *
 * @since   2.0.0
 */

namespace Idm\Bundle\User\Model\Repository;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Idm\Bundle\User\Model\Entity\AbstractUserPremium;

/**
 * @extends ServiceEntityRepository<AbstractUserPremium>
 *
 * @method AbstractUserPremium|null find($id, $lockMode = null, $lockVersion = null)
 * @method AbstractUserPremium|null findOneBy(array $criteria, array $orderBy = null)
 * @method AbstractUserPremium[]    findAll()
 * @method AbstractUserPremium[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AbstractUserPremiumRepository extends ServiceEntityRepository {}
