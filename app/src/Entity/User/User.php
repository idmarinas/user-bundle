<?php
/**
 * Copyright 2024-2025 (C) IDMarinas - All Rights Reserved
 *
 * Last modified by "IDMarinas" on 09/01/2025, 17:56
 *
 * @project IDMarinas User Bundle
 * @see     https://github.com/idmarinas/user-bundle
 *
 * @file    User.php
 * @date    05/12/2024
 * @time    17:46
 *
 * @author  Iván Diaz Marinas (IDMarinas)
 * @license BSD 3-Clause License
 *
 * @since   2.0.0
 */

namespace App\Entity\User;

use App\Repository\User\UserRepository;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Idm\Bundle\User\Model\Entity\AbstractUser;
use Idm\Bundle\User\Traits\Entity\IDMarinasProviderTrait;
use Idm\Bundle\User\Traits\Entity\UserPremiumTrait;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\Table(name: 'idm_user_user')]
#[Gedmo\Loggable(logEntryClass: Log::class)]
class User extends AbstractUser
{
    use IDMarinasProviderTrait;
    use UserPremiumTrait;
}
