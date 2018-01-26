<?php

class AdministrationController extends Zend_Controller_Action
{

    public function init()
    {
        $this->_helper->layout->setLayout('admin');
        /* Initialize action controller here */
        $session = new Zend_Auth_Storage_Session();
        $idUloga = $session->read()->id_uloga;
        if($idUloga!=1) $this->redirect('Index');
        $this->view->headTitle()->prepend("Administracija");
    }

    public function indexAction()
    {
        // action body
        echo "Dobro došli admine!";
    }

    public function radioniceAction()
    {
        // action body
        $request = $this->getRequest();
        $tip = $request->getParam('operation');
        $success= array();
        $errors = array();
        $form = new Application_Form_Radionice();
        $radionicaMapper = new Application_Model_RadioniceMapper();
        if($tip == 'insert'){
            if($request->isPost() && $form->isValid($request->getPost())){
                $opis = $request->getParam('taOpis');
                $naslov = $request->getParam('tbNaslov');
                $vremePocetka = $request->getParam('datumPocetka');
                $vremeZavrsetka = $request->getParam('datumZavrsetka');
                $tip = $request->getParam('ddlTip');
                $session = new Zend_Auth_Storage_Session();
                $idkorisnik = $session->read()->id_korisnik;
                $radionica = new Application_Model_Radionice();
                $radionica->setKorisnik($idkorisnik);
                $radionica->setNaslov($naslov);
                $radionica->setTip($tip);
                $radionica->setOpis($opis);
                $radionica->setVremePocetka($vremePocetka);
                $radionica->setVremeZavrsetka($vremeZavrsetka);
                $radionicaMapper = new Application_Model_RadioniceMapper();
                $idRadionica = $radionicaMapper->insert($radionica);
                if(!empty($idRadionica)){
                    $success[] = "Uspešno ste zakazali radionicu.";
                }
            }
            else{
                $this->view->form = $form;
            }
        }
        if($tip=='checkDate'){
            $pocetak = $request->getParam('pocetak');
            $zavrsetak = $request->getParam('zavrsetak');
            
            if(!empty($pocetak) && !empty($zavrsetak)){
                $timePocetak= strtotime($pocetak);
                $timeZavrsetak = strtotime($zavrsetak);
                if($timePocetak >= $timeZavrsetak){
                    $errors[] = "Vreme pocetka ne moze biti veci ili jednak vremenu zavrsetka. ".$pocetak." - ".$zavrsetak;
                }
                else if(date("w",$timePocetak)== 0 || date("w",$timePocetak)==6){
                    $errors[] = "Vreme pocetka ne može biti vikend";
                }
                else if(date("w",$timeZavrsetak)== 0 || date("w",$timeZavrsetak)==6){
                    $errors[] = "Vreme zavrsetka ne može biti vikend";
                }
                else{
                     $radionica = new Application_Model_Radionice();
                    $radionica->setVremePocetka($timePocetak);
                    $radionica->setVremeZavrsetka($timeZavrsetak);
                    $radionicaMapper = new Application_Model_RadioniceMapper();
                    $numRadionica = count($radionicaMapper->fetchAllWhere($radionica));
                    if($numRadionica !=0){
                        $errors[] = "Termin je zauzet: $pocetak - $zavrsetak .";
                    }
                    else{
                        $form->setAction($this->getRequest()->getBaseUrl().'/Administration/radionice/operation/insert/datumZavrsetka/'.$timeZavrsetak.'/datumPocetka/'.$timePocetak);
                        $this->view->form = $form;
                    }
                }
            }
            else{
                echo "Morate izabrati oba datuma.";
            }
            $this->view->prikazi = true;
            $this->view->pocetak = $pocetak;
            $this->view->zavrsetak = $zavrsetak;
        }
        if($tip=="prikaz"){
            $radioniceMapper = new Application_Model_RadioniceMapper();
            $radionice = $radioniceMapper->fetchAllWhere();
            $this->view->radionice = $radionice;
        } 
        if($tip=='obrisi'){
            
            $id= $this->getParam('id');
            $radionica = new Application_Model_Radionice();
            $radionica->setId_radionica($id);
            $radionicaMapper->delete($radionica);
            $this->redirect('Administration/radionice/operation/prikaz');
        }
        if($tip=='izmeni'){
            $id= $this->getParam('id');
            $radionica = new Application_Model_Radionice();
            $radionicaMapper->find($id, $radionica);
            $form = new Application_Form_Radionice($radionica);
            $form->setAction($this->getRequest()->getBaseUrl().'/Administration/radionice/operation/izmena/id/'.$id);
            $this->view->form = $form;
        }
        if($tip=='izmena'){
            $id= $this->getParam('id');
            $opis = $request->getParam('taOpis');
            $naslov = $request->getParam('tbNaslov');
            $vremePocetka = $request->getParam('datumPocetka');
            $vremeZavrsetka = $request->getParam('datumZavrsetka');
            $tip = $request->getParam('ddlTip');
            $session = new Zend_Auth_Storage_Session();
            $idkorisnik = $session->read()->id_korisnik;
            $radionica = new Application_Model_Radionice();
            $radionica->setNaslov($naslov);
            $radionica->setOpis($opis);
            $radionica->setTip($tip);
            $radionica->setKorisnik($idkorisnik);
            $radionicaMapper->update($id, $radionica);
            $this->redirect('Administration/radionice/operation/prikaz');
        }
        $this->view->errors = $errors;
        $this->view->success = $success;
    }

