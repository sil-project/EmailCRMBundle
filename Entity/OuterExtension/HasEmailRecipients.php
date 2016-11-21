<?php

namespace Librinfo\EmailCRMBundle\Entity\OuterExtension;

trait HasEmailRecipients
{
    use \Librinfo\CRMBundle\Entity\OuterExtension\HasOrganisms;
    use \Librinfo\CRMBundle\Entity\OuterExtension\HasPositions;
    use \Librinfo\CRMBundle\Entity\OuterExtension\HasContacts;
}