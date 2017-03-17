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
        $organism = $this->manager->getRepository("LibrinfoCRMBundle:Organism")->findOneBy(array("email" => $address));
        
        
        if ($organism)
        {
            if( $organism->isIndividual() )
                return array(
                    '{prenom}' => $organism->getFirstName(),
                    '{nom}' => $organism->getLastName(),
                    '{titre}' => $organism->getTitle()
                );
            else
                return array(
                    '{nom}' => $organism->getName()
                );
        }
    }

}
