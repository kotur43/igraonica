<?php

class RadioniceController extends Core_BaseController
{

    private $id_korisnik;

    public function init() {
        /* Initialize action controller here */
        $session = new Zend_Auth_Storage_Session();
        $this->id_korisnik = $session->read()->id_korisnik;
        $this->view->headTitle()->prepend("Radionice");
    }

    public function indexAction() {
        // action body
        $radioniceMapper = new Application_Model_RadioniceMapper();
        $request = $this->getRequest();
        $tip = $request->getParam('tip');
        if(!empty($tip)){
            $radionica = new Application_Model_Radionice();
            $radionica->setTip($tip);
            if ($tip == 1){$ime = "Crtaonice";}
            if ($tip == 2){$ime = "Maskaonice";}
            if ($tip == 3){$ime = "Plesaonice";}
            $uPripremi = $radioniceMapper->fetchAllWhere($radionica, 'vremePocetka > ' . time(). ' AND id_tip =' . $tip);
            $zavrsene = $radioniceMapper->fetchAllWhere($radionica, 'vremeZavrsetka < ' . time(). ' AND id_tip =' . $tip);
            
            $this->view->naslov1 = $ime . " u najavi";
            $this->view->spremne = $uPripremi;
            if(count($uPripremi)==0){
                $this->view->error1="Trenutno ne postoji nijedna radionica ovog tipa u pripremi.";
            }
            
            $maloIme = strtolower($ime);
            $this->view->naslov = "<br><br>Završene $maloIme";
            $this->view->zavrseneRadionice = $zavrsene;
            if(count($zavrsene)==0){
                $this->view->error="Trenutno ne postoji nijedna završena radionica ovog tipa.";
            }
        }
        else{
            
            $radionicaa = new Application_Model_Radionice();
            $zavrsenee = $radioniceMapper->fetchAllWhere($radionicaa, 'vremeZavrsetka < ' . time());
            $uPriprema = $radioniceMapper->fetchAllWhere($radionicaa, 'vremePocetka > ' . time());
            $this->view->naslov1 = "Radionice u najavi:";
            $this->view->spremne = $uPriprema;
            $this->view->naslov = "Završene radionice:";
            $this->view->zavrseneRadionice = $zavrsenee;
        }
        
        
    }

    public function prikaziAction() {
        // action body
        $request = $this->getRequest();
        if ($request->isGet()) {
            
            $messages = $this->_helper->flashMessenger->getMessages();
            $id = $request->getParam('id');
            if(!empty($id)){
                $radionica = new Application_Model_Radionice();
                $radionicaMapper = new Application_Model_RadioniceMapper();
                $radionicaMapper->find($id, $radionica);
                $komentar = new Application_Model_Komentari();
                $komentar->setRadionica($id);
                $komentarMapper = new Application_Model_KomentariMapper();
                $komentari = $komentarMapper->fetchAllWhere($komentar);
                $slika = new Application_Model_Slike();
                $slika->setRadionica($id);
                $slikaMapper = new Application_Model_SlikeMapper();
                $slike = $slikaMapper->fetchAllWhere($slika);
                $formKomentar = new Application_Form_Komentari();
                $formKomentar->setAction($this->getRequest()->getBaseUrl() . '/Radionice/dodajkomentar/id/' . $id);
                $this->view->form = $formKomentar;
                $this->view->messages = $messages;
                $this->view->idkorisnik = $this->id_korisnik;
                $this->view->radionica = $radionica;
                $session = new Zend_Auth_Storage_Session();
                $idUloga = $session->read()->id_uloga;
                if(!empty($idUloga))
                    $this->view->logged = $idUloga;
                $this->view->komentari = $komentari;
                $this->view->slike = $slike;
            }
        }
    }

    public function dodajkomentarAction() {
        $session = new Zend_Auth_Storage_Session();
        $idUloga = $session->read()->id_uloga;
        if(empty($idUloga)) $this->redirect('Index');
        // imena akcija kontrolera ne mogu sadrzati velika slova, sem pocetnog!
        $request = $this->getRequest();
        $formKomentar = new Application_Form_Komentari();
        $id = $request->getParam('id');
        if (!empty($id)) {
            if ($request->isPost() && $formKomentar->isValid($request->getPost())) {
                $tekst = $this->getParam('taTekst');
                $komentar = new Application_Model_Komentari();
                $komentar->setRadionica($id);
                $komentar->setTekst($tekst);
                $komentar->setKorisnik($this->id_korisnik);
                $komentarMapper = new Application_Model_KomentariMapper();
                $idKomentar = $komentarMapper->insert($komentar);
                if (!empty($idKomentar) && $idKomentar != 0) {
                    $this->_helper->FlashMessenger->addMessage("Vaš komentar je zabeležen.");
                } else {
                    $this->_helper->FlashMessenger->addMessage("OOOPS. Greška pri unosu komentara.");
                }
            } else {
                $id = $request->getParam('id');
                $this->_helper->FlashMessenger->addMessage("Morate uneti tekst komentara.");
            }
            $this->redirect($this->getRequest()->getBaseUrl() . '/Radionice/prikazi/id/' . $id);
        } else {
            $this->_helper->FlashMessenger->addMessage("Radionica nije izabrana.");
        }
    }


}

