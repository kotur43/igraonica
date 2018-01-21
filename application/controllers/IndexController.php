<?php

class IndexController extends Zend_Controller_Action
{

    
    private $errorMessages = array();

    private $successMessages = array();

    public function init()
    {
        /* Initialize action controller here */
        $this->view->headTitle()->prepend("Pocetna");
        
    }
    
    public function indexAction()
    {
        // action body
    }


}

