<?php

namespace Librinfo\EmailCRMBundle\Admin;

use Blast\CoreBundle\Admin\CoreAdmin;
use Librinfo\CRMBundle\Admin\ContactAdminConcrete as BaseContactAdminConcrete;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;

class ContactAdminConcrete extends BaseContactAdminConcrete
{
    protected $baseRouteName = 'admin_librinfo_emailcrm_contact';
    protected $baseRoutePattern = 'librinfo/emailcrm/contact';

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
        $mapper->get('positions')->setTemplate('LibrinfoEmailCRMBundle:CRUD:show_field_contact_positions.html.twig');
    }
}