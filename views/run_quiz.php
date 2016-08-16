<html>
	<head>
		<link type="text/css" rel="stylesheet" href="../views/1.css"/>
		<meta name="viewport" content="width=device-width, initial-scale=1">
	</head>
<body>	
<form name="run_quiz" method="post">
	<div  class='question'>
	<h2><?php 
	echo \Controllers\Index::$session->questions[key(\Controllers\Index::$session->questions)]['question'].
	"</h2></div>"; 
	
	foreach(\Controllers\Index::$session->questions[key(\Controllers\Index::$session->questions)]['answers'] as $v){
		foreach ($v as $kk=>$vv){?>
	<div class="answers">
	<input type="submit" name="<?php echo $kk; ?>" value="<?php echo $vv; ?>" class="button"/></div>
		<?php }
	}
	?>	
</form>
<div class="result clearfix">
	<div class="leftscore">Right answers: <?php echo $_SESSION['right_answers'];?></div>
	<div class="rightscore">Wrong answers: <?php echo $_SESSION['wrong_answers'];?></div>
</div> <!--result-->
</body>
</html>