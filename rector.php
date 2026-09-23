<?php
/**
 * Copyright $originalComment.match("Copyright (\d+)", 1, "-",$today.year)2026 (C) IDMarinas - All Rights Reserved
 *
 * Last modified by "IDMarinas" on 23/09/2026, 18:02
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

return RectorConfig::configure()
	->withPaths([
		__DIR__.'/app',
		__DIR__.'/config',
		__DIR__.'/factories',
		__DIR__.'/fixtures',
		__DIR__.'/src',
		__DIR__.'/tests',
	])
	// uncomment to reach your current PHP version
	->withPhpSets(php82: true)
	->withPreparedSets(
		phpunitCodeQuality : true,
		doctrineCodeQuality: true,
		symfonyCodeQuality : true,
		symfonyConfigs     : true
	)
	->withTypeCoverageLevel(0)
	->withDeadCodeLevel(0)
	->withCodeQualityLevel(0)
	->withImportNames(importDocBlockNames: false)
	->withComposerBased(twig: true, doctrine: true, symfony: true)
	->withSymfonyContainerXml(__DIR__.'/var/cache/web/dev/Core_KernelDevDebugContainer.xml')
	->withSkip([
		__DIR__.'/app/config/bundles.php',
	])
;
