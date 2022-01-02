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

            explode(".", $answer);
            // 
            $msg = "6|" . $question_id . "|" .  $answer[0] . "|";

            $ret = socket_write($socket, $msg, strlen($msg));
            if (!$ret) die("client write fail:" . socket_strerror(socket_last_error()) . "\n");

            // receive response from server
            $response = socket_read($socket, 1024);
            if (!$response) die("client read fail:" . socket_strerror(socket_last_error()) . "\n");
            echo $response;

            // split response from server
            $response = explode("|", $response);

            if ($response[0] == "13" ) {
                echo "<script>alert('$response[1]');</script>";
                //echo "<script>window.location.href = 'playgame.php';</script>";
            }elseif ($response[0] == "19" )  {
                echo "<script>alert('$response[1]');</script>";
                //echo "<script>window.location.href = 'home.php';</script>";
            }

            // close socket
            socket_close($socket);
        }
        

    ?>