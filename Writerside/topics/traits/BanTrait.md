# Ban Trait

<secondary-label ref="1.0.0" />

Use this trait to add a `banned until` field to your entity (used in `Idm\Bundle\User\Model\Entity\AbstractUser`)

## Glossary

A definition list or a glossary:

`getBannedUntil()`
: Get date on which the ban is ended
: **_Return_** `null|DateTimeInterface`

`setBannedUntil()`
: Set date on which the ban is ended
: **Parameters**
: - `$bannedUntil` `null|DateTimeInterface`
: **_Return_** `EntityObject`

`isBanned()`
: Get if user is banned
: **_Return_** `bool`

{type="medium"}
