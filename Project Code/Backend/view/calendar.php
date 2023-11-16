<?php
    require_once('util/secure_conn.php');  // require a secure connection
    require_once('util/valid_admin.php');  // require a valid admin user
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Calendar</title>
        <link rel="stylesheet" type="text/css" href="main.css"/>
    </head>
    <body>
        <?php
            include("util/nav_menu.php")
        ?>
        <header>
            <h1>Monthly Calendar:</h1>
        </header>
        Calendar goes here....

        *Stretch Goal*
    </body>
</html>
