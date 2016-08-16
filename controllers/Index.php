<?php
namespace Controllers;
class Index  extends \GF\DefaultController {

  public static $session;
  public static $qlimit=null; //Number of questions to fetch from DB.
  
  public function __construct(){
    parent::__construct();
  }
  
public function index(){
 
  self::$session=$this->app->getSession();
  $model = new \Models\QuizModel();
  
  if($_POST['home']){  //if $_POST is set to ´home´, loads home page
    self::$session->begin='off'; //´off´ - quiz has started; ´on´ - quiz is about to start. Runs \Models\QuizModel->StarNewQuiz and fetches the questions from DB;  
    self::$session->run='off';  //´off´ - quiz is not running; ´on´ - quiz is running
  }
  
  if(self::$session->begin=='off' && self::$session->run=='on'){ //quiz has started; this block goes throw the array and rolls the questions;
    
    try{
    if($model->runQuiz()!='end'){
       $model->checkAnswer();
       $this->view->display('run_quiz');
         } else if($model->runQuiz()=='end') { 
      $model->checkAnswer();
      $this->view->display('dashboard_end');}
     
    } catch(\Exception $exc){
      echo $exc->getMessage();
      echo ' Now you have to start over';
      $_SESSION=array();
    }
  }   
 
  if($_POST['start']){ //start's the quiz from the begining
    //$_SESSION=array();
    self::$session->qlimit=(int)$_POST['qlimit'];
    self::$session->run='on';
    self::$session->begin='on';
    self::$session->home ='off';
    $model->startNewQuiz();
    $this->view->display('run_quiz');
  }
  
   if(self::$session->run !='on' || self::$session->run=='off' || self::$session->home !='off'  ){ //checking if quiz has finished and starts homepage
    $this->view->display('home');
  }
  //echo $_SERVER['REQUEST_URI'];
  //echo "<pre> This is session ".print_r($_SESSION,true)."</pre>";
  //echo "<pre> This is POST ".print_r($_POST,true)."</pre>";
}
}