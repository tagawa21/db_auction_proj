<html>
<body>
Here are the items that match your search:
<hr/>
<?php
$servername = "localhost";
$username = "root";
$password = "cs434";

$db = new mysqli($servername, $username, $password, 'auction');
if ($db->connect_error) {
  die("Connection failed: " . $db->connect_error);
}

$op = $_GET['op'];
$q = $_GET['query'];

if(strcmp($op,'sellers') == 0){
  $query = "SELECT * FROM output, sellers WHERE sellers.userID = ? AND output.itemid = sellers.itemid ORDER BY currently LIMIT 33;";
  $stmt = mysqli_stmt_init($db);
  if(!mysqli_stmt_prepare($stmt, $query))
  {
    echo "Failed to prepare statement\n";
  } else{
    mysqli_stmt_bind_param($stmt, "s", $q);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    echo "<b>Cheapest to Most Expensive</b><table>";
    while($row = mysqli_fetch_array($result)){
      echo "<tr><td>". $row["ItemID"]." || ".$row["Name"]." || Current Bid: $".$row["Currently"]."</td><td>".
      " || <a href='bid.php?iid=".$row["ItemID"]."'>Bid Now!</a></td>".
      "</tr>\n";
    }
    echo "</table><hr>";
  }
  $query = "SELECT * FROM output, sellers WHERE sellers.userID = ? AND output.itemid = sellers.itemid ORDER BY currently desc LIMIT 33;";
  $stmt = mysqli_stmt_init($db);
  if(!mysqli_stmt_prepare($stmt, $query))
  {
    echo "Failed to prepare statement\n";
  } else{
    mysqli_stmt_bind_param($stmt, "s", $q);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    echo "<b>Most Expensive to Cheapest</b><table>";
    while($row = mysqli_fetch_array($result)){
      echo "<tr><td>". $row["ItemID"]." || ".$row["Name"]." || Current Bid: $".$row["Currently"]."</td><td>".
      " || <a href='bid.php?iid=".$row["ItemID"]."'>Bid Now!</a></td>".
      "</tr>\n";
    }
    echo "</table><hr>";
  }
  $query = "SELECT * FROM output, sellers WHERE sellers.userID = ? AND output.itemid = sellers.itemid ORDER BY ends desc LIMIT 33;";
  $stmt = mysqli_stmt_init($db);
  if(!mysqli_stmt_prepare($stmt, $query))
  {
    echo "Failed to prepare statement\n";
  } else{
    mysqli_stmt_bind_param($stmt, "s", $q);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    echo "<b>Latest to End</b><table>";
    while($row = mysqli_fetch_array($result)){
      echo "<tr><td>". $row["ItemID"]." || ".$row["Name"]." || Current Bid: $".$row["Currently"]."</td><td>".
      " || <a href='bid.php?iid=".$row["ItemID"]."'>Bid Now!</a></td>".
      "</tr>\n";
    }
    echo "</table>";
  }
  $stmt->close();
  $db->close();
}
elseif(strcmp($op,'description') == 0){
  $query = "SELECT * FROM output WHERE output.description LIKE '%?%' ORDER BY currently LIMIT 33;";
  $stmt = mysqli_stmt_init($db);
  if(!mysqli_stmt_prepare($stmt, $query))
  {
    echo "Failed to prepare statement\n";
  } else{
    mysqli_stmt_bind_param($stmt, "s", $q);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    echo "<b>Cheapest to Most Expensive</b><table>";
    while($row = mysqli_fetch_array($result)){
      echo "<tr><td>". $row["ItemID"]." || ".$row["Name"]." || Current Bid: $".$row["Currently"]."</td><td>".
      " || <a href='bid.php?iid=".$row["ItemID"]."'>Bid Now!</a></td>".
      "</tr>\n";
    }
    echo "</table>";
  }
  $query = "SELECT * FROM output WHERE output.description LIKE '%?%' ORDER BY currently desc LIMIT 33;";
  $stmt = mysqli_stmt_init($db);
  if(!mysqli_stmt_prepare($stmt, $query))
  {
    echo "Failed to prepare statement\n";
  } else{
    mysqli_stmt_bind_param($stmt, "s", $q);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    echo "<hr><table><tr><td><b>Most Expensive to cheapest</b></td></tr>";
    while($row = mysqli_fetch_array($result)){
      echo "<tr><td>". $row["ItemID"]." || ".$row["Name"]." || Current Bid: $".$row["Currently"]."</td><td>".
      " || <a href='bid.php?iid=".$row["ItemID"]."'>Bid Now!</a></td>".
      "</tr>\n";
    }
    echo "</table>";
  }
  $query = "SELECT * FROM output WHERE output.description LIKE '%?%' ORDER BY ends LIMIT 33;";
  $stmt = mysqli_stmt_init($db);
  if(!mysqli_stmt_prepare($stmt, $query))
  {
    echo "Failed to prepare statement\n";
  } else{
    mysqli_stmt_bind_param($stmt, "s", $q);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    echo "<hr><table><tr><td><b>Latest to End</b></td></tr>";
    while($row = mysqli_fetch_array($result)){
      echo "<tr><td>". $row["ItemID"]." || ".$row["Name"]." || Current Bid: $".$row["Currently"]."</td><td>".
      " || <a href='bid.php?iid=".$row["ItemID"]."'>Bid Now!</a></td>".
      "</tr>\n";
    }
    echo "</table>";
  }
  $stmt->close();
  $db->close();

} 
else{
  $query = "SELECT * FROM output, categories WHERE output.itemid = categories.itemid and categories.category = ? ORDER BY currently LIMIT 33;";
  $stmt = mysqli_stmt_init($db);
  if(!mysqli_stmt_prepare($stmt, $query))
  {
    echo "Failed to prepare statement\n";
  } else{
    mysqli_stmt_bind_param($stmt, "s", $q);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    echo "<table><tr><td><b>Cheapest to Most Expensive</b></td></tr>";
    while($row = mysqli_fetch_array($result)){
      echo "<tr><td>". $row["ItemID"]." || ".$row["Name"]." || Current Bid: $".$row["Currently"]."</td><td>".
      " || <a href='bid.php?iid=".$row["ItemID"]."'>Bid Now!</a></td>".
      "</tr>\n";
    }
    echo "</table>";
  }
  $query = "SELECT * FROM output, categories WHERE output.itemid = categories.itemid and categories.category = ? ORDER BY currently desc LIMIT 33;";
  $stmt = mysqli_stmt_init($db);
  if(!mysqli_stmt_prepare($stmt, $query))
  {
    echo "Failed to prepare statement\n";
  } else{
    mysqli_stmt_bind_param($stmt, "s", $q);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    echo "<hr><table><tr><td><b>Most Expensive to cheapest</b></td></tr>";
    while($row = mysqli_fetch_array($result)){
      echo "<tr><td>". $row["ItemID"]." || ".$row["Name"]." || Current Bid: $".$row["Currently"]."</td><td>".
      " || <a href='bid.php?iid=".$row["ItemID"]."'>Bid Now!</a></td>".
      "</tr>\n";
    }
    echo "</table>";
  }
  $query = "SELECT * FROM output, categories WHERE output.itemid = categories.itemid and categories.category = ? ORDER BY ends LIMIT 33;";
  $stmt = mysqli_stmt_init($db);
  if(!mysqli_stmt_prepare($stmt, $query))
  {
    echo "Failed to prepare statement\n";
  } else{
    mysqli_stmt_bind_param($stmt, "s", $q);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    echo "<hr><table><tr><td><b>Latest to End</b></td></tr>";
    while($row = mysqli_fetch_array($result)){
      echo "<tr><td>". $row["ItemID"]." || ".$row["Name"]." || Current Bid: $".$row["Currently"]."</td><td>".
      " || <a href='bid.php?iid=".$row["ItemID"]."'>Bid Now!</a></td>".
      "</tr>\n";
    }
    echo "</table>";
  }
  $stmt->close();
  $db->close();
}
?>
<hr/>
<a href="search.php">Return to Search</a>
</body>
</html>