<?php
namespace Models;
class QuizModel
{

    private $db;
    
    public function __construct()
    {
        $this->db = new \GF\DB\SimpleDB();
    }
    //fetch questions from DB, shuffle them, and run quiz
    public function startNewQuiz()
    {        
        if (\Controllers\Index::$session->begin == 'on') {
           
            //First take ONLY the question ids from database
            //and pass them to an array, because there may be gaps in database
            $this->db->prepare('SELECT id FROM qz_questions');
            $this->db->execute();
            $question_ids = $this->db->fetchAllColumn('id');
            //cut array to the number of \Controllers\Index::$qlimit;
            shuffle($question_ids);
            $question_ids = array_slice($question_ids, 0, \Controllers\Index::$session->qlimit);
            //fetch the questions from DB 
            $params       = implode(',', $question_ids);
            $this->db->prepare("SELECT * FROM qz_questions LEFT JOIN qz_answers ON qz_questions.id=qz_answers.question_id WHERE qz_questions.id IN ($params)");
            $this->db->execute();
            $result = $this->db->fetchAllAssoc();
            //shuffle questions
            shuffle($result);
            //Reorder the array and append right/wrong answers to each question in the array
            foreach ($result as $k => $v) {
                if ($v['right_answer'] == 0) {
                    $flag = 'wrong';
                } else {
                    $flag = 'right';
                }
                $questions[$v['id']]['question']         = $v['question_text'];
                $questions[$v['id']]['answers'][][$flag] = $v['answer_text'];              
            }
            //   echo "<pre> This is session ".print_r($questions, true)."</pre>";
            \Controllers\Index::$session->questions         = $questions;
            \Controllers\Index::$session->last_key_position = key(\Controllers\Index::$session->questions);
            \Controllers\Index::$session->right_answers     = 0;
            \Controllers\Index::$session->wrong_answers     = 0;        
            \Controllers\Index::$session->begin = 'off';
        }     
    }
    
    public function runQuiz()
    {
        if (!$_POST || $_POST == array()) {
            throw new \Exception('Do not try to refresh the page!');
        }
        end($_SESSION['questions']);
        $end = key($_SESSION['questions']);
        reset($_SESSION['questions']);
        //echo 'last key is '.$end;
        for ($i = 0; $i < \Controllers\Index::$session->qlimit; $i++) {
            
            //echo key($_SESSION['questions']);
            if ($_SESSION['last_key_position'] == key($_SESSION['questions'])) {        
                break;
            }
            if ($_SESSION['last_key_position'] == $end) {
                return 'end';
            }
            next($_SESSION['questions']);
        }
        next($_SESSION['questions']);
        $_SESSION['last_key_position'] = key($_SESSION['questions']);
        // echo 'KEY '.key($_SESSION['questions']);
    }
    
    public function checkAnswer()
    {
        if ($_POST['right']) {
            \Controllers\Index::$session->right_answers += 1;
        } else if ($_POST['wrong']) {
            \Controllers\Index::$session->wrong_answers += 1;   
        }
        $_POST = null;
    }
}
?>