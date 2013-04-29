<?php
/*la classe doit commencer obligatoirement par "Application_Form" 
et doit h�riter de la classe "Zend_Form", 
il s'agit l� d'une convention de Zend */

class Application_Form_Authentification extends Zend_Form
{
    /* la fonction init() permet d'initialiser le formulaire */
	public function init ()
    {
        /* la m�thode "setName" permet d'attribuer un nom au formulaire 
        qui sera affich� dans le html*/
    	$this->setName("FormulaireAuthentification");
        
    	/*cr�er une variable dans laquelle on instancie 
    	 la classe "Zend_Form_Element_Text"*/
        $login = new Zend_Form_Element_Text("login");
        $login->setRequired();
        $login->setAttribs(array('style' => 'background:#7EDB39;'));
        //$login->setAttribs(array('style' => 'font:"Lucida Grande","Lucida Unicode"'));
        /*la variable doit avoir un label en utilsant la fonction "setLabel" */
        $login->setLabel("Login : ");
        
		/*on fait pareil pour le mot de passe*/
        $password = new Zend_Form_Element_Password("password");
        $password->setRequired();
        $password->setAttribs(array('style' => 'background:#7EDB39;'));
        $password->setLabel("Mot de passe : ");
        
        /* on fait pareil pour le bouton*/
        $valider = new Zend_Form_Element_Submit("valider");
        $valider->setLabel("Valider");
        
        /*la fonction "addElements" permet de prendre en charge
          tous les �l�ments HTML d'un formaulire dans un tableau*/
        $this->addElements(array($login, $password, $valider));
    }
}
?>