<!DOCTYPE html>
<html lang="en">

<style>
    @import url('https://fonts.googleapis.com/css2?family=Montserrat&display=swap');
    .question_form {
        background-color: white;
        height: 80px;
        font-size:30px;
        border: 4px solid #0c335a;
        margin-left:100px;
        margin-right:100px;
        margin-top:50px;
        padding: 8px 20px;
        border-radius: 10px;
    }
    .answer_right{
        float: right;
    }

    .answer_left {
        float: left;
    }
    
    .button_answer {
        background-color: #ffffff;
        color:black;
        padding: 8px 20px;
        border: 1px solid #0c335a;
        transition: all 0.3s ease-out;
        border-radius: 10px;
        margin-bottom: 15px;
        padding: 8px 10px;
        font-size: 20px;
        font-family: Arial, sans-serif;
        width: 400px;
        height: 60px;
        margin: 20px;

    }

    .button_answer:hover {
        background-color: #0c335a;
        color:white;
    }

    .button_answer:active {
        background-color: #0c335a;
        box-shadow: 0 5px #666;
         transform: translateY(4px);
    }

    .home_help {
        float: right;
        margin-right:200px;
    }
    
    .button_help {
        background-color: green;
        color:white;
        padding: 8px 20px;
        border: 1px solid green;
        transition: all 0.3s ease-out;
        border-radius: 5px;
        padding: 8px 10px;
        font-size: 20px;
        font-family: Arial, sans-serif;
        width: 100px;
        height: 60px;
        margin-left: 20px;

    }

    .button_help:hover {
        background-color: white;
        color:green;
        border: 1px solid green;
    }

    .index_image {
        margin-left:350px;
    }

    .button_stop {
        background-color: red;
        color:white;
        padding: 8px 20px;
        border: 1px solid red;
        transition: all 0.3s ease-out;
        border-radius: 5px;
        padding: 8px 10px;
        font-size: 20px;
        font-family: Arial, sans-serif;
        width: 100px;
        height: 60px;

    }

    .button_stop:hover {
        background-color: white;
        color:red;
        border: 1px solid red;
    }

</style>

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
        <div class="home_header">
            <div class="home_help btn-group">
            <form action = "score.php" method = "post">
                <input type="submit" class="button_stop" name ="stop" value="STOP" >
            </form>

            <form action = "help.php" method = "post">
                <input type="submit" class="button_help" name ="help" value="HELP <?php echo $_SESSION["help"]; ?>" >
            </form>
    </div>
        <div class="index_image">
            <img src="./prjltm.jpg" class="rounded mx-auto d-block " alt="index.php" >
        </div>
    </div>
<div class="question_form">
    <div class = " d-flex justify-content-center">
        <?php echo $_SESSION["question"];?>
    </div>
    </div>
    <div class="index_button_group d-flex justify-content-center"> 
    <div class="btn-group-vertical ">
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
    <div class="answer_right btn-group-vertical ">
        <input type="submit" class="button_answer" name ="answer" value="<?php echo $_SESSION["answerC"]; ?>" >
        <input type="submit" class="button_answer" name ="answer" value="<?php echo $_SESSION["answerD"]; ?>" >
    </div>
    <div class="answer_left btn-group-vertical ">
        <input type="submit" class="button_answer " name ="answer" value="<?php echo $_SESSION["answerA"]; ?>" >
        <input type="submit" class="button_answer " name ="answer" value="<?php echo $_SESSION["answerB"]; ?>" >
    </div>
        <input type="hidden" name ="questionid" value="<?php echo $question_id; ?>" >
        
    </form>
    
    </div>
    </div>

    <?php include('footer.php'); ?>
</body>

</html>