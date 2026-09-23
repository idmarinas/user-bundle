<?php
/**
 * Copyright 2025-2026 (C) IDMarinas - All Rights Reserved
 *
 * Last modified by "IDMarinas" on 23/09/2026, 21:05
 *
 * @project IDMarinas User Bundle
 * @see     https://github.com/idmarinas/user-bundle
 *
 * @file    Connections.php
 * @date    09/01/2025
 * @time    17:04
 *
 * @author  Iván Diaz Marinas (IDMarinas)
 * @license BSD 3-Clause License
 *
 * @since   2.0.0
 */

namespace App\Entity\User;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Idm\Bundle\User\Model\Entity\AbstractConnections;

#[ORM\Entity]
#[ORM\Table(name: 'idm_user_connections')]
#[Gedmo\Loggable(logEntryClass: ConnectionsLog::class)]
class Connections extends AbstractConnections {}
