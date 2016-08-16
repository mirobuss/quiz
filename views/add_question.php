<html>
<head>
	<link type="text/css" rel="stylesheet" href="../views/1.css"/>
	<meta name="viewport" content="width=device-width, initial-scale=1">	
</head>
<body>
<h1>Add question
	</h1>
<form name="add" method="post">
	<textarea name="question" autofocus maxlength="250" rows="4" cols="30" placeholder="Add question text here..."></textarea>
  <div class="answer-inputs">	
	  <div>Answer 1 <input type="text" name="answer1" placeholder="First answer"/> <input type="radio" name="right" value="1"> *</div>
	  <div>Answer 2 <input type="text" name="answer2" placeholder="Second answer"/> <input type="radio" name="right" value="2"> *</div>
	  <div>Answer 3 <input type="text" name="answer3" placeholder="Third answer (optional)"/> <input type="radio" name="right" value="3"></div>
	  <div>Answer 4 <input type="text" name="answer4"placeholder="Fourth answer (optional)"/> <input type="radio" name="right" value="4"></div>
  </div>
  <input type="submit" name="add" value="Add question"/>
</form>
<a href="../../">Back to home page</a>
</body>	
</html>	