    public function slikeAction()
    {
        // action body
        $form = new Application_Form_Slike();
        $form->setAction($this->getRequest()->getBaseUrl().'/Administration/slike/operation/insert');
        
        $request = $this->getRequest();
        $tip = $request->getParam('operation');
        $fileDirectrory=APPLICATION_PATH.'/../public/slike/';
        $slikaMapper = new Application_Model_SlikeMapper();
        $slika = new Application_Model_Slike();
        if($tip=='insert'){
            $upload=new Zend_File_Transfer_Adapter_Http();
            $odrediste=$fileDirectrory;
            if(!file_exists($odrediste)){
                mkdir($odrediste);
            }
            $upload->setDestination($odrediste.'/');
            $imeFajla=$upload->getFileName();

            $ekstenzija1=explode('.',$imeFajla);
            $ekstenzija=$ekstenzija1[count($ekstenzija1)-1];
            $naziv=$ekstenzija1[count($ekstenzija1)-2];
            $novoIme=date('d_M_Y_H_s_i').'.'.$ekstenzija;
            $upload->addFilter('Rename',array('target'=>$novoIme));
            $upload->addValidator('Extension',false,array('jpg','png','gif','jpeg'));
            $upload->setOptions(array('useByteString'=>FALSE));
           if($upload->receive()){
               $opis = $this->getParam('taOpis');
               $radionica = $this->getParam('ddlRadionica');
               $slika->setPutanja('slike/'.$novoIme);
               $slika->setRadionica($radionica);
               $slika->setOpis($opis);
               $slikaMapper->insert($slika);
               $this->redirect('Administration/slike/operation/prikaz');
           }
           $this->view->show = true;
           $this->view->form = $form;
        }
        if($tip=='prikaz'){
            $slike =$slikaMapper->fetchAll();
            $this->view->slike = $slike;
        }
        if($tip=='izmeni'){
            $id = $this->getParam('id');
            $slikaMapper->find($id, $slika);
            $form = new Application_Form_Slike($slika);
            $form->setAction($this->getRequest()->getBaseUrl().'/Administration/slike/operation/izmena/id/'.$id);
            $this->view->show = true;
            $this->view->form = $form;
        }
        if($tip=='izmena'){
            $id = $this->getParam('id');
            $upload=new Zend_File_Transfer_Adapter_Http();
            $odrediste=$fileDirectrory;
            if(!file_exists($odrediste)){
                mkdir($odrediste);
            }
            $upload->setDestination($odrediste.'/');
            $imeFajla=$upload->getFileName();

            $ekstenzija1=explode('.',$imeFajla);
            $ekstenzija=$ekstenzija1[count($ekstenzija1)-1];
            $naziv=$ekstenzija1[count($ekstenzija1)-2];
            $novoIme=date('d_M_Y_H_s_i').'.'.$ekstenzija;
            $upload->addFilter('Rename',array('target'=>$novoIme));
            $upload->addValidator('Extension',false,array('jpg','png','gif','jpeg'));
            $upload->setOptions(array('useByteString'=>FALSE));
            $opis = $this->getParam('taOpis');
            $radionica = $this->getParam('ddlRadionica');
            if($upload->receive()){
                $slika->setPutanja('slike/'.$novoIme);
            }
            $slika->setRadionica($radionica);
            $slika->setOpis($opis);
            $slikaMapper->update($id,$slika);
            $this->redirect('Administration/slike/operation/prikaz');
        }
        if($tip=='obrisi'){
            $id = $this->getParam('id');
            $slikaMapper->find($id, $slika);
            $slikaMapper->delete($id);
            unlink($this->getRequest()->getBaseUrl().$slika->putanja);
            $this->redirect('Administration/slike/operation/prikaz');
        }
    }

    public function terminiAction()
    {
        // action body
        $form = new Application_Form_Termini();
        $form->setAction($this->getRequest()->getBaseUrl().'/Administration/termini/operation/insert');
        $request = $this->getRequest();
        $tip = $request->getParam('operation');
        $termin = new Application_Model_Termini();
        $terminMapper = new Application_Model_TerminiMapper();
        if($tip == 'prikaz'){
            $termini = $terminMapper->fetchAll();
            $this->view->termini = $termini;
        }
        if($tip=='insert'){
            if($request->isPost() && $form->isValid($request->getPost())){
                $vreme = $request->getParam('tbVreme');
                $cena = $request->getParam('tbCena');
                $termin->setCena($cena);
                $termin->setVreme($vreme);
                $terminMapper->insert($termin);
                $this->redirect('Administration/termini/operation/prikaz');
            }
            $this->view->show = true;
            $this->view->form = $form;
        }
        if($tip=='izmeni'){
            $id = $request->getParam('id');
            $terminMapper->find($id, $termin);
            $form = new Application_Form_Termini($termin);
            $form->setAction($this->getRequest()->getBaseUrl().'/Administration/termini/operation/izmena/id/'.$id);
            $this->view->show = true;
            $this->view->form = $form;
        }
        if($tip=='izmena'){
            $id = $request->getParam('id');
            if($request->isPost()){
                $vreme = $request->getParam('tbVreme');
                $cena = $request->getParam('tbCena');
                $termin->setCena($cena);
                $termin->setVreme($vreme);
                $terminMapper->update($id,$termin);
                $this->redirect('Administration/termini/operation/prikaz');
            }
        }
        if($tip == 'obrisi'){
            $id = $request->getParam('id');
            if(!empty($id)){
                $terminMapper->delete($id);
            }
            $this->redirect('Administration/termini/operation/prikaz');
        }
    }


}







