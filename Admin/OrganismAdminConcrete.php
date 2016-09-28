<?php

namespace Librinfo\EmailCRMBundle\Admin;

use Librinfo\CoreBundle\Admin\CoreAdmin;
use Librinfo\CRMBundle\Admin\OrganismAdminConcrete as BaseOrganismAdminConcrete;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;

class OrganismAdminConcrete extends BaseOrganismAdminConcrete
{
    protected $baseRouteName = 'admin_librinfo_emailcrm_organism';
    protected $baseRoutePattern = 'librinfo/emailcrm/organism';

    /**
     * @param DatagridMapper $mapper
     */
    protected function configureDatagridFilters(DatagridMapper $mapper)
    {
        CoreAdmin::configureDatagridFilters($mapper);
    }

    /**
     * @param ListMapper $mapper
     */
    protected function configureListFields(ListMapper $mapper)
    {
        CoreAdmin::configureListFields($mapper);
    }

    /**
     * @param FormMapper $mapper
     */
    protected function configureFormFields(FormMapper $mapper)
    {
        CoreAdmin::configureFormFields($mapper);
    }

    /**
     * @param ShowMapper $mapper
     */
    protected function configureShowFields(ShowMapper $mapper)
    {
        CoreAdmin::configureShowFields($mapper);
        $mapper->get('positions')->setTemplate('LibrinfoEmailCRMBundle:CRUD:show_field_organism_positions.html.twig');
    }
}