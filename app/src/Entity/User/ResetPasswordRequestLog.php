<?php
/**
 * Copyright 2024-2025 (C) IDMarinas - All Rights Reserved
 *
 * Last modified by "IDMarinas" on 09/01/2025, 17:56
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
 * @since   2.0.0
 */

namespace App\Entity\User;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Loggable\Entity\MappedSuperclass\AbstractLogEntry;
use Gedmo\Loggable\Entity\Repository\LogEntryRepository;

#[ORM\Entity(repositoryClass: LogEntryRepository::class)]
#[ORM\Table(name: 'idm_user_reset_password_request_log', options: ['row_format' => 'DYNAMIC'])]
#[ORM\Index(name: 'idm_user_reset_password_request_log_class_lookup_idx', columns: ['object_class'])]
#[ORM\Index(name: 'idm_user_reset_password_request_log_date_lookup_idx', columns: ['logged_at'])]
#[ORM\Index(name: 'idm_user_reset_password_request_log_user_lookup_idx', columns: ['username'])]
#[ORM\Index(name: 'idm_user_reset_password_request_log_version_lookup_idx', columns: [
	'object_id',
	'object_class',
	'version',
])]
class ResetPasswordRequestLog extends AbstractLogEntry
{
	/* All required columns are mapped through inherited superclass */
}
