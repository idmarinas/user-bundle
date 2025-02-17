# Equatable Trait

<secondary-label ref="1.0.0" />

Use this trait to add an Equatable feature to your User entity (used in
`Idm\Bundle\User\Model\Entity\AbstractUser`), with this can make your users can only have 1 sessión from 1 device and
firewall.

## Glossary

`getSessionId()`
: Get session id of User
: **_Return_** `string`

`setSessionId()`
: Set session id of User
: **Parameters**
: - `$sessionId` `string`
: **_Return_** `EntityObject`

`isEqualTo()`
: Used by Symfony to check if the user is Equal to the Session User
: **_Return_** `bool`

{type="medium"}
