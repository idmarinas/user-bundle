[![Test Suite](https://github.com/idmarinas/user-bundle/actions/workflows/php.yml/badge.svg)](https://github.com/idmarinas/user-bundle/actions/workflows/php.yml)
[![Quality Gate Status](https://sonarcloud.io/api/project_badges/measure?project=idmarinas_user-bundle&metric=alert_status)](https://sonarcloud.io/summary/new_code?id=idmarinas_user-bundle)

![GitHub release](https://img.shields.io/github/release/idmarinas/user-bundle.svg)
![GitHub Release Date](https://img.shields.io/github/release-date/idmarinas/user-bundle.svg)
![GitHub code size in bytes](https://img.shields.io/github/languages/code-size/idmarinas/user-bundle.svg)

![GitHub issues](https://img.shields.io/github/issues/idmarinas/user-bundle.svg)
![GitHub pull requests](https://img.shields.io/github/issues-pr/idmarinas/user-bundle.svg)
![Github commits (since latest release)](https://img.shields.io/github/commits-since/idmarinas/user-bundle/latest.svg)
![GitHub commit activity](https://img.shields.io/github/commit-activity/w/idmarinas/user-bundle.svg)
![GitHub last commit](https://img.shields.io/github/last-commit/idmarinas/user-bundle.svg)

![GitHub top language](https://img.shields.io/github/languages/top/idmarinas/user-bundle.svg)
![GitHub language count](https://img.shields.io/github/languages/count/idmarinas/user-bundle.svg)

[![Reliability Rating](https://sonarcloud.io/api/project_badges/measure?project=idmarinas_user-bundle&metric=reliability_rating)](https://sonarcloud.io/dashboard?id=idmarinas_user-bundle)
[![Bugs](https://sonarcloud.io/api/project_badges/measure?project=idmarinas_user-bundle&metric=bugs)](https://sonarcloud.io/dashboard?id=idmarinas_user-bundle)
[![Security Rating](https://sonarcloud.io/api/project_badges/measure?project=idmarinas_user-bundle&metric=security_rating)](https://sonarcloud.io/dashboard?id=idmarinas_user-bundle)
[![Vulnerabilities](https://sonarcloud.io/api/project_badges/measure?project=idmarinas_user-bundle&metric=vulnerabilities)](https://sonarcloud.io/dashboard?id=idmarinas_user-bundle)
[![Maintainability Rating](https://sonarcloud.io/api/project_badges/measure?project=idmarinas_user-bundle&metric=sqale_rating)](https://sonarcloud.io/dashboard?id=idmarinas_user-bundle)
[![Technical Debt](https://sonarcloud.io/api/project_badges/measure?project=idmarinas_user-bundle&metric=sqale_index)](https://sonarcloud.io/dashboard?id=idmarinas_user-bundle)
[![Code Smells](https://sonarcloud.io/api/project_badges/measure?project=idmarinas_user-bundle&metric=code_smells)](https://sonarcloud.io/dashboard?id=idmarinas_user-bundle)
[![Coverage](https://sonarcloud.io/api/project_badges/measure?project=idmarinas_user-bundle&metric=coverage)](https://sonarcloud.io/dashboard?id=idmarinas_user-bundle)
[![Duplicated Lines (%)](https://sonarcloud.io/api/project_badges/measure?project=idmarinas_user-bundle&metric=duplicated_lines_density)](https://sonarcloud.io/dashboard?id=idmarinas_user-bundle)

![Dependabot](https://img.shields.io/badge/dependabot-025E8C?style=flat&logo=dependabot&logoColor=white)
[![PHP](https://img.shields.io/badge/php-%23777BB4.svg?style=flat&logo=php&logoColor=white)](https://www.php.net)
[![Doctrine](https://img.shields.io/badge/doctrine-fa6a3c?style=flat&logo=doctrine&logoColor=white)](https://www.doctrine-project.org)
[![Symfony](https://img.shields.io/badge/symfony-black.svg?style=flat&logo=symfony&logoColor=white)](https://www.symfony.com)

[![PayPal.Me - The safer, easier way to pay online!](https://img.shields.io/badge/donate-help_my_project-ffaa29.svg?logo=paypal&cacheSeconds=86400)](https://www.paypal.me/idmarinas)
[![Liberapay - Donate](https://img.shields.io/liberapay/receives/IDMarinas.svg?logo=liberapay&cacheSeconds=86400)](https://liberapay.com/IDMarinas/donate)
[![Twitter](https://img.shields.io/twitter/url/http/shields.io.svg?style=social&cacheSeconds=86400)](https://x.com/idmarinas)

# IDMarinas User Bundle

# 💾 Installation

Make sure Composer is installed globally, as explained in the
[installation chapter](https://getcomposer.org/doc/00-intro.md)
of the Composer documentation.

## 💪 Applications that use Symfony Flex

Open a command console, enter your project directory and execute:

```console
$ composer require idmarinas/user-bundle
```

## Applications that don't use Symfony Flex

### Step 1: Download the Bundle

Open a command console, enter your project directory and execute the
following command to download the latest stable version of this bundle:

```console
$ composer require idmarinas/user-bundle
```

### Step 2: Enable the Bundle

Then, enable the bundle by adding it to the list of registered bundles
in the `config/bundles.php` file of your project:

```php
// config/bundles.php

return [
    // ...
    Idm\Bundle\User\IdmUserBundle::class => ['all' => true],
];
```
