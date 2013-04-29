<?php
/**
 * TacheController
 * 
 * @author
 * @version 
 */
require_once 'Zend/Controller/Action.php';
class TacheController extends Zend_Controller_Action
{
    /**
     * The default action - show the home page
     */
    public function indexAction ()
    {
        // TODO Auto-generated TacheController::indexAction() default action
    }
public function inscriptionAction ()
    {
        $AFI = new Application_Form_Tache();
        $this->view->formulaireInscri = $AFI;
        //nous v�rifions que les donn�es provenantes du formulaire sont envoy�es par la m�thode POST
        if ($this->getRequest()->isPost()) {
            $formData = $this->getRequest()->getPost();
            /*chargement des donn�es dans la variable $AFI
             $AFI->populate($formData);
             Si le formulaire est vailde, on r�cup�re les donn�es saisies par l'utilisateur � l'aide 
             de getValue */
            if ($AFI->isValid($formData)) {
                $nom = $AFI->getValue('nom');
                $prenom = $AFI->getValue('id_exigence');
                $password = $AFI->getValue('etat');
                $user = new Application_Model_DbTable_Tache();
                $user->addUser($nom, $prenom,$password);
                //la redirection de l'utilisateur apr�s inscription
                $this->_helper->redirector('lst');
                 // donner la possibilit� � l'utilisateur de r�ins�rer les donn�es
            } else {
                $AFI->populate($formData);
            }
        }
    }

    
    //Cette fonction permet de lister le contenu de la Table "utilisateur"
    public function lstAction ()
    {
        //instanciation du mod�le "utilisateur" pour extraire les donn�es de la base de donn�es 
        $ut = new Application_Model_DbTable_Tache();
        /* la fonction "fetchAll" permet de parcourir la base de donn�es et inclure le r�sultat dans l'objet 
         "users" qui sera parcouru dans la vue "lst" . (voir la vue lst.phtml) */
        $this->view->users = $ut->fetchAll();
    }
    
    
    //La fonction "editAction" permet de modifier une ligne de la liste des utilisateurs
    public function editAction ()
    {
        // On instancie un nouvel objet du formulaire "inscription"
        $form = new Application_Form_Tache();
        //On change le label du bouton "valider" par "Save"
        $form->ajouter->setLabel('Save');
        //on affecte ce nouveau formulaire � la vue "edit" qui contient affiche l'objet "form2" (voir la vue edit.phtml)
        $this->view->form2 = $form;
        /* on teste si le contenu du formulaire est pr�t � l'envoi
        puis on pr�pare la r�cup�ration de son contenu */
        if ($this->getRequest()->isPost()) {
            $formData = $this->getRequest()->getPost();
            /* si les donn�es sont valides on r�cup�re chaque valeur de chaque 
            champs pour les �diter*/
            if ($form->isValid($formData)) {
                $id = (int) $form->getValue('id');
                $nom = $form->getValue('nom');
                $prenom = $form->getValue('id_exigence');
                $password = $form->getValue('etat');
                
                
                //on instancie un nouvel objet Application_Model_DbTable_Utilisateur
                $users = new Application_Model_DbTable_Tache();
                
                //on fait appel � la fonction "updateUser" de la classe "Application_Model_DbTable_Utilisateur"
                $users->updateUser($id, $nom, $prenom,$password);
                
                //apr�s la mise � jour on redirige l'utilisateur vers l'action "lst"
                $this->_helper->redirector('lst');
                
            } 
            
            else 
            {
            	/*Si les donn�es ne sont pas valides, on rempli de nouveau le formulaire avec 
            	les valeurs par d�faut provenant de la Base de donn�es (c'est le r�le de la fonction populate) */
                $form->populate($formData);
            }
        } else {
        	/*Dans le cas o� le formulaire n'envoie pas les donn�es, c-a-d "$this->getRequest->isPost" n'est pas v�rifi�e
        	on r�cup�re l'id pour reboucler sur le m�me contenu de la ligne � modifier.
        	La fonction _getParam permet de r�cup�rer la valeur de l'id sinon elle prend par d�faut la valeur '0' */
            $id = $this->_getParam('id', 0);
            if ($id > 0) {
                $users = new Application_Model_DbTable_Tache();
                $form->populate($users->getUser($id));
            }
        }
    }
    
    //la fonction deleteAction permet de supprimer un enregistrement de la base de donn�es
    public function deleteAction ()
    {
        if ($this->getRequest()->isPost()) {
        	
        	/* on r�cup�re dans la variable $del la valeur du champs "del" de notre formulaire qui peut �tre
        	 soit "YES" soit "NO"*/
            $del = $this->getRequest()->getPost('del');
            //Si la valeur de "del" est "YES" c'est que l'utilisateur a confirm� la suppression
            if ($del == 'YES') {
                //$id = $this->_getParam('id', 0);
                $id = $this->getRequest()->getPost('id');
                $users = new Application_Model_DbTable_Tache();
                $users->deleteUser($id);
            }
            //puis on redirige de nouveau vers l'action "lst" pour revenir � la liste des utilisateurs
            $this->_helper->redirector('lst');
        } else {
            $id = $this->_getParam('id', 0);
            $users = new Application_Model_DbTable_Tache();
            $this->view->users = $users->getUser($id);
        }
    }
    
    public function rechercheAction(){
    	$r= new Application_Form_Recherche();
    	$this->view->formrecherche=$r;
    	
    	if ($this->getRequest()->isPost()){
    		$data=$this->getRequest()->getPost();
    		if ($r->isValid($data)){
    			$mot=$r->getValue("zone");
    			$users = new Application_Model_DbTable_Tache();
    			//$p =$users->fetchAll("nom ='".$mot."'");
    			$p =$users->rechercheUser($mot);
    			$this->view->formre = $p;
    			
    		}
    		
    	}
    	
    }
}
