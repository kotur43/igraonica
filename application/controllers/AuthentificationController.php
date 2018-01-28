<?php

class AuthentificationController extends Core_BaseController
{

    private $errorMessages = array();

    private $successMessages = array();

    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction()
    {
        $this->_helper->viewRenderer->setNoRender(true);
        if($this->isAuthentificated){
            $this->redirect("/User");
        }
        $this->redirect('Authentification/login');
    }

    public function registrationAction()
    {   
        
        // action body
        $registrationForm = new Application_Form_Registration();
        $request = $this->getRequest();
        if($request->isPOst() && $registrationForm->isValid($request->getPost())){
            $ime = $request->getParam('tbIme');
            $prezime = $request->getParam('tbPrezime');
            $email = $request->getParam('tbEmail');
            $lozinka = md5($request->getParam('tbLozinka'));
            // provera da li postoji korisnik sa tim email i unos u bazu
            $korisnik = new Application_Model_Korisnici();
            $korisnik->setEmail($email);
            $korisnikMapper = new Application_Model_KorisniciMapper();
            $exists = $korisnikMapper->find($korisnik);
            if(count($exists)>0){
                $this->errorMessages[] = "Vec postoji nalog sa unetom e-mail adresom.";
            }
            else{
                $korisnik->setIme($ime);
                $korisnik->setPrezime($prezime);
                $korisnik->setLozinka($lozinka);
                $korisnik->setUloga(2);
                $korisnikMapper->insert($korisnik);
                $this->_helper->FlashMessenger->addMessage("Uspesno ste se registrovali.");
            }
            $this->redirect('Index');
        }
        $this->view->form = $registrationForm;
    }

    public function loginAction()
    {
//      //action body
        
        if($this->isAuthentificated){
            $this->redirect("/User");
        }
        else {
        $loginForm = new Application_Form_Login();
        $request = $this->getRequest();
        if($request->isPost() && $loginForm->isValid($request->getPost())){
            $email = trim($request->getParam('tbEmail'));
            $lozinka = md5(trim($request->getParam('tbLozinka')));
            // provera da li postoji korisnik u bazi
            $auth = Zend_Auth::getInstance();
            $korisniciDbTable = new Application_Model_DbTable_Korisnici();
            $authAdapter = new Zend_Auth_Adapter_DbTable($korisniciDbTable->getAdapter(), 'korisnici');
            $authAdapter->setIdentityColumn('email')->setCredentialColumn('lozinka');
            $authAdapter->setIdentity($email)->setCredential($lozinka);
            $authentificate = $auth->authenticate($authAdapter);
            if($authentificate->isValid()){
                // ako postoji, kreiranje sesija
                $session = new Zend_Auth_Storage_Session();
                $userDataFromDb = $authAdapter->getResultRowObject(array('id_korisnik','email','id_uloga'), null);
                $session->write($userDataFromDb);
                if($userDataFromDb->id_uloga==1){
                    $this->redirect('/Administration');
                }
                else{
                    $this->redirect('/User');
                }
            }
            else{
                $this->errorMessages[] = "Niste registrovani";
            }
        }
        $this->view->form = $loginForm;
        }
    }

    public function logoutAction()
    {
        $this->_helper->viewRenderer->setNoRender(true);
        if($this->isAuthentificated){
            $sesija = new Zend_Auth_Storage_Session();
            $sesija->clear();
        }
        $this->redirect("/Index");
    }
    

}







