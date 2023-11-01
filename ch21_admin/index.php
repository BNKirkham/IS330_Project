<?php

/*

We want ch21_admin to work, but we ran into issues:

1) Problem: Access denied for user 'mgs_user'@'localhost' (using password: YES)
      - Database is not set up
   Solution: Run the SQL code that sets up the DB

2) Problem: Redirecting to HTTPs (via the file util/secure_conn.php)
   Solution: Comment out the redirection code

2.5) Problem: Notice: Trying to access array offset on value of type bool in C:\xampp\htdocs\book_apps\ch21_admin\model\admin_db.php on line 23

3) Problem: Can't log in, don't know password
   Solution: 

*/



// Start session management and include necessary functions
session_start();
require_once('model/database.php');
require_once('model/admin_db.php');

// Get the action to perform
$action = filter_input(INPUT_POST, 'action');

if ($action == NULL) {
    $action = filter_input(INPUT_GET, 'action');
    if ($action == NULL) {
        $action = 'show_admin_menu';
    }
}

// If the user isn't logged in, force the user to login
if (!isset($_SESSION['is_valid_admin'])) {
    $action = 'login';
}

// Perform the specified action
switch($action) {
    case 'login':
        $username = filter_input(INPUT_POST, 'username');
        $password = filter_input(INPUT_POST, 'password');
        if (is_valid_admin_login($username, $password)) {
            $_SESSION['is_valid_admin'] = true;
            $_SESSION['currently_logged_in_user_username'] = $username;

            //Pull People and TeamConnections tables from DB using username
            $stmt = $db->prepare("SELECT * FROM People JOIN TeamConnections ON People.PersonID = TeamConnections.PersonID WHERE Username = :username"); 
            $stmt->bindParam(":username", $username);
            $stmt->execute();
            //Store userID, admin, and teamID in SESSION
            $row = $stmt->fetch();
            $user_id = $row["PersonID"];
            $_SESSION['currently_logged_in_user_id'] = $user_id;
            $admin = $row["Administrator"];
            $_SESSION['current_user_admin'] = $admin;
            $teamID = $row["TeamID"];
            $_SESSION['current_user_team_id'] = $teamID;
            //Pull teamName from DB using teamID
            $stmt = $db->prepare("SELECT * FROM Teams WHERE TeamID = :teamID");
            $stmt->bindParam(':teamID', $teamID);
            $stmt->execute();
            //Store teamName in SESSION
            $row = $stmt->fetch();
            $teamName = $row["TeamName"];
            $_SESSION['current_user_team_name'] = $teamName;


            include('view/admin_menu.php');
        } else {
            $login_message = 'You must login to view this page.';
            include('view/login.php');
        }
        break;
    case 'show_admin_menu':
        include('view/admin_menu.php');
        break; 
    case 'show_to_do':
        include("view/to_do.php");
        break;
    case 'show_calendar':
        include('view/calendar.php');
        break;
    case 'logout':
        $_SESSION = array();   // Clear all session data from memory
        session_destroy();     // Clean up the session ID
        $login_message = 'You have been logged out.';
        include('view/login.php');
        break;
    case 'show_admin_page':
        include('view/admin_page.php');
        break;
}
?>