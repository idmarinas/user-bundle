# Quickstart

<secondary-label ref="2.0.0" />

This is a quick way to start using the %project% in your project.
{id="summary"}

## Before you start

> You need to have `Symfony maker` and `IDMarinas maker` installed to be able to use the following commands.
> {style="warning"}

```console
composer require --dev symfony/maker-bundle
composer require --dev idmarinas/maker-bundle
```

## Install

```console
php bin/symfony make:idm:user:bundle
```

<procedure title="These files are installed in the default folders" id="maker">
	<step>The Doctrine entities</step>
	<step>The form types</step>
	<step>The controller to be able to register/login/recover password/profile</step>
  <step>User checker for regular and admin users</step>
	<step>The administration controllers for EasyCorp EasyAdmin</step>
	<p>Congratulation! you have installed %project%.</p>
</procedure>
