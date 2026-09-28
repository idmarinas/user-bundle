# Changelog

## 2.2.0 - (2026-09-28)

### Added {id="added_2.2.0"}

* _Added_ support for Symfony `^8.0`
* _Added_ method `__serialize()` to `SecurityTrait` to keep the hashed password out of the session storage

### Fixed {id="fixed_2.2.0"}

* _Fixed_ help text key in `ResetPasswordRequestFormType` from `form.reset_password_request.email.help` to
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
* Changed form `ResetPasswordRequestFormType` include help for field email

## 2.0.3 - (2025-02-20)

### Fixed {id="fixed_2.0.3"}

* _Fixed_ `src/Model/Controller/Admin/AbstrarUserCrudController.php` use a prefix for translation roles choices

## 2.0.2 - (2025-02-20)

### Fixed {id="fixed_2.0.2"}

* _Fixed_ `translations/IdmUserBundle+intl-icu.{es,en}.yaml` name of roles (now use lowercase)
* _Fixed_ `src/Enums/TranslatableChoicesEnumTrait.php` now use a `TranslatableMessage` object for translate choices

## 2.0.1 - (2025-02-19)

### Changed

* _Changed_ `config/services.php`
  * Service `idm_user.service.email_verifier` all services are explicitly defined
  * Service `UserChecker::class` all services are explicitly defined
  * Service `UserAdminChecker::class` all services are explicitly defined

### Fixed

* _Fixed_ problem with service not being found `idm_user.service.email_verifier`
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
* _Added_ `ChangePasswordFormType` Form for change password.
* _Added_ `ResetPasswordFormType` Form for reset password.
* _Added_ `ResetPasswordRequestFormType` Form to request a reset password.

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

* _Added_ `Passwordrequirements` Constraint for a consistent password across the
  App. [Read Docs](PasswordRequirements.md)

**Traits**

* _Added_ `RegistrationTrait` [Read Docs](RegistrationTrait.md)

**Enums**

* _Added_ `UserRolesEnum` Basic enum with common roles

### Breaking changes

* Moved all abstract classes to `Model` namespace
* Traits of `AbstractUser` entity moved to `Traits\Entity` namespace
