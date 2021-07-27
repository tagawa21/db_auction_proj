<html>
<head>
<title> Auction Site </title>
</head>
<body>
<?php
$servername = "localhost";
$username = "root";
$password = "cs434";
$db = new mysqli($servername, $username, $password, 'auction');
if ($db->connect_error) {
    die("Connection failed: " . $db->connect_error);
}

$name = $_POST['name'];
$pw = hash('ripemd160', $_POST['pw']);

$query = "SELECT * FROM users where UID = ? AND Password = ?;";
    $stmt = mysqli_stmt_init($db);
    if(!mysqli_stmt_prepare($stmt, $query))
    {
    echo "Failed to prepare statement\n";
    } else {
        mysqli_stmt_bind_param($stmt, "ss", $name,$pw);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        while($row = mysqli_fetch_array($result)){
            if(strcmp($name,$row['UID']) == 0 and strcmp($pw,$row['Password']) == 0){
                setcookie('user',$name, time() + 3600 , '/');
                setcookie('pw',$pw, time() + 3600, '/');
                $hr = 'refresh:0;url=search.php';
                header($hr);
            } else{
                echo 'err';
                $hr = 'refresh:0;url=logout.php';
                header($hr);

            }
        }
    }
    $stmt->close();
    $db->close();
?>
Your credentials are incorrect.  Please try again.
<a href="login.php">Go back.</a>
</body>
</html>