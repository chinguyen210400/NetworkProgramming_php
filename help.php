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