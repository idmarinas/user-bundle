# Changelog

## 2.3.0 - (2026-10-07)

### Added {id="added_2.3.0"}

**Forms**

* _Added_ `Idm\Bundle\User\Model\Form\AbstractChangePasswordFormType` base of
  `Idm\Bundle\User\Form\ChangePasswordFormType`
* _Added_ `Idm\Bundle\User\Model\Form\AbstractResetPasswordFormType` base of
  `Idm\Bundle\User\Form\ResetPasswordFormType`
* _Added_ `Idm\Bundle\User\Model\Form\AbstractResetPasswordRequestFormType` base of
  `Idm\Bundle\User\Form\ResetPasswordRequestFormType`
* _Added_ `Idm\Bundle\User\Form\RegistrationFormType` extending
  `Idm\Bundle\User\Model\Form\AbstractRegistrationFormType`

**Controllers**

* _Added_ concrete controllers `Idm\Bundle\User\Controller\LoginController`,
  `Idm\Bundle\User\Controller\ProfileController`, `Idm\Bundle\User\Controller\RegistrationController` and
  `Idm\Bundle\User\Controller\ResetPasswordController`, extending the corresponding `Abstract*Controller` base
  classes. The bundle now works out of the box: import `@IdmUserBundle/config/routes.php` in your application to get
  all user routes.

**Routing**

* _Added_ `config/routes.php` importing the four default controllers with the `/user` path prefix and the `idm_user_`
  route name prefix (`idm_user_login_web`, `idm_user_profile_index`, `idm_user_registration_register_web`,
  `idm_user_forgot_password_request`, ...)

**Services**

* _Added_ explicit service definitions for the default controllers in `config/services.php`, following the Symfony
  best practices for bundles (no autowiring/autoconfiguration):
  * private services identified by the class, made public by the `controller.service_arguments` tag
  * `container.service_subscriber` tag and a `setContainer(ContainerInterface)` method call, so the controller receives
    the service subscriber locator instead of the raw container
  * action arguments (`AuthenticationUtils`, `EntityManagerInterface`, ...) are still injected by type thanks to the
    controller argument locators

**Tests**

* _Added_ `App\Controller\LoginController` in the test application is kept as an example that overrides the default
  controller (importing `routes/login.php` after `@IdmUserBundle/config/routes.php` wins over the bundle route)

### Changed {id="changed_2.3.0"}

**Entities**

* _Changed_ `Idm\Bundle\User\Model\Entity\AbstractUser` and `Idm\Bundle\User\Model\Entity\AbstractConnections` now
  no use trait `Idm\Bundle\Common\Traits\Entity\UuidTrait` by default; you can add the trait `UuidTrait` or
  `IdTrait` to your entity class.
* _Changed_ `Idm\Bundle\User\Model\Entity\AbstractUser`
  * `Idm\Bundle\User\Traits\Entity\EquatableTrait` is now optional; you can add the trait `EquatableTrait` to your
    entity class.
  * `Gedmo\IpTraceable\Traits\IpTraceableEntity` is now optional; you can add the trait `IpTraceableEntity` to your
    entity class.
  * `Gedmo\SoftDeleteable\Traits\SoftDeleteableEntity` is now optional; you can add the trait `SoftDeleteableEntity` to
    your entity class.
  * `AbstractUser` no longer implements `Symfony\Component\Security\Core\User\EquatableInterface`; if you use
    `EquatableTrait`, your entity class must declare it (`implements EquatableInterface`), otherwise Symfony no longer
    compares the session user with `isEqualTo()`.

**Forms**

* _Changed_ the form types of `Idm\Bundle\User\Form` no longer declare `buildForm()` and `configureOptions()`, the
  shared logic was moved to their new abstract base class in `Idm\Bundle\User\Model\Form`
  * `Idm\Bundle\User\Form\ChangePasswordFormType` extends `AbstractChangePasswordFormType`
  * `Idm\Bundle\User\Form\ResetPasswordFormType` extends `AbstractResetPasswordFormType`
  * `Idm\Bundle\User\Form\ResetPasswordRequestFormType` extends `AbstractResetPasswordRequestFormType`

**Admin**

* _Changed_ method `configureFields()` of `AbstractUserCrudController` now only displays the `is_deleted` and
  `deleted_at` fields when the entity class has the `isDeleted()` method and the `deletedAt` property (i.e., it uses
  `SoftDeleteableEntity`).

**Security**

* _Changed_ method `checkPreAuth()` of `AbstractUserChecker` now checks that the `isDeleted()` method exists before
  calling it.

**Repository**

* _Changed_ method `getUserMarkedAsDeleted()` of `AbstractUserRepository` now returns an empty array when the entity
  class has no `deletedAt` property.
* _Changed_ methods `uniqueUserEmail()` and `getUserMarkedAsDeleted()` of `AbstractUserRepository` now restore the
  `softdeleteable` filter only if it was enabled before.

**Tests**

* _Changed_ test code, removed redundant docblocks from test classes
* _Changed_ tests application configuration now registers `TwigComponentBundle` and `TwigExtraBundle`, required by the
  EasyAdmin templates that use `<twig:...>` component syntax
* _Changed_ the test application now uses the default controllers of the bundle; its `login.php`, `profile.php`,
  `registration.php` and `reset_password.php` routing files are only enabled in the override tests
* _Changed_ `BundleRoutingTest` now also verifies the routes `idm_user_profile_index`, `idm_user_change_password`,
  `idm_user_forgot_password_request` and `idm_user_registration_register_web`, and covers the override mechanism (the
  application controllers win when their routing file is imported after the bundle's)

### Fixed {id="fixed_2.3.0"}

* _Fixed_ method `getMostRecentNonExpiredRequestDate()` of `AbstractResetPasswordRequestRepository` no longer forces
  the `uuid` parameter type, so it also works with entities that use `IdTrait`.
* _Fixed_ method `isEqualTo()` of `EquatableTrait` called `getSessionId()` with the wrong casing.

### Breaking Changes {id="breaking-changes_2.3.0"}

* _Changed_ `Idm\Bundle\User\Model\Entity\AbstractUser` no longer uses traits `EquatableTrait`, `IpTraceableEntity` and
  `SoftDeleteableEntity`
  * Add the traits you need to your entity class; without `EquatableTrait` the user is no longer compared against the
    user stored in the session
* _Changed_ `Idm\Bundle\User\Model\Entity\AbstractUser` no longer implements
  `Symfony\Component\Security\Core\User\EquatableInterface`
  * If you use `EquatableTrait`, declare `implements EquatableInterface` in your entity class; otherwise `isEqualTo()`
    is never called and the session user is not compared
* _Changed_ `Idm\Bundle\User\Model\Entity\AbstractUser` and `Idm\Bundle\User\Model\Entity\AbstractConnections` no longer
  use the trait `UuidTrait`
  * Add the trait `UuidTrait` or `IdTrait` to your entity class to keep the identifier column
* _Changed_ `Idm\Bundle\User\Form\ChangePasswordFormType`, `Idm\Bundle\User\Form\ResetPasswordFormType` and
  `Idm\Bundle\User\Form\ResetPasswordRequestFormType` no longer extend `Symfony\Component\Form\AbstractType`
  * If you override `buildForm()` or `configureOptions()`, your class must extend the new abstract base class

## 2.2.0 - (2026-09-28)

### Added {id="added_2.2.0"}

* _Added_ support for Symfony `^8.0`
* _Added_ method `__serialize()` to `SecurityTrait` to keep the hashed password out of the session storage

### Fixed {id="fixed_2.2.0"}

* _Fixed_ a help text key in `AbstractResetPasswordRequestFormType` from `form.reset_password_request.email.help` to
  `form.forgot_password.email.help`
* _Fixed_ `TranslatableMessage::__toString()` deprecation when building the `reset_password_error` flash message

### Changed {id="changed_2.2.0"}

* _Changed_ GitHub Actions workflow configuration to include `permissions` settings for pull requests
  * Added explicit `read` permission for `contents`
  * Added explicit `write` permission for `pull-requests`
* _Changed_ method `eraseCredentials()` of `SecurityTrait` is now marked with `#[\Deprecated]`
  * Since Symfony `7.3` the framework no longer calls it, credentials are erased in `__serialize()` instead
* _Changed_ method `reset()` of `AbstractResetPasswordController` receives a `TranslatorInterface` to translate the
  `reset_password_error` flash message
* _Changed_ Reorganized tests code
* _Changed_ tests application configuration to remove deprecated options
  * Removed `doctrine.orm.controller_resolver.auto_mapping`
  * Flattened the `senders` level of the `messenger` routing
  * Set `zenstruck_foundry.enable_auto_refresh_with_lazy_objects` only on PHP `8.4+`

### Breaking Changes {id="breaking-changes_1"}

* _Drop_ support for PHP `8.2` version
* _Changed_ signature of `AbstractResetPasswordController::reset()`, a `TranslatorInterface` argument has been added
  * Only required if you override the method or call it directly
* _Changed_ `SecurityTrait` now declares `__serialize()`
  * If your entity already implements it, your implementation takes precedence and the password is no longer excluded

## 2.1.1 - (2025-04-13)

### Deleted {id="deleted_2.1.1"}

* _Deleted_ validation constraints from AbstractUser class

## 2.1.0 - (2025-04-12)

### Added {id="added_2.1.0"}

* _Added_ missing fields `verified`, `inactive`, `terms_accepted`, `privacy_accepted`, `banned_until` and `is_banned` in
  `AbstractSettingsCrudController`

### Changed {id="changed_2.1.0"}

* _Changed_ method `configureFields()` of `AbstractUserCrudController`
  * Now return values with keys. **key is the field name in _snake_case_**
  * Form formatting is removed by eliminating tabs, columns, etc.
  * Removed predefined permissions for all fields

### Deleted {id="deleted_2.1.0"}

* _Deleted_ all attributes related to data validation in the `AbstractUser` entity.

## 2.0.7 - (2025-02-27)

### Changed {id="changed_2.0.7"}

* _Changed_ `translations→validators` refactor part of keys

## 2.0.6 - (2025-02-27)

### Fixed {id="fixed_2.0.6"}

* _Fixed_ `AbstractUserCrudController` **IdField** now use `id` name and not `uuid`
* _Fixed_ `AbstractUser` **Validator for username field** now uses a correct message.

## 2.0.5 - (2025-02-25)

### Fixed {id="fixed_2.0.5"}

* _Fixed_ Profile Controller for delete user, now not redirect to the route for logout.

### Changed {id="changed_2.0.5"}

* Changed Profile Controller method `deleteUserAccount()` Use `Symfony\Bundle\SecurityBundle\Security` helper to
  `logout` a user.
  * Added a message to inform that the account has been deleted.

## 2.0.4 - (2025-02-21)

### Fixed {id="fixed_2.0.4"}

* _Fixed_ templates `request.html.twig` and `reset.html.twig` simplifique render form `{{ form(form) }}`

### Changed {id="changed_2.0.4"}

* Translations
  * Changed form `forgot_password` include a help for email field.
* Changed form `AbstractResetPasswordRequestFormType` include help for field email

## 2.0.3 - (2025-02-20)

### Fixed {id="fixed_2.0.3"}

* _Fixed_ `src/Model/Controller/Admin/AbstrarUserCrudController.php` use a prefix for translation roles choices

## 2.0.2 - (2025-02-20)

### Fixed {id="fixed_2.0.2"}

* _Fixed_ `translations/IdmUserBundle+intl-icu.{es,en}.yaml` name of roles (now use lowercase)
* _Fixed_ `src/Enums/TranslatableChoicesEnumTrait.php` now use a `TranslatableMessage` object for translation choices

## 2.0.1 - (2025-02-19)

### Changed

* _Changed_ `config/services.php`
  * Service `idm_user.service.email_verifier` all services are explicitly defined
  * Service `UserChecker::class` all services are explicitly defined
  * Service `UserAdminChecker::class` all services are explicitly defined

### Fixed

* _Fixed_ a problem with service not being found `idm_user.service.email_verifier`
* _Fixed_ Implicitly marking parameter `$param` as nullable is deprecated
  * Files: `AbstractProfileController`, `AbstractRegistrationController` and `AbstractResetPasswordController`

## 2.0.0 - (2025-02-18)

### Release highlights

Extends the functionality of %project% by adding new features such as controllers, the panel for EasyAdminBundle and
more.

### Added

**Controllers**

* _Added_ `AbstractLoginController` Basic controller for Login functionality.
* _Added_ `AbstractProfileController` Basic controller for show a user profile.
* _Added_ `AbstractRegistrationController` Basic registration controller.
* _Added_ `AbstractResetPasswordController` Basic reset password controller.

**Forms**

* _Added_ `AbstractRegistrationFormType` Basic registration form.
* _Added_ `AbstractChangePasswordFormType` Form for change password.
* _Added_ `AbstractResetPasswordFormType` Form for reset password.
* _Added_ `AbstractResetPasswordRequestFormType` Form to request a reset password.

**Entities**

* _Added_ `AbstractConnections` Basic logging of user logins.
* _Added_ `AbstractPremium` Basic premium entity if you needed.

**Repositories**

* _Added_ `AbstractResetPasswordRequestRepository` Basic repository for reset password entity.

**User Checker**

* _Added_ `AbstractUserChecker` Basic checker of user when login.
* _Added_ `UserChecker` Checker for regular users.
* _Added_ `UserAdminChecker` Checker for admin users.

**Validators**

* _Added_ `PasswordRequirements` Constraint for a consistent password across the
  App. [Read Docs](PasswordRequirements.md)

**Traits**

* _Added_ `RegistrationTrait` [Read Docs](RegistrationTrait.md)

**Enums**

* _Added_ `UserRolesEnum` Basic enum with common roles

### Breaking changes

* Moved all abstract classes to `Model` namespace
* Traits of `AbstractUser` entity moved to `Traits\Entity` namespace
