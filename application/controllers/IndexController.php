<?php

class IndexController extends Core_BaseController {

    private $errorMessages = array();

    private $successMessages = array();

    public function init()
    {
        /* Initialize action controller here */
        $this->view->headTitle()->prepend("Pocetna");
        
    }

    public function indexAction()
    {
        $messages = $this->_helper->FlashMessenger->getMessages();
        $this->view->messages = $messages;
    }
    
    public function paginationAction()
    {
        // action body
        $this->_helper->layout()->disableLayout();
        //$this->getHelper('viewRenderer')->setNoRender(true);
        $request = $this->getRequest();
        if($request->isXmlHttpRequest()){
            $radionicaMapper = new Application_Model_RadioniceMapper();
            $radioniceUskoro = $radionicaMapper->fetchAllOffset();
            $paginator = Zend_Paginator::factory($radioniceUskoro);
            $paginator->setItemCountPerPage(3);
            $paginator->setCurrentPageNumber($this->getParam('page'));
            $this->view->pagination = $paginator;
            $this->view->pageRange = $paginator->getPages()->pagesInRange;
            $this->view->currentPage = $paginator->getCurrentPageNumber();
        }
        
        //$this->view->radioniceUskoro = $radioniceUskoro;
    }
    


}
