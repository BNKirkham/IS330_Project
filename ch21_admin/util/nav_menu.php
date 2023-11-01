<?php
    $admin = $_SESSION['current_user_admin']; 
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

    <div id="menu"></div>
    <script>
        var admin = $admin; // Set your boolean value here

        if (admin) {
            var link = document.createElement("a");
            link.href = "index.php?action=show_admin_page";
            link.textContent = "Admin Only";

            var menuDiv = document.getElementById("menu");
            menuDiv.appendChild(link);
        }
    </script>
</header>