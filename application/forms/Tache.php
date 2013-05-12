<?php
class Application_Form_Tache extends Zend_Form
{
	// la fonction "init" permet d'initialiser un formulaire avec tous 
	//ses �l�ments(text,radio,button,submit,select,etc..) 
    public function init ()
    {
        $ut = new Application_Model_DbTable_Exigences();
    	$this->setName("FormulaireTache");
         
        $id= new Zend_Form_Element_Hidden("id");/*on utilise un �l�ment "id" cach� pour passer sa valeur 
        en param�tre lors de la modification ou la suppression d'un utilisateur */
        $nom = new Zend_Form_Element_Text("nom");
        $nom->setLabel("Nom :");
        //$nom->setRequired();
        $pays= new Zend_Form_Element_Select("id_exigence");
        $pays->setLabel("Id de l'exigence : ");
        foreach ($ut->fetchAll() as $user):
        $pays->addMultiOptions(array($user->id=>$user->id));
        endforeach;
        $etav= new Zend_Form_Element_Select("etat");
        $etav->addMultiOptions(array(1=>1,2=>2,3=>3,4=>4,5=>5,6=>6,7=>7,8=>8,9=>9,10=>10));         
        $etav->setLabel("Etat d'avancement :"); 
             dddddddd;
        $valider = new Zend_Form_Element_Submit("ajouter");
        $valider->setLabel("valider");
        $this->addElements(array($id,$nom,$pays,$etav,$valider ));
    }
}
?>
