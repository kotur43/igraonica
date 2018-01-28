<?php

class UserController extends Core_BaseController
{

    public function init()
    {
        /* Initialize action controller here */
        //if(!$this->isAuthentificated) redirect('/Index');
        $session = new Zend_Auth_Storage_Session();
        $idUloga = $session->read()->id_uloga;
        if(empty($idUloga)) $this->redirect('Index');
        $this->view->headTitle()->prepend("Korisnik");
    }

    public function indexAction()
    {   
        $this->view->links = array(
            'Rezerviši igraonicu za rođendan'=> $this->view->url(array('controller'=>'User','action'=>'reservation')));
    }

    public function reservationAction()
    {
        // action body
        $request = $this->getRequest();
        if($request->isPost()){
            $operation = $request->getParam('operation');
            $messages = $this->_helper->flashMessenger->getMessages();
            if(!empty($operation) && $operation=='rezervisi'){
                // redirektuj na index action da ih vidi sve zerervisane
                $opis = $request->getParam('taOpis');
                $brojOsoba = $request->getParam('tbBroj');
                $datum = $request->getParam('hdnDatum');
                $idTermin= $request->getParam('ddlTermin');
                $session = new Zend_Auth_Storage_Session();
                $idkorisnik = $session->read()->id_korisnik;
                $zakazivanje = new Application_Model_Rezervacije();
                $zakazivanje->setBroj_osoba($brojOsoba);
                $zakazivanje->setDatum($datum);
                $zakazivanje->setKorisnik($idkorisnik);
                $zakazivanje->setOpis($opis);
                $zakazivanje->setTermin($idTermin);
                $zakazivanjeMapper = new Application_Model_RezervacijeMapper();
                $idUnetog = $zakazivanjeMapper->insert($zakazivanje);
                if(!empty($idUnetog)){
                    $this->view->message = 'Uspesno zakazan rodjendan.';
                }
                else {
                    
                    $this->view->message = 'Greska!';
                }
            }
            else
            {
                $datum = $request->getParam('date');
                $nizDate = split('-',$datum);
                $dayOfWeek = date("w", mktime(0,0,0,$nizDate[1],$nizDate[2],$nizDate[0]));
                if($dayOfWeek == 6 || $dayOfWeek == 0){
                    $zakazivanje = new Application_Model_Rezervacije();
                    $zak = new Application_Model_RezervacijeMapper();
                    $termini = $zak->fetchAllWhereTermin($zakazivanje);
                    if(count($termini) > 0){
                        $prom = (count($termini));
                        $this->view->error = "Ima $prom slobodnih termina";
                    }
                    else{
                        $zakazivanjeForma = new Application_Form_Rezervisanje($termini,$datum);
                        $this->view->datum = $datum;
                        $this->view->forma = $zakazivanjeForma;
                    }
                }
                else{
                    $this->view->error = 'Zakazivanje je dozvoljeno samo za dane vikenda.';
                    $this->view->message = 'Rodjendani se zakazuju samo za dane vikenda!';
                    $this->view->minDate = date("Y-m-d");
                    $this->view->maxDate = date("Y-m-d",time() + 86000*30*2); // samo 2 meseca unapred moze da zakaze
                }
                
            }
        
        }
    }
}