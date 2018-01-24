<?php

class Bootstrap extends Zend_Application_Bootstrap_Bootstrap
{
     protected function _initDoctype(){
        $this->bootstrap('view');
        $view=$this->getResource('view');
        $view->doctype('HTML5');
    }
    protected function _initAutoloader()
    {
        $autoloader = Zend_Loader_Autoloader::getInstance();
        $autoloader->registerNamespace("Core_");
    }
    
    protected function _initPlaceholders(){
        $this->bootstrap('view');
        $view=$this->getResource('view');
        $view->headTitle("Koja")->setSeparator(" | ");
        
    }
    protected function _initMenu(){
        $this->bootstrap('view');
        $view=$this->getResource('view');
        $view->placeholder('menu');
    }
   

}


