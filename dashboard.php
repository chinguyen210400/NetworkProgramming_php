<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="./assets/css/index.css">
    <title>High Score</title>
    <?php
    
    if (isset($_POST['dashboard'])) {

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

            // send username, password to server
            $msg = "5" ;

            $ret = socket_write($socket, $msg, strlen($msg));
            if (!$ret) die("client write fail:" . socket_strerror(socket_last_error()) . "\n");

            // receive response from server
            $response = socket_read($socket, 1024);
            if (!$response) die("client read fail:" . socket_strerror(socket_last_error()) . "\n");
            //echo $response;

            // split response from server
            $response = explode("|", $response);
            if ($response[0] == "16") {
                echo "<script>alert('show dashboard success!');</script>";
                
            } else {
                echo "<script>alert('show dashboard fail!');</script>";
                echo "<script>window.location.href = 'home.php';</script>";

            $username_info=$response[1];
            $highscore = $response[2];

            // close socket
            socket_close($socket);
        }
    }

    ?>
</head>

<body>
    <?php include('home_navbar.php'); ?>
    <div class="home_container">
        <div class="index_image">
            <img src="./prjltm.jpg" class="rounded mx-auto d-block " alt="index.php" >
        </div>
    <div class = "table_score">
    <div class = "d-flex justify-content-center" >
    <table class="table">
  <thead>
    <tr>
      <th scope="col">Username</th>
      <th scope="col">Highscore</th>
    </tr>
  </thead>
  <div class="row align-items-start">
    <div class="col">
      <?php echo $username_info; ?>
    </div>
    <div class="col">
      <?php echo $highscore; ?>
    </div>
  </div>
</table>
</div>
</div>
</div>
<?php include('footer.php'); ?>
</body>

</html>
