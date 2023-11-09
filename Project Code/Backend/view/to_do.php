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

    if (isset($_POST['submit'])) {   
        $name = $_POST['name'];
        $duedate = $_POST['duedate'];
        $person = $_POST['person'];
        $complete = $_POST['complete'];

        $stmt = $db->prepare("INSERT INTO Tasks (DueBy, Completed, Description) VALUES (:duedate, :complete, :name)");

        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':duedate', $duedate);
        $stmt->bindParam(':complete', $complete);

        $stmt->execute();

        $taskID = $db->lastInsertId();

        $stmt = $db->prepare("INSERT INTO Connections (PersonID, TaskID) VALUES (:person, :taskID)");

        $stmt->bindParam(':person', $person);
        $stmt->bindParam(':taskID', $taskID);

        $stmt->execute();

        echo "You added a task successfully";
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
            <div class="container">
                <h1>Team Tasks</h1>
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
            <div class="container">
            <h2 style= "Text-align: center">Add A New Task</h2></br>
                <form method="post">
                    <label for="name">Task Name:</label>
                    <input type="text" id="name" name="name" required></br></br>

                    <label for="duedate">Due Date:</label>
                    <input type="date" id="duedate" name="duedate" required></br></br>

                    <label for="person">Assigned Person:</label>
                    <select id="person" name="person" required>
                        <?php 
                        /*
                            $query = "SELECT TeamID, TeamName FROM Teams";
                            $stmt = $db->query($query);
                            $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
                            foreach ($data as $row) {
                                $sanitizedTeamName = htmlspecialchars($row['TeamName']);
                                echo "<option value='{$row['TeamID']}'>{$sanitizedTeamName}</option>";
                            }
                        */
                        ?> 
                    </select></br></br>

                    <label for="complete">Has this been completed?</label>
                    <select id="complete" name="complete" required>
                        <option value="1">Yes</option>
                        <option value="0">No</option>
                    </select></br></br>
                
                    <input type="submit" name="submit" value="Submit">
                </form> 
            </div>
        </div>
    </body>
</html>