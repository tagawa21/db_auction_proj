<html>
<body>
    <?php
        $user = $_COOKIE['user'];
        $pw = $_COOKIE['pw'];
        setcookie('user', $user, time() - 3600,'/');
        setcookie('pw', $pw, time() - 3600,'/');
        $hr = 'refresh:0;url=login.php';
        header($hr);
    ?>
</body>
</html>