# Changelog

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

* _Deleted_ all attributes related to data validation in `AbstractUser` entity.

## 2.0.7 - (2025-02-27)

### Changed {id="changed_2.0.7"}

* _Changed_ `translations->validators` refactor part of keys

## 2.0.6 - (2025-02-27)

### Fixed {id="fixed_2.0.6"}

* _Fixed_ `AbstractUserCrudController` **IdField** now use `id` name and not `uuid`
* _Fixed_ `AbstractUser` **Validator for username field** now use correct message.

## 2.0.5 - (2025-02-25)

### Fixed {id="fixed_2.0.5"}

* _Fixed_ Profile Controller for delete user, now not redirect to route for logout.

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
* _Added_ `ResetPasswordRequestFormType` Form for request a reset password.

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
