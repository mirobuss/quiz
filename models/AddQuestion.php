<?php 
namespace Models;
class AddQuestion{
	private $db;
  //hardcoding the number of answers here is not very clever descision. Fix it later, when add some JavaScript to the form;
	private $question;
	private $answer1=null;
	private $answer2=null;
	private $answer3=null;
	private $answer4=null;
	private $right_answer;
	private $lastid;
	
	public function __construct(){
    $this->db=new \GF\DB\SimpleDB();
  }
	
	public function check(){
		$this->question=trim($_POST['question']);
		$this->answer1=trim($_POST['answer1']);
		$this->answer2=trim($_POST['answer2']);
		$this->answer3=trim($_POST['answer3']);
		$this->answer4=trim($_POST['answer4']);
		$this->right_answer=(int)$_POST['right'];
		
		if($this->answer1==null || $this->answer2==null){ 
			throw new \Exception('Answer 1 and Answer 2 are mandatory and cannot be empty');
		}
		
		if($this->question==null || mb_strlen($this->question)<=3)
		{
	    throw new \Exception('Question cannot be empty');
 	
		}
		
		if($this->answer4!=null && $this->answer3==null){
			throw new \Exception('You forgot to type something in answer3');
		}
		
		if(!$_POST['right']){
			throw new \Exception('There is no right answer');
		}
		
		if(($this->answer3==null && $_POST['right']==3) || ($this->answer4==null && $_POST['right']==4)){
			throw new \Exception('Empty answer cannot be right');
		}
		//this block checks for duplicate answers
		$array=array($this->answer1,$this->answer2,$this->answer3,$this->answer4);
		foreach ($array as $k=>$v){
			if($v==null || $v=='' || empty($v)){unset($array[$k]);}
		} 
		//echo "<pre> First array ".print_r($array,true)."</pre>";
		$unique=array_unique($array);
		//echo "<pre> Second array ".print_r($unique,true)."</pre>";
		if(count($array) !=count($unique)){
			throw new \Exception('Answers must be unique');
		}
		
		//echo $this->question."<br/>";
		//echo "<pre> This is POST ".print_r($_POST,true)."</pre>";
	try{$this->AddToDB();}
		catch(Exception $exc){$exc->getMessage();}
	}
		
	public function AddToDB(){
		//Insert question into DB and get last id
		$params[]=$this->question;
		$this->db->prepare("INSERT INTO qz_questions (question_text) VALUES (?)",$params);
		$this->db->execute();
		$this->lastid = $this->db->getLastInsertId();
		//echo "last id $this->lastid";
		$answers=array(1=>$this->answer1, 2=>$this->answer2, 3=>$this->answer3, 4=>$this->answer4);
		foreach($answers as $k=>$v){
			//if answer field in the form is empty, stop adding answers into array;
			//There may be empty fields, but gaps between answers are not allowed;
			if($v==null) {break;}  
			$params=array();
			$params[0]=$this->lastid;
			$params[1]=$v;
			if($k==$this->right_answer){
				$params[2]=1;
			} else 
			{$params[2]=0;}
			//inserd answers in DB with question ID appended;
			$this->db->prepare("INSERT INTO qz_answers (question_id, answer_text, right_answer) VALUES (?,?,?)",$params);
		  $this->db->execute();
		}
		//TODO - to show this message on different place;
		echo 'Question successfully added.';
	}
	}
?>
