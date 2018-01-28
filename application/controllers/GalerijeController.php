<?php

class GalerijeController extends Core_BaseController
{

    public function init()
    {
        /* Initialize action controller here */
        $this->view->headTitle()->prepend("Galerije");
    }

    public function indexAction()
    {
        // action body
        $slikeMapper = new Application_Model_SlikeMapper();
        $slike = $slikeMapper->fetchAll();
        $this->view->slikeGalerija = $slike;
    }


}  

