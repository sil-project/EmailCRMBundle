# SymfonyLibrinfoEmailCRMBundle
CRM bundle for Symfony with Email management

This bundle leverages the full potential of both [SymfonyLibrinfoEmailBundle](https://github.com/libre-informatique/SymfonyLibrinfoEmailBundle) and [SymfonyLibrinfoCRMBundle](https://github.com/libre-informatique/SymfonyLibrinfoCRMBundle)

It is also a proof of concept of how **it is possible** to override the entity mapping of a Symfony bundle !

New article coming soon about how we did it...

## Usage

You have to implement 4 "outer extension" traits in your symfony AppBundle : 
* ContactExtension
* PositionExtension
* OrganismExtension
* EmailExtension

```php
// src/AppBundle/Entity/Extension/ContactExtension.php
namespace AppBundle\Entity\Extension;

trait ContactExtension
{
    use \Librinfo\EmailCRMBundle\Entity\Traits\HasEmailMessages;
}

```

```php
// src/AppBundle/Entity/Extension/PositionExtension.php
namespace AppBundle\Entity\Extension;

trait PositionExtension
{
    use \Librinfo\EmailCRMBundle\Entity\Traits\HasEmailMessages;
}

```

```php
// src/AppBundle/Entity/Extension/OrganismExtension.php
namespace AppBundle\Entity\Extension;

trait OrganismExtension
{
    use \Librinfo\EmailCRMBundle\Entity\Traits\HasEmailMessages;
}

```

```php
// src/AppBundle/Entity/Extension/EmailExtension.php
namespace AppBundle\Entity\Extension;

trait EmailExtension
{
    use \Librinfo\EmailCRMBundle\Entity\Traits\HasEmailRecipients;
}

```
... and now the entities of [SymfonyLibrinfoEmailBundle](https://github.com/libre-informatique/SymfonyLibrinfoEmailBundle) and 
[SymfonyLibrinfoCRMBundle](https://github.com/libre-informatique/SymfonyLibrinfoCRMBundle) are linked from outer space!
