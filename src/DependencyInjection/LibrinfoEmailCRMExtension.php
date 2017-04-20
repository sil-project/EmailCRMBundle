<?php

namespace Librinfo\EmailCRMBundle\DependencyInjection;

use Blast\CoreBundle\DependencyInjection\BlastCoreExtension;
use Symfony\Component\DependencyInjection\ContainerBuilder;

/**
 * This is the class that loads and manages your bundle configuration.
 *
 * @link http://symfony.com/doc/current/cookbook/bundles/extension.html
 */
class LibrinfoEmailCRMExtension extends BlastCoreExtension
{   
    public function loadSecurity(ContainerBuilder $container)
    {
        if (class_exists('\Librinfo\SecurityBundle\Configurator\SecurityConfigurator'))
            \Librinfo\SecurityBundle\Configurator\SecurityConfigurator::getInstance($container)->loadSecurityYml(__DIR__ . '/../Resources/config/security.yml');
    }
}
