<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of BaseController
 *
 * @author Danijela
 */
class Core_BaseController extends Zend_Controller_Action{
    //put your code here
    protected $isAuthentificated = false;
    public function init() {
        parent::init();
      
    }
    public function __construct(\Zend_Controller_Request_Abstract $request, \Zend_Controller_Response_Abstract $response, array $invokeArgs = array()) {
        parent::__construct($request, $response, $invokeArgs);
         $auth = Zend_Auth::getInstance();
        $this->isAuthentificated = $auth->hasIdentity();
        if($this->isAuthentificated){
            // ----- DOHVATANJE SESIJE -------
            //$session = new Zend_Auth_Storage_Session();
            //var_dump($session->read()->id_korisnik);
        }
        
        $meniMapper = new Application_Model_MeniMapper();
        $menuData = $meniMapper->fetchAllWithOrder();
        $links = array();
        foreach ($menuData as $menuItem){
            $link = split('/',$menuItem->getPutanja());
            $action = isset($link[1]) ? $link[1] : '';
            if (in_array($menuItem->getNaslov() == 'Radionice', $links)){
                 $links[] = "<a class=\"drop\" href='".$this->view->url(array('controller'=>$link[0],'action'=>$action),'default',true)."'>".$menuItem->getNaslov()."</a><ul>";
                 $links[] = "<a href='".$this->view->url(array('controller'=>'Radionice','action'=>'index', 'tip'=>'1'),'default',true)."'>Crtaonica</a>";
                 $links[] = "<a href='".$this->view->url(array('controller'=>'Radionice','action'=>'index', 'tip'=>'2'),'default',true)."'>Maskaonica</a>";
                 $links[] = "<a href='".$this->view->url(array('controller'=>'Radionice','action'=>'index', 'tip'=>'3'),'default',true)."'>Plesaonica</a></ul>"; 
                 echo "</ul>";
            }
            else {
                 $links[] = "<a href='".$this->view->url(array('controller'=>$link[0],'action'=>$action),'default',true)."'>".$menuItem->getNaslov()."</a>";
            }
            
            
        }
          
        if($this->isAuthentificated){
            $links[] = "<a href='".$this->view->url(array('controller'=>'User','action'=>'index'),'default',true)."'>Moj nalog</a>";
            $links[] = "<a href='".$this->view->url(array('controller'=>'Authentification','action'=>'logout'),'default',true)."'>Odjava</a>";
        }
        else{
             $links[] = "<a href='".$this->view->url(array('controller'=>'Authentification','action'=>'login'),'default',true)."'>Logovanje</a>";
             $links[] = "<a href='".$this->view->url(array('controller'=>'Authentification','action'=>'registration'),'default',true)."'>Registracija</a>";
        }
        $session = new Zend_Auth_Storage_Session();
        $idUloga = $session->read()->id_uloga;
        if($idUloga==1){
            $links[] = "<a href='".$this->view->url(array('controller'=>'Administration','action'=>'index'),'default',true)."'>Administracija</a>";
        }
        
        $tipMapper = new Application_Model_TipoviMapper();
        $this->view->slikeTipova = $tipMapper->fetchAll(0,3);
        $komentarMapper = new Application_Model_KomentariMapper();
        $komentari = $komentarMapper->fetchAllLimit(3,0);
        $radionicaMapper = new Application_Model_RadioniceMapper();
        $radioniceUskoro = $radionicaMapper->fetchAllOffset();
        $paginator = Zend_Paginator::factory($radioniceUskoro);
        $paginator->setItemCountPerPage(3);
        $paginator->setCurrentPageNumber($this->getParam('page'));
        $this->view->pagination = $paginator;
        $this->view->pageRange = $paginator->getPages()->pagesInRange;
        $this->view->currentPage = $paginator->getCurrentPageNumber();
        $this->view->topKomentari = $komentari;
        $lista = $this->view->htmlList($links, false, array('class'=>'center'), false); // kreira uredjenu/neuredjenu listu, niz u nizu -> ugnjezdene liste 
        $outputObj = $this->view; // referenca
        $outputObj->placeholder("menu")->append($lista);
    }
    
}

?>
