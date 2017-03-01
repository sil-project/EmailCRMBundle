<?php

namespace Librinfo\EmailCRMBundle\Admin;

use Librinfo\CRMBundle\Admin\ContactAdmin as BaseContactAdmin;

class ContactAdmin extends BaseContactAdmin
{
    protected $baseRouteName = 'admin_librinfo_emailcrm_contact';
    protected $baseRoutePattern = 'librinfo/emailcrm/contact';
}