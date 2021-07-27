<html>
<head>
<title> Auction Site </title>
</head>
<body>
<form action = "results.php" method="get">
<input type = "radio" id = "desc" name = "op" value="description" checked="checked">
<label for="desc">In description</label><br >

<input type = "radio" id = "sell" name = "op" value="sellers">
<label for="sell">In seller</label><br >

<input type = "radio" id = "cat" name = "op" value="categories">
<label for="cat">In category</label><br >
<br/>
<input type = "text" name="query">
<input type = "submit" value="Search">
</form>
<hr>
Want to sell something?  <a href="sell.php">Click here.</a><br>
Want to log out?  <a href="logout.php">Click here.</a>
</body>
</html>