<?php 
namespace Controllers;
class Add extends \GF\DefaultController{
	
	public function __construct(){
		parent::__construct();
	}
	
	public function question() {
		$model=new \Models\AddQuestion();
		$this->view->display('add_question');
		
		if($_POST){
			try{
				$model->check();
			}
			catch (\Exception $exc) {
				echo $exc->getMessage();
			}
							
		}

	}
	
}
?>