<html>
<body>
<hr/>
<b>Item Information</b><br>
<?php
    $servername = "localhost";
    $username = "root";
    $password = "cs434";

    $user = $_COOKIE['user'];
    $pw = $_COOKIE['pw'];

    if(!isset($_COOKIE['user']) OR !isset($_COOKIE['pw'])) {
            echo "<script type='text/javascript'>alert('Invalid cookie.');</script>";
            header('refresh:0;url=login.php');
        }
     
    else{
    $db = new mysqli($servername, $username, $password, 'auction');
    if ($db->connect_error) {
    die("Connection failed: " . $db->connect_error);
    }
    $un =  $_COOKIE["user"];
    $iid = $_GET["iid"];

    $query = "SELECT * FROM output WHERE output.itemid = ?;";
    $stmt = mysqli_stmt_init($db);
    if(!mysqli_stmt_prepare($stmt, $query))
    {
    echo "Failed to prepare statement\n";
    } else {
    mysqli_stmt_bind_param($stmt, "i", $iid);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    echo "<table>";
    while($row = mysqli_fetch_array($result)){
        //var_dump($row);
        echo "Item ID: ". $row["ItemID"]."<br>";
        echo "Item name: ". $row["Name"]."<br>";
        echo "First bid: $". $row["First_Bid"]."<br>";
        echo "Current bid: $". $row["Currently"]."<br>";
        echo "Top bidder: ". $row["Top_Bidder"]."<br>";
        echo "Number of bids: ". $row["Number_of_Bids"]."<br>";
        echo "Location: ". $row["Location"]."<br>";
        echo "Country: ". $row["Country"]."<br>";
        echo "Started: ". $row["Started"]."<br>";
        echo "Ends: ". $row["Ends"]."<br>";
        echo "Description:". $row["Description"]."<br>";
        $bend = strtotime($row["Ends"]);
        //echo $bend."<br>";
        //echo time()+(60*60*24);
        if((time()+(60*60*24)) < $bend){
            echo "<script type='text/javascript'>alert('ERROR: Bidding period is over.');</script>";
            header('refresh:0;url=error.php');
        } else{
            echo'<hr/>
            <form action = "placebid.php">
            Item ID: <input type="text" name="iid" readonly="readonly" value = "'.$iid.'"><br>
            User ID: <input type="text" name="uid" readonly="readonly" value = "'.$un.'"><br>
            Bid Amount: <input type="number" name="amount" step="0.01" min="0" value="0"><br>
            Location: <input type="text" name="location" value=""><br>
            Country: <input type="text" name="country" value = ""><br>
            <input type = "submit" value="Submit Bid">
            </form>';
        }
    }
    echo "</table>";
    }
    $stmt->close();
    $db->close();
    }
?>

<hr>
<a href="search.php">Back to search</a>
</body>
</html>