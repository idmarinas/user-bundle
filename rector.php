<?php
/**
 * Copyright 2024 (C) IDMarinas - All Rights Reserved
 *
 * Last modified by "IDMarinas" on 19/12/2024, 16:20
 *
 * @project IDMarinas User Bundle
 * @see     https://github.com/idmarinas/user-bundle
 *
 * @file    rector.php
 * @date    19/12/2024
 * @time    16:21
 *
 * @author  Iván Diaz Marinas (IDMarinas)
 * @license BSD 3-Clause License
 *
 * @since   2.0.0
 */

declare(strict_types=1);

use Rector\Config\RectorConfig;
use Rector\Symfony\Set\SymfonySetList;
use Rector\TypeDeclaration\Rector\ClassMethod\AddVoidReturnTypeWhereNoReturnRector;

return RectorConfig::configure()
	->withPaths([
		__DIR__ . '/src',
		__DIR__ . '/tests',
	])
	->withPhpSets(php81: true)
	->withPreparedSets(
		deadCode           : true,
		codeQuality        : true,
		codingStyle        : true,
		doctrineCodeQuality: true,
		symfonyCodeQuality : true,
		symfonyConfigs     : true,
		twig               : true
	)
	->withImportNames(removeUnusedImports: true)
	->withTypeCoverageLevel(0)
	->withSets([
		SymfonySetList::SYMFONY_54,
		SymfonySetList::SYMFONY_CONSTRUCTOR_INJECTION,
	])
	->withRules([AddVoidReturnTypeWhereNoReturnRector::class])
;
