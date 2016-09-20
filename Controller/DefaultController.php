<?php

namespace Librinfo\EmailCRMBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('LibrinfoEmailCRMBundle:Default:index.html.twig');
    }
}
