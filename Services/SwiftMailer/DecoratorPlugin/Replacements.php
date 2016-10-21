<?php

namespace Librinfo\EmailCRMBundle\Services\SwiftMailer\DecoratorPlugin;

use Doctrine\ORM\EntityManager;

class Replacements implements \Swift_Plugins_Decorator_Replacements
{
    /**
     * @var EntityManager $manager
     * */
    private $manager;

    public function __construct(EntityManager $manager)
    {
        $this->manager = $manager;
    }

    /**
     * Returns Contact info if LibrinfoCRMBundle is installed
     * 
     * @param type $address
     * @return type
     */
    public function getReplacementsFor($address)
    {
        $contact = $this->manager->getRepository("LibrinfoCRMBundle:Contact")->findOneBy(array("email" => $address));

        if ($contact)
        {
            return array(
                '{prenom}' => $contact->getFirstName(),
                '{nom}' => $contact->getName(),
                '{titre}' => $contact->getTitle()
            );
        }
    }

}
