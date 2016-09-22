# SymfonyLibrinfoEmailCRMBundle
CRM bundle for Symfony with Email management

This bundle leverages the full potential of both [SymfonyLibrinfoEmailBundle](https://github.com/libre-informatique/SymfonyLibrinfoEmailBundle) and [SymfonyLibrinfoCRMBundle](https://github.com/libre-informatique/SymfonyLibrinfoCRMBundle)

It is also a proof of concept of how **it is possible** to override the entity mapping of a Symfony bundle !

New article coming soon about how we did it...

## Usage

You have to implement two traits in your symfony AppBundle : HasEmailMessages and HasEmailRecipients

```php
// src/AppBundle/Entity/Traits/HasEmailMessages.php
namespace AppBundle\Entity\Traits;

trait HasEmailMessages
{
    use \Librinfo\EmailCRMBundle\Entity\Traits\HasEmailMessages;
}

```

```php
// src/AppBundle/Entity/Traits/HasEmailRecipients.php
namespace AppBundle\Entity\Traits;

trait HasEmailRecipients
{
    use \Librinfo\EmailCRMBundle\Entity\Traits\HasEmailRecipients;
}

```
... and now the entities of [SymfonyLibrinfoEmailBundle](https://github.com/libre-informatique/SymfonyLibrinfoEmailBundle) and 
[SymfonyLibrinfoCRMBundle](https://github.com/libre-informatique/SymfonyLibrinfoCRMBundle) are linked !
