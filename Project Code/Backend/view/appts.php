<?php
    require_once('util/secure_conn.php');  // require a secure connection
    require_once('util/valid_admin.php');  // require a valid admin user

    if (isset($_POST['submit'])) {   
        $name = $_POST['name'];
        $date = $_POST['date'];
        $time = $_POST['time'];
        $person = $_POST['person'];

        $stmt = $db->prepare("INSERT INTO Meetings (Date, Time, Description) VALUES (:date, :time, :name)");

        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':date', $date); 
        $stmt->bindParam(':time', $time);

        $stmt->execute();

        $meetingID = $db->lastInsertId();

        $stmt = $db->prepare("INSERT INTO Connections (PersonID, MeetingID) VALUES (:person, :meetingID)");

        $stmt->bindParam(':person', $person);
        $stmt->bindParam(':meetingID', $meetingID);

        $stmt->execute();

        echo "You added an appointment successfully";
    }
    
    if(isset($_SESSION['current_user_team_id'])) {
        $teamID = $_SESSION['current_user_team_id']; 
        $query = "SELECT PersonID FROM TeamConnections WHERE TeamID = $teamID";
        $stmt = $db->query($query);
        $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $tasks = [];
        foreach ($data as $row) {
            $stmt2 = $db->query("SELECT DATE_FORMAT(Date, '%m/%d') AS formatted_date, DATE_FORMAT(Time, '%h:%i %p') AS formatted_time, Description, FirstName, Color FROM Meetings JOIN Connections ON Meetings.MeetingID = Connections.MeetingID JOIN People ON Connections.PersonID = People.PersonID WHERE Connections.PersonID =" . $row['PersonID']." ORDER BY Date" );
            $tasks = array_merge($tasks, $stmt2->fetchAll(PDO::FETCH_ASSOC));
        }
    } else {
        throw new Exception('Should not be able to get here if not logged in');
    }
?>
<!DOCTYPE html>
<html>
    <head>
        <title>One-Time Appointments</title>
        <link rel="stylesheet" type="text/css" href="main.css"/>
    </head>
    <body>
        <?php
            include("util/nav_menu.php")
        ?>
        <header>
            <h1>One-Time Appointments:</h1>
        </header>
        <div class="container">
            <div class="container">
                <h1>Team Appointments</h1>
                <table>
                    <tr>
                        <th> </th>
                        <th>Date:</th>
                        <th>Time:</th>
                        <th>Appt Description:</th>
                        <th>Team Member:</th>
                    </tr>
                    <?php foreach ($tasks as $task): ?>
                        <tr>
                            <td>
                                <div class="color-box" style="background-color: <?php echo $task['Color']; ?>"></div>
                            </td>   
                            <td><?php echo htmlspecialchars($task['formatted_date']); ?></td>
                            <td><?php echo htmlspecialchars($task['formatted_time']); ?></td>
                            <td><?php echo htmlspecialchars($task['Description']); ?></td>
                            <td><?php echo htmlspecialchars($task['FirstName']); ?></td>
                        </tr>
                    <?php endforeach; ?>
                </table>
            </div>
            <div class="container">
            <h2 style= "Text-align: center">Add A New Appointmemt</h2></br>
                <form method="post">
                    <label for="name">Appt Description:</label>
                    <input type="text" id="name" name="name" required></br></br>

                    <label for="date">Date:</label>
                    <input type="date" id="date" name="date" required></br></br>
                    
                    <label for="time">Time:</label>
                    <input type="time" id="time" name="time" required></br></br>

                    <label for="person">Assigned Person:</label>
                    <select id="person" name="person" required>
                        <?php 
                            $teamID = $_SESSION['current_user_team_id']; 
                            $stmt = $db->prepare("SELECT People.PersonID, FirstName, Color FROM People JOIN TeamConnections ON People.PersonID = TeamConnections.PersonID WHERE TeamConnections.TeamID = :teamID");
                            $stmt->bindParam(':teamID', $teamID);
                            $stmt->execute();
                            $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
                            foreach ($data as $row) {
                                $sanitizedFirstName = htmlspecialchars($row['FirstName']);
                                echo "<option style='color:{$row['Color']}' value='{$row['PersonID']}'>{$sanitizedFirstName}</option>";
                            } 
                        ?> 
                    </select></br></br>
                
                    <input type="submit" name="submit" value="Submit"></br>
                </form> 
            </div>
        </div>
    </body>
</html>