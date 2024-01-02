<?php

/**
 * This file is part of Bundle "IdmUserBundle".
 *
 * @see https://github.com/idmarinas/user-bundle/
 *
 * @license https://github.com/idmarinas/user-bundle/blob/master/LICENSE.txt
 * @author Iván Diaz Marinas (IDMarinas)
 *
 * @since 1.0.0
 */

namespace Idm\Bundle\User\Tests;

use Idm\Bundle\User\IdmUserBundle;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Nyholm\BundleTest\TestKernel;
use Symfony\Component\HttpKernel\KernelInterface;

class BundleInitializationTest extends KernelTestCase
{
    protected static function getKernelClass(): string
    {
        return TestKernel::class;
    }

    protected static function createKernel(array $options = []): KernelInterface
    {
        /**
         * @var TestKernel $kernel
         */
        $kernel = parent::createKernel($options);
        $kernel->addTestBundle(IdmUserBundle::class);
        $kernel->handleOptions($options);

        return $kernel;
    }

    public function testInitBundle(): void
    {
        // Boot the kernel.
        self::bootKernel();

        $this->assertTrue(true);
    }

    // public function testBundleWithDifferentConfiguration(): void
    // {
    //     // Boot the kernel with a config closure, the handleOptions call in createKernel is important for that to work
    //     $kernel = self::bootKernel(['config' => static function(TestKernel $kernel){
    //         // Add some other bundles we depend on
    //         $kernel->addTestBundle(OtherBundle::class);

    //         // Add some configuration
    //         $kernel->addTestConfig(__DIR__.'/config.yml');
    //     }]);

    //     // ...
    // }
}
