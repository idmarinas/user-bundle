<!--suppress HtmlDeprecatedAttribute -->
<div align="center">

# IDMarinas User Bundle

</div>

> A User Bundle to manage user basics without having to configure everything for each project, comes with a password
> reset and email verification system.

<br />

<div align="center">

[![Test Suite](https://img.shields.io/github/actions/workflow/status/idmarinas/user-bundle/php.yml?style=for-the-badge&logo=github&logoColor=white&label=Bundle%20Test%20Suite
)](https://github.com/idmarinas/user-bundle/actions/workflows/php.yml)
[![Quality Gate Status](https://img.shields.io/sonar/quality_gate/idmarinas_user-bundle?server=https%3A%2F%2Fsonarcloud.io&style=for-the-badge&logo=sonarcloud&logoColor=white)](https://sonarcloud.io/summary/new_code?id=idmarinas_user-bundle)
[![Coverage](https://img.shields.io/sonar/coverage/idmarinas_user-bundle?server=https%3A%2F%2Fsonarcloud.io&style=for-the-badge&logo=sonarcloud&logoColor=white)](https://sonarcloud.io/dashboard?id=idmarinas_user-bundle)
[![Technical Debt](https://img.shields.io/sonar/tech_debt/idmarinas_user-bundle?server=https%3A%2F%2Fsonarcloud.io&style=for-the-badge&logo=sonarcloud&logoColor=white)](https://sonarcloud.io/dashboard?id=idmarinas_user-bundle)

<br />

![GitHub release](https://img.shields.io/github/release/idmarinas/user-bundle.svg?style=for-the-badge)
![GitHub Release Date](https://img.shields.io/github/release-date/idmarinas/user-bundle.svg?style=for-the-badge)
![Github commits (since latest release)](https://img.shields.io/github/commits-since/idmarinas/user-bundle/latest.svg?style=for-the-badge)
![GitHub commit activity](https://img.shields.io/github/commit-activity/w/idmarinas/user-bundle.svg?style=for-the-badge)
![GitHub last commit](https://img.shields.io/github/last-commit/idmarinas/user-bundle.svg?style=for-the-badge)

#### Code analysis

[![Reliability Rating](https://sonarcloud.io/api/project_badges/measure?project=idmarinas_user-bundle&metric=reliability_rating)](https://sonarcloud.io/dashboard?id=idmarinas_user-bundle)
[![Bugs](https://sonarcloud.io/api/project_badges/measure?project=idmarinas_user-bundle&metric=bugs)](https://sonarcloud.io/dashboard?id=idmarinas_user-bundle)
[![Security Rating](https://sonarcloud.io/api/project_badges/measure?project=idmarinas_user-bundle&metric=security_rating)](https://sonarcloud.io/dashboard?id=idmarinas_user-bundle)
[![Vulnerabilities](https://sonarcloud.io/api/project_badges/measure?project=idmarinas_user-bundle&metric=vulnerabilities)](https://sonarcloud.io/dashboard?id=idmarinas_user-bundle)
[![Maintainability Rating](https://sonarcloud.io/api/project_badges/measure?project=idmarinas_user-bundle&metric=sqale_rating)](https://sonarcloud.io/dashboard?id=idmarinas_user-bundle)
[![Code Smells](https://sonarcloud.io/api/project_badges/measure?project=idmarinas_user-bundle&metric=code_smells)](https://sonarcloud.io/dashboard?id=idmarinas_user-bundle)
[![Duplicated Lines (%)](https://sonarcloud.io/api/project_badges/measure?project=idmarinas_user-bundle&metric=duplicated_lines_density)](https://sonarcloud.io/dashboard?id=idmarinas_user-bundle)

</div>

> ## 🖖 Support
>
> 🩵 If you like this project, give it a 🌟 and share it with your friends!
>
> [![PayPal.Me - The safer, easier way to pay online!](https://img.shields.io/badge/donate-help_my_projects-ffaa29.svg?style=for-the-badge&logo=paypal&cacheSeconds=86400)](https://www.paypal.me/idmarinas)
> [![Liberapay - Donate](https://img.shields.io/liberapay/receives/IDMarinas.svg?style=for-the-badge&logo=liberapay&cacheSeconds=86400)](https://liberapay.com/IDMarinas/donate)
> [![Static Badge](https://img.shields.io/badge/Sponsor-ea4aaa?style=for-the-badge&logo=github&logoColor=white)](https://github.com/sponsors/idmarinas)

<br />

# 💾 Installation

Make sure Composer is installed globally, as explained in the
[installation chapter](https://getcomposer.org/doc/00-intro.md)
of the Composer documentation.

## 💪 Applications that use Symfony Flex

Open a command console, enter your project directory and execute:

```console
$ composer require idmarinas/user-bundle
```

## 🚫 Applications that don't use Symfony Flex

### Step 1️⃣: Download the Bundle

Open a command console, enter your project directory and execute the
following command to download the latest stable version of this bundle:

```console
$ composer require idmarinas/user-bundle
```

### Step2️⃣: Enable the Bundle

Then, enable the bundle by adding it to the list of registered bundles
in the `config/bundles.php` file of your project:

```php
// config/bundles.php

return [
    // ...
    Idm\Bundle\User\IdmUserBundle::class => ['all' => true],
];
```

## 🖱️ Tech used in code

![GitHub code size in bytes](https://img.shields.io/github/languages/code-size/idmarinas/user-bundle.svg?style=for-the-badge)
[![PHP](https://img.shields.io/badge/php-%23777BB4.svg?style=for-the-badge&logo=php&logoColor=white)](https://www.php.net)
[![Doctrine](https://img.shields.io/badge/doctrine-fa6a3c?style=for-the-badge&logo=doctrine&logoColor=white)](https://www.doctrine-project.org)
[![Symfony](https://img.shields.io/badge/symfony-black.svg?style=for-the-badge&logo=symfony&logoColor=white)](https://www.symfony.com)

## 🛠️ Tools used for create this project

![Dependabot](https://img.shields.io/badge/dependabot-025E8C?style=for-the-badge&logo=dependabot&logoColor=white)
[![GitHub Actions](https://img.shields.io/badge/github%20actions-%232671E5.svg?style=for-the-badge&logo=githubactions&logoColor=white)](https://github.com/features/actions)
[![Docker](https://img.shields.io/badge/docker-%230db7ed.svg?style=for-the-badge&logo=docker&logoColor=white)](https://www.docker.com)
