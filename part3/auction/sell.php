<html>
<head>
<?php
    $user = $_COOKIE['user'];
    $pw = $_COOKIE['pw'];
    if(!isset($_COOKIE['user']) OR !isset($_COOKIE['pw'])) {
        echo "<script type='text/javascript'>alert('Invalid cookie.');</script>";
        header('refresh:0;url=login.php');
    }
?>
</head>
<body>
<b>Sell Something</b><hr>
<form action="parseitem.php" method="GET">
    Item Name <input type="text" name="name" value="Item name"><br>
    Minimum Price <input type="number" step = "0.01" min="0.00" value="0" name="base_price"><br>
    Buy Price <input type="number" step = "0.01" min="0.00" value="0" name="buy_price"><br>
    Location <input type="text" name="location" value="Nowheresville"><br>
    Country <input type="text" name="country" value="USA"><br>
    Categories (Separate with commas): <input type="text" name="category" value="cat1"><br>
    Description: <input type="text" name="description" value=""><br>
    <br><input type="submit" value="Submit Item"><br>
</form>
<hr>
<a href="search.php">Back to search</a>
</body>
</html>