# Registration Trait

<secondary-label ref="2.0.0" />

Use this trait for register a User and get a new User Object

## Glossary

`getUserObject()`
: Get a User Object with predefined display name.
: **_Return_** `Idm\Bundle\User\Model\Entity\AbstractUser`

`registerUser()`
: Encode password, register a User and send the verification email.
: **Parameters**
: - `$user` `Idm\Bundle\User\Model\Entity\AbstractUser`. An Object User entity
: - `$templatedEmail` `Symfony\Bridge\Twig\Mime\TemplatedEmail`. An Object of Email Templated
: - `$plainPassword` `string` The plain password.
: **_Return_** `void`

{type="medium"}
