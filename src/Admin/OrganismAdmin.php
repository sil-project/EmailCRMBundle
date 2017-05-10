<?php

/*
 * Copyright (C) 2015-2016 Libre Informatique
 *
 * This file is licenced under the GNU GPL v3.
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Librinfo\EmailCRMBundle\Admin;

use Librinfo\CRMBundle\Admin\OrganismAdmin as BaseOrganismAdmin;
use Sonata\AdminBundle\Show\ShowMapper;

class OrganismAdmin extends BaseOrganismAdmin
{
    protected $baseRouteName = 'admin_librinfo_emailcrm_organism';
    protected $baseRoutePattern = 'librinfo/emailcrm/organism';

    /**
     * @param ShowMapper $mapper
     */
    protected function configureShowFields(ShowMapper $mapper)
    {
        parent::configureShowFields($mapper);
        $mapper->get('positions')->setTemplate('LibrinfoEmailCRMBundle:CRUD:show_field_organism_positions.html.twig');
    }
}