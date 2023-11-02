<?php
    $admin = $_SESSION['current_user_admin']; 
    if($admin == 1){
        echo "<div style='Text-align:center'>
        <a href='index.php?action=show_admin_page'>Admin Only</a>
        </div>";
    }
?>
<header>
    <link rel="stylesheet" type="text/css" href="main.css"/>
    <nav class="horizontal">
		<ul>
			<li><a href="index.php?action=show_admin_menu">Home</a></li>
			<li><a href="index.php?action=show_to_do">To Do List</a></li>
			<li><a href="index.php?action=show_calendar">Calendar</a></li>
			<li><a href="index.php?action=logout">Logout</a></li>
		</ul>
	</nav>
</header>