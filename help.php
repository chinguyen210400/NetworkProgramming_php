<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css" integrity="sha384-B4dIYHKNBt8Bc12p+WXckhzcICo0wtJAoU8YZTY5qE0Id1GSseTk6S+L3BlXeVIU" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="./assets/css/index.css">
    <title>Help</title>
<?php 
session_start();
if (isset($_POST['help'])) {
$socket = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);
if ($socket === false) {
    echo "socket_create() failed: reason: " . socket_strerror(socket_last_error()) . "\n";
}
// connect to server
$result = socket_connect($socket, "127.0.0.1", 9999);
if ($result === false) {
    echo "socket_connect() failed.\nReason: ($result) " . socket_strerror(socket_last_error($socket)) . "\n";
}
    if ($_SESSION["help"] >=1 ) {
    $msg = "7|".$_SESSION["question_id"]."|";

    $ret = socket_write($socket, $msg, strlen($msg));
    if (!$ret) die("client write fail:" . socket_strerror(socket_last_error()) . "\n");

    // receive response from server
    $response = socket_read($socket, 1024);
    if (!$response) die("client read fail:" . socket_strerror(socket_last_error()) . "\n");

    $response = explode("|", $response);

    if ($response[0] == "14" ) {
        $_SESSION["help"] = $_SESSION["help"] -1 ;
        echo "<script>alert('$response[1]!');</script>";
    }
    }else {
        echo "<script>alert('Sorry ! You do not have any help !');</script>";
    }

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
    <div class = "question_form d-flex justify-content-center">
        <?php echo $_SESSION["question"];?>
    </div>
    <div class="index_button_group d-flex justify-content-center"> 
    <div class="btn-group-vertical ">
    <form action="playgame.php" method="post">
        <input type="submit" class="btn  btn-lg btn-outline-primary mt-4 " name ="answer" value="<?php echo $_SESSION["answerA"]; ?>" >
        <input type="submit" class="btn  btn-lg btn-outline-primary mt-4 " name ="answer" value="<?php echo $_SESSION["answerB"]; ?>" >
        <input type="submit" class="btn  btn-lg btn-outline-primary mt-4 " name ="answer" value="<?php echo $_SESSION["answerC"]; ?>" >
        <input type="submit" class="btn  btn-lg btn-outline-primary mt-4 " name ="answer" value="<?php echo $_SESSION["answerD"]; ?>" >
        <input type="hidden"name ="questionid" value="<?php echo $question_id; ?>" >
        
    </form>
    <form action = "score.php" method = "post">
          <input type="submit" class="btn  btn-lg btn-outline-primary mt-4 " name ="stop" value="STOP" >
    </form>

    <form action = "help.php" method = "post">
          <input type="submit" class="btn  btn-lg btn-outline-primary mt-4 " name ="help" value="HELP <?php echo $_SESSION["help"]; ?>" >
    </form>
    </div>
    </div>

    <?php include('footer.php'); ?>
</body>

</html>