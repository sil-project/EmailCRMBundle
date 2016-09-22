<?php

namespace Librinfo\EmailCRMBundle\EventListener;

use Doctrine\Common\EventSubscriber;
use Doctrine\ORM\Event\LoadClassMetadataEventArgs;
use Doctrine\ORM\Mapping\ClassMetadata;
use Monolog\Logger;
use Psr\Log\LoggerAwareInterface;
use Psr\Log\LoggerInterface;

/**
 * Sets Custom Repositories for many entity classes (Contact and Organism for now)
 */
class CustomRepositoriesListener implements LoggerAwareInterface, EventSubscriber
{
    /**
     * @var Logger
     */
    private $logger;

    /**
     * Returns an array of events this subscriber wants to listen to.
     *
     * @return array
     */
    public function getSubscribedEvents()
    {
        return [
            'loadClassMetadata',
        ];
    }

    /**
     * Dynamic many-to-many mappings between Email and recipient entities
     *
     * @param LoadClassMetadataEventArgs $eventArgs
     */
    public function loadClassMetadata(LoadClassMetadataEventArgs $eventArgs)
    {
        /** @var ClassMetadata $metadata */
        $metadata = $eventArgs->getClassMetadata();

        $entities = [
            'Librinfo\\CRMBundle\\Entity\\Organism',
            'Librinfo\\CRMBundle\\Entity\\Contact',
        ];
        if (!in_array($metadata->getName(), $entities))
            return;

        $this->logger->debug("[CustomRepositoriesListener] Entering RepositoriesListener for « loadClassMetadata » event");

        $repo = 'Librinfo\\EmailCRMBundle\\Entity\\Repository\\' . $metadata->getReflectionClass()->getShortName() . 'Repository';
        $metadata->setCustomRepositoryClass($repo);

        $this->logger->debug("[CustomRepositoriesListener] Changed custom repository class to $repo", ['class' => $metadata->getName()]);
    }

    /**
     * Sets a logger instance on the object
     *
     * @param LoggerInterface $logger
     * @return null
     */
    public function setLogger(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

}
