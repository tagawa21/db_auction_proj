<html>
<body>
<?php
    $servername = "localhost";
    $username = "root";
    $password = "cs434";

    $db = new mysqli($servername, $username, $password, 'auction');
    if ($db->connect_error) {
    die("Connection failed: " . $db->connect_error);
    }

    if(!isset($_COOKIE['user']) OR !isset($_COOKIE['pw'])) {
        echo "<script type='text/javascript'>alert('Invalid cookie.');</script>";
        header('refresh:0;url=logout.php');
    }else{

    $uid = $_COOKIE["user"];
    $name = $_GET["name"];
    echo "Name: ".$name."<br>";
    $bp = $_GET["base_price"];
    echo "Base Price: ".$bp."<br>";
    $byp = $_GET["buy_price"];
    echo "Buy Price: ".$bp."<br>";
    $loc = $_GET["location"];
    echo "Location: ".$loc."<br>";
    $cou = $_GET["country"];
    echo "Country: ".$cou."<br>";
    $des = $_GET["description"];
    echo "Description: ".$des."<br>";
    $cats = $_GET["category"];
    echo "Categories: ".$cats."<br>";
    $cats = explode(',',$cats);
    $iid = 0;
    $query = "SELECT MAX(ItemID)+1 FROM output;";
    $stmt = mysqli_stmt_init($db);
    if(!mysqli_stmt_prepare($stmt, $query))
    {
    echo "Failed to prepare statement\n";
    } else {
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        while($row = mysqli_fetch_array($result)){
            $iid = $row["MAX(ItemID)+1"];
        }
        echo "Item ID: ".$iid;
    }
    $stmt->close();

    $query2 = "INSERT INTO categories(ItemID,Category) VALUES (?,?);";
    foreach($cats as $cat){
        echo " <hr> Category: ".$cat."<br>";
        $stmt2 = mysqli_stmt_init($db);
        if(!mysqli_stmt_prepare($stmt2, $query2))
        {
            echo "Failed to prepare statement\n";
        } else {
            mysqli_stmt_bind_param($stmt2, "is", $iid, $cat);
            mysqli_stmt_execute($stmt2);
            echo "done<hr>";
        }
        $stmt2->close();
    }

    $query3 = "INSERT INTO output(ItemID,Name,Currently,Buy_Price,First_Bid,Number_of_Bids,Top_Bidder,Location,Country,Started,Ends,Description) VALUES (?,?,?,?,0,0,'No Bidders',?,?,NOW(),DATE_ADD(NOW(), INTERVAL 5 MINUTE),?);";
    $stmt3 = mysqli_stmt_init($db);
    if(!mysqli_stmt_prepare($stmt3, $query3))
    {
    echo "Failed to prepare statement\n";
    } else {
        mysqli_stmt_bind_param($stmt3, "isddsss", $iid, $name, $bp, $byp, $loc, $cou, $des);
        mysqli_stmt_execute($stmt3);
        echo "Inserted into output<hr>";
    }
    $stmt3->close();

    $query4 = "INSERT INTO sellers(ItemID,UserID) VALUES (?,?);";
    $stmt4 = mysqli_stmt_init($db);
    if(!mysqli_stmt_prepare($stmt4, $query4))
    {
        echo "Failed to prepare statement\n";
    } else {
        mysqli_stmt_bind_param($stmt4, "is", $iid, $uid);
        mysqli_stmt_execute($stmt4);
        echo "done";
    }
    $stmt4->close();
    
    $db->close();
    echo "<hr>Item successfully loaded.  <a href='sell.php'>Go Back</a>";
}
?>
</body>
</html>