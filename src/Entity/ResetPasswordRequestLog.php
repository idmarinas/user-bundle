<?php
/**
 * Copyright 2024 (C) IDMarinas - All Rights Reserved
 *
 * Last modified by "IDMarinas" on 05/12/2024, 21:47
 *
 * @project IDMarinas User Bundle
 * @see     https://github.com/idmarinas/user-bundle
 *
 * @file    ResetPasswordRequestLog.php
 * @date    05/12/2024
 * @time    21:47
 *
 * @author  Iván Diaz Marinas (IDMarinas)
 * @license BSD 3-Clause License
 *
 * @since   1.1.0
 */

namespace Idm\Bundle\User\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Loggable\Entity\MappedSuperclass\AbstractLogEntry;

#[ORM\Entity]
#[ORM\Table(name: 'idm_user_reset_password_request_log', options: ['row_format' => 'DYNAMIC'])]
#[ORM\Index(columns: ['object_class'], name: 'log_class_lookup_idx')]
#[ORM\Index(columns: ['logged_at'], name: 'log_date_lookup_idx')]
#[ORM\Index(columns: ['username'], name: 'log_user_lookup_idx')]
#[ORM\Index(columns: ['object_id', 'object_class', 'version'], name: 'log_version_lookup_idx')]
class ResetPasswordRequestLog extends AbstractLogEntry
{
	/* All required columns are mapped through inherited superclass */
}
