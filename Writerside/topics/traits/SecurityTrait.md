# SecurityTrait

Use this trait to add a user-password login.

## Glossary

`getPassword()`
: Get encrypted password.
: **_Return_** `string`

`setPassword()`
: Set encrypted password for user
: **Parameters**
: - `$password` `string`
: **_Return_** `EntityObject`

`eraseCredentials()`
: Removes sensitive data from the user.
: **_Return_** `void`
