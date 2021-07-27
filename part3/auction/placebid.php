<html>
<body>
<?php 
    $servername = "localhost";
    $username = "root";
    $password = "cs434";

    if(!isset($_COOKIE['user']) OR !isset($_COOKIE['pw'])) {
        echo "<script type='text/javascript'>alert('Invalid cookie.');</script>";
        header('refresh:0;url=logout.php');
    }
    else{

    $db = new mysqli($servername, $username, $password, 'auction');
    if ($db->connect_error) {
    die("Connection failed: " . $db->connect_error);
    }
    $amount = $_GET['amount'];
    $uid = $_GET['uid'];
    $iid = $_GET['iid'];
    $loc = $_GET['location'];
    $cou = $_GET['country'];
    
    $query = "SELECT * FROM output WHERE output.itemid = ?;";
    $stmt = mysqli_stmt_init($db);
    if(!mysqli_stmt_prepare($stmt, $query))
    {
    echo "Failed to prepare statement\n";
    } else {
        mysqli_stmt_bind_param($stmt, "i", $iid);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        while($row = mysqli_fetch_array($result)){
            $curr = floatval($row['Currently']);
            if($amount > $curr){
                $q2 = "INSERT INTO bids (ItemID,UserID,Location,Country,Time,Amount) VALUES (?,?,?,?,NOW(),?)";
                $stmt2 = mysqli_stmt_init($db);
                echo $cou;
                if(!mysqli_stmt_prepare($stmt2, $q2))
                {
                    echo "Failed to prepare statement\n";
                } else{
                    mysqli_stmt_bind_param($stmt2, "isssd", $iid, $uid, $loc, $cou, $amount);
                    mysqli_stmt_execute($stmt2);
                    echo "Executed";
                }
            }
        }
        $hr = 'refresh:0;url=bid.php?iid='.$iid;
        header($hr);
    }
    $stmt->close();
    $db->close();
    }
?>
</body>
</html>