<?php
/**
 * Created by PhpStorm.
 * User: Nick
 * Date: 9/30/17
 * Time: 11:34 AM
 */
    require_once('db.php');
    require_once('libraries/utils.php');
    if(count($_GET)){
        $message = validInputSizeAlpha($_GET['message'], 500);
    }
?>
<!DOCTYPE HTML>
<html lang="en">
    <head>
        <title>Error</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
        <!--Stuff for selectors-->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.2/css/bootstrap-select.min.css">
        <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.2/js/bootstrap-select.min.js"></script>
        <script src="scripts/main.js"></script>
        <link rel="stylesheet" href="main.css">
    </head>
    <body>
        <?php echo badAlert($message, "col-xs-10 col-xs-offset-1");?>
        <form action="home.php" method="get">
            <input type="submit" value="Back" class="btn btn-primary col-xs-10 col-xs-offset-1">
        </form>
    </body>
</html>
