# Legal Trait

<secondary-label ref="1.0.0" />

Use this trait to add a Legal feature to your User entity (used in
`Idm\Bundle\User\Model\Entity\AbstractUser`), with this can make your users need to read and accept your privacy and
terms policies.

## Glossary

`getPrivacyAccepted()`
: Get if user accepted the Privacy Policy
: **_Return_** `bool`

`setPrivacyAccepted()`
: Set the Privacy Policy
: **Parameters**
: - `$privacyAccepted` `bool`
: **_Return_** `EntityObject`

`getTermsAccepted()`
: Get if user accepted the Terms and Conditions
: **_Return_** `bool`

`setTermsAccepted()`
: Set the Terms and Conditions
: **Parameters**
: - `$termsAccepted` `bool`
: **_Return_** `EntityObject`

{type="medium"}
