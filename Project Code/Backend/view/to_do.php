<?php
    require_once('util/secure_conn.php');  // require a secure connection
    require_once('util/valid_admin.php');  // require a valid admin user

    if(isset($_SESSION['current_user_team_id'])) {
        $teamID = $_SESSION['current_user_team_id']; 
        $query = "SELECT PersonID FROM TeamConnections WHERE TeamID = $teamID";
        $stmt = $db->query($query);
        $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $tasks = [];
        foreach ($data as $row) {
            $stmt2 = $db->query("SELECT DueBy, Completed, Description FROM Tasks JOIN Connections ON Tasks.TaskID = Connections.TaskID WHERE Connections.PersonID =" . $row['PersonID']);
            $tasks = array_merge($tasks, $stmt2->fetchAll(PDO::FETCH_ASSOC));
        }
    } else {
        throw new Exception('Should not be able to get here if not logged in');
    }
?>
<!DOCTYPE html>
<html>
    <head>
        <title>To Do List</title>
        <link rel="stylesheet" type="text/css" href="main.css"/>
    </head>
    <body>
        <?php
            include("util/nav_menu.php")
        ?>
        <header>
            <h1>What I have To Do:</h1>
        </header>
        <div class="container">
            <h2>Team Tasks</h2>
            <table>
                <tr>
                    <th>Due By:</th>
                    <th>Task Description:</th>
                    <th>Task Completed:</th>
                </tr>
                <?php foreach ($tasks as $task): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($task['DueBy']); ?></td>
                        <td><?php echo htmlspecialchars($task['Description']); ?></td>
                        <td><?php echo htmlspecialchars($task['Completed']?"True":"False"); ?></td>
                    </tr>
                <?php endforeach; ?>
            </table>
        </div>
    </body>
</html>