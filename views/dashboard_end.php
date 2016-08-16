<html>
<head>
	<link type="text/css" rel="stylesheet" href="../views/1.css"/>
	<meta name="viewport" content="width=device-width, initial-scale=1">
</head>
<body>
	
<h2 class="head">Game Over</h2>

<div class="start">
		<div class="finish">You have <?php echo $_SESSION['wrong_answers'];?> wrong answers and <?php echo $_SESSION['right_answers'];?> right answers.</div>
    <hr>	
    <form name="finish" method="post">
	     <input class= "button" type="submit" name="home" value="Go to home page"/>
   </form>
</div> <!--start-->
</body>
</html>