# Changelog

## 2.0.3 - (2025-02-20)

## Fixed {id="fixed_2.0.3"}

* Fixed `src/Model/Controller/Admin/AbstrarUserCrudController.php` use a prefix for translation roles choices

## 2.0.2 - (2025-02-20)

## Fixed {id="fixed_2.0.2"}

* Fixed `translations/IdmUserBundle+intl-icu.{es,en}.yaml` name of roles (now use lowercase)
* Fixed `src/Enums/TranslatableChoicesEnumTrait.php` now use a `TranslatableMessage` object for translate choices

## 2.0.1 - (2025-02-19)

## Changed

* Changed `config/services.php`
  * Service `idm_user.service.email_verifier` all services are explicitly defined
  * Service `UserChecker::class` all services are explicitly defined
  * Service `UserAdminChecker::class` all services are explicitly defined

## Fixed

* Fixed problem with service not being found `idm_user.service.email_verifier`
* Fixed Implicitly marking parameter `$param` as nullable is deprecated
  * Files: `AbstractProfileController`, `AbstractRegistrationController` and `AbstractResetPasswordController`

## 2.0.0 - (2025-02-18)

## Release highlights

Extends the functionality of %project% by adding new features such as controllers, the panel for EasyAdminBundle and
more.

## Added

**Controllers**

* Added `AbstractLoginController` Basic controller for Login functionality.
* Added `AbstractProfileController` Basic controller for show a user profile.
* Added `AbstractRegistrationController` Basic registration controller.
* Added `AbstractResetPasswordController` Basic reset password controller.

**Forms**

* Added `AbstractRegistrationFormType` Basic registration form.
* Added `ChangePasswordFormType` Form for change password.
* Added `ResetPasswordFormType` Form for reset password.
* Added `ResetPasswordRequestFormType` Form for request a reset password.

**Entities**

* Added `AbstractConnections` Basic logging of user logins.
* Added `AbstractPremium` Basic premium entity if you needed.

**Repositories**

* Added `AbstractResetPasswordRequestRepository` Basic repository for reset password entity.

**User Checker**

* Added `AbstractUserChecker` Basic checker of user when login.
* Added `UserChecker` Checker for regular users.
* Added `UserAdminChecker` Checker for admin users.

**Validators**

* Added `Passwordrequirements` Constraint for a consistent password across the App. [Read Docs](PasswordRequirements.md)

**Traits**

* Added `RegistrationTrait` [Read Docs](RegistrationTrait.md)

**Enums**

* Added `UserRolesEnum` Basic enum with common roles

## Breaking changes

* Moved all abstract classes to `Model` namespace
* Traits of `AbstractUser` entity moved to `Traits\Entity` namespace
