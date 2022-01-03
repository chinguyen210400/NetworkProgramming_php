<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css" integrity="sha384-B4dIYHKNBt8Bc12p+WXckhzcICo0wtJAoU8YZTY5qE0Id1GSseTk6S+L3BlXeVIU" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="./assets/css/index.css">
    <title>Play Game</title>
    
<?php
session_start();

if (isset($_POST['answer'])) {

    // create socket
    $socket = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);
    if ($socket === false) {
        echo "socket_create() failed: reason: " . socket_strerror(socket_last_error()) . "\n";
    }
    // connect to server
    $result = socket_connect($socket, "127.0.0.1", 9999);
    if ($result === false) {
        echo "socket_connect() failed.\nReason: ($result) " . socket_strerror(socket_last_error($socket)) . "\n";
    }

    // 
    
    $answer = $_POST['answer'];
    $answer = explode(".", $answer)[0];
    $msg = "6|".$_SESSION["question_id"]."|".$answer."|";

    $ret = socket_write($socket, $msg, strlen($msg));
    if (!$ret) die("client write fail:" . socket_strerror(socket_last_error()) . "\n");

    // receive response from server
    $response = socket_read($socket, 1024);
    if (!$response) die("client read fail:" . socket_strerror(socket_last_error()) . "\n");
    //echo $response;

    // split response from server
    $response = explode("|", $response);

    if ($response[0] == "13" ) {
    	$_SESSION["position"] = $_SESSION["position"] + 1;
        //echo "<script>alert('$response[1]');</script>";
        //echo $_SESSION["position"];
        
        
    }elseif ($response[0] == "19" )  {
        if ($_SESSION["position"]==0){
            $_SESSION["position"]=0;
        }
        elseif ($_SESSION["position"] >=1 && $_SESSION["position"] < 5 )
        {
            $_SESSION["position"]=1;
            
        }elseif($_SESSION["position"]>=5 && $_SESSION["position"] <10 )
        {
            $_SESSION["position"]=5;
        }elseif($_SESSION["position"]>=10 && $_SESSION["position"] <15) {
            $_SESSION["position"] =10;
            
        }
        $msg = "9|".$_SESSION["username"]."|".$_SESSION["position"]."|";

        $ret = socket_write($socket, $msg, strlen($msg));
        if (!$ret) die("client write fail:" . socket_strerror(socket_last_error()) . "\n");

        // receive response from server
        $response = socket_read($socket, 1024);
        if (!$response) die("client read fail:" . socket_strerror(socket_last_error()) . "\n");

        echo "<script>alert('Your answer is incorrect!');</script>";
        echo "<script>window.location.href = 'score.php';</script>";
        
    }

    // close socket
    socket_close($socket);
}
?>
<?php 
        $socket = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);
        if ($socket === false) {
            echo "socket_create() failed: reason: " . socket_strerror(socket_last_error()) . "\n";
        }
        // connect to server
        $result = socket_connect($socket, "127.0.0.1", 9999);
        if ($result === false) {
            echo "socket_connect() failed.\nReason: ($result) " . socket_strerror(socket_last_error($socket)) . "\n";
        }

        //echo $response;

        do {
            $msg = "4|".$_SESSION["position"]."|";
    
            $ret = socket_write($socket, $msg, strlen($msg));
            if (!$ret) die("client write fail:" . socket_strerror(socket_last_error()) . "\n");
    
            // receive response from server
            $response = socket_read($socket, 1024);
            if (!$response) die("client read fail:" . socket_strerror(socket_last_error()) . "\n");
            //echo $response;
    
            // split response from server
            $response = explode("|", $response);
    
            if ($response[0] == "12" ) {
            $_SESSION["question_id"] = $response[1];
            $_SESSION["question"] = $response[2];
            $_SESSION["answerA"] = $response[3];
            $_SESSION["answerB"] = $response[4];
            $_SESSION["answerC"] = $response[5];
            $_SESSION["answerD"] = $response[6];
                //echo "<script>alert('$question_id');</script>";
                // echo "<script>alert('$_SESSION["questionList"]');</script>";
                //echo "<script>window.location.href = 'playgame.php';</script>";
            } else {
                echo "<script>alert('Game loading fail');</script>";
                echo "<script>window.location.href = 'home.php';</script>";
            }
            //print_r($_SESSION["questionList"]);
        } while (array_search( $_SESSION["question_id"], $_SESSION["questionList"]) != false);
        $check = array_search( $_SESSION["question_id"], $_SESSION["questionList"]);
        /*if ($check == false)
        {
            echo "Ok not repeat\n";
        }
        else {
            echo "$check";
        }*/
        array_push($_SESSION["questionList"],  $_SESSION["question_id"]);

        // close socket
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
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
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