<!DOCTYPE html>
<html lang="en">

<style>
    @import url('https://fonts.googleapis.com/css2?family=Montserrat&display=swap');
    
    .button_index{
        background-color: #0c335a;
        color:rgb(255, 255, 255);
        padding: 8px 20px;
        border: 1px solid #ffffff;
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

    .button_index:hover {
        background-color:#1961aa;
    }

</style>

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css" integrity="sha384-B4dIYHKNBt8Bc12p+WXckhzcICo0wtJAoU8YZTY5qE0Id1GSseTk6S+L3BlXeVIU" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="./assets/css/index.css">
    <title>Home Page</title>
    <?php 
        session_start();
        $_SESSION["position"] = 0;
        $_SESSION["help"] = 3;
        $_SESSION["questionList"] = array();
?>
</header>

<body>
    <?php include('home_navbar.php'); ?>
    <div class="home_container">
        <div class="index_image">
    <img src="./prjltm.jpg" class="rounded mx-auto d-block " alt="index.php" >
</div>
    
    <div class="index_button_group d-flex justify-content-center"> 
    <div class="btn-group-vertical ">
    <form action="playgame.php" method="post">
        <input type="submit" class="button_index" name ="playgame" value="PLAY GAME" >
    </form>
    <form action="dashboard.php" method="post">
        <input type="submit" class="button_index" name ="dashboard" value="HIGH SCORE" >
    </form>
    <form action="logout.php" method="post">
        <input type="submit" class="button_index" name ="logout" value="LOG OUT" >
    </form>
    </div>
    </div>

    <?php include('footer.php'); ?>
</body>

</html>