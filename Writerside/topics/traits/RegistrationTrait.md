# RegistrationTrait

<secondary-label ref="2.0.0" />

Use this trait for register a User and get a new User Object

## Glossary

`getUserObject()`
: Get a User Object with predefined display name.
: **_Return_** `Idm\Bundle\User\Model\Entity\AbstractUser`

`registerUser()`
: Encode password, register a User and send the verification email.
: **Param** `Idm\Bundle\User\Model\Entity\AbstractUser` `$user` An Object User entity
: **Param** `Symfony\Bridge\Twig\Mime\TemplatedEmail` `$templatedEmail` An Object of Email Templated
: **Param** `string` `$plainPassword` The plain password
: **_Return_** `void`

{type="medium"}
