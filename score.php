<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="./assets/css/index.css">
    <title>Score</title>
<?php
    // Start the session
	session_start();
    $socket = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);
    if ($socket === false) {
        echo "socket_create() failed: reason: " . socket_strerror(socket_last_error()) . "\n";
    }
    // connect to server
    $result = socket_connect($socket, "127.0.0.1", 9999);
    if ($result === false) {
        echo "socket_connect() failed.\nReason: ($result) " . socket_strerror(socket_last_error($socket)) . "\n";
    }
    if (isset($_POST['stop'])){
         $msg = "8|".$_SESSION["username"]."|".$_SESSION["position"]."|";

        $ret = socket_write($socket, $msg, strlen($msg));
        if (!$ret) die("client write fail:" . socket_strerror(socket_last_error()) . "\n");

        // receive response from server
        $response = socket_read($socket, 1024);
        if (!$response) die("client read fail:" . socket_strerror(socket_last_error()) . "\n");

        //echo $response;
  
    }
    socket_close($socket);
?>
</header>
<body>
    <?php include('home_navbar.php'); ?>
    <div class="home_container">
        <div class="index_image">
    <img src="./prjltm.jpg" class="rounded mx-auto d-block " alt="index.php" >
</div>
<div class="score_display ">
<?php echo $_SESSION["position"];?>
</div>
<form action="home.php" method="post">
        <input type="submit" class="btn  btn-lg btn-outline-primary mt-4 " name ="home" value="OK" >
    </form>
</div>
    <?php include('footer.php'); ?>
</body>

</html>