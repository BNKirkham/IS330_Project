<?php
    require_once('util/secure_conn.php');  // require a secure connection
    require_once('util/valid_admin.php');  // require a valid admin user

    if (isset($_POST['submit'])) {   
        $name = $_POST['name'];
        $days = $_POST['days'];
        $timestart = $_POST['timestart'];
        $timeend = $_POST['timeend'];
        $startdate = $_POST['startdate'];
        $enddate = $_POST['enddate'];
        $person = $_POST['person'];

        $stmt = $db->prepare("INSERT INTO Events (WeekDay, TimeStart, TimeEnd, StartDate, EndDate, Description) VALUES (:days, :timestart, :timeend, :startdate, :enddate, :name)");

        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':days', $days);
        $stmt->bindParam(':timestart', $timestart);
        $stmt->bindParam(':timeend', $timeend);
        $stmt->bindParam(':startdate', $startdate);
        $stmt->bindParam(':enddate', $enddate);

        $stmt->execute();

        $eventID = $db->lastInsertId();

        $stmt = $db->prepare("INSERT INTO Connections (PersonID, EventID) VALUES (:person, :eventID)");

        $stmt->bindParam(':person', $person);
        $stmt->bindParam(':eventID', $eventID);

        $stmt->execute();

        echo "You added an event successfully";
    }
    
    if(isset($_SESSION['current_user_team_id'])) {
        $teamID = $_SESSION['current_user_team_id']; 
        $query = "SELECT PersonID FROM TeamConnections WHERE TeamID = $teamID";
        $stmt = $db->query($query);
        $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $tasks = [];
        foreach ($data as $row) {
            $stmt2 = $db->query("SELECT WeekDay, DATE_FORMAT(TimeStart, '%h:%i %p') AS formatted_starttime, DATE_FORMAT(TimeEnd, '%h:%i %p') AS formatted_endtime, DATE_FORMAT(StartDate, '%m/%d') AS formatted_startdate, DATE_FORMAT(EndDate, '%m/%d') AS formatted_enddate, Description, FirstName, Color FROM Events JOIN Connections ON Events.EventID = Connections.EventID JOIN People ON Connections.PersonID = People.PersonID  WHERE Connections.PersonID =" . $row['PersonID']." ORDER BY WeekDay");
            $tasks = array_merge($tasks, $stmt2->fetchAll(PDO::FETCH_ASSOC));
        }
    } else {
        throw new Exception('Should not be able to get here if not logged in');
    }
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Ongoing Events</title>
        <link rel="stylesheet" type="text/css" href="main.css"/>
    </head>
    <body>
        <?php
            include("util/nav_menu.php")
        ?>
        <header>
            <h1>Reoccurring Events</h1>
        </header>
        <div class="container">
            <div class="container">
                <h1>Events</h1>
                <table>
                    <tr>
                        <th> </th>
                        <th>Weekday(s)</th>
                        <th>Time</th>
                        <th>Event Description</th>
                        <th>Person Assigned</th>
                        <th>Start Date</th>
                        <th>End Date</th>
                    </tr>
                    <?php foreach ($tasks as $task): ?>
                        <tr>
                            <td>
                                <div class="color-box" style="background-color: <?php echo $task['Color']; ?>"></div>
                            </td>  
                            <td><?php echo htmlspecialchars($task['WeekDay']); ?></td>
                            <td><?php echo htmlspecialchars($task['formatted_starttime']) . "-" . htmlspecialchars($task['formatted_endtime']); ?></td>
                            <td><?php echo htmlspecialchars($task['Description']); ?></td>
                            <td><?php echo htmlspecialchars($task['FirstName']); ?></td>
                            <td><?php echo htmlspecialchars($task['formatted_startdate']); ?></td>
                            <td><?php echo htmlspecialchars($task['formatted_enddate']); ?></td>
                        </tr>
                    <?php endforeach; ?>
                </table>
            </div>
            <div class="container">
            <h2 style= "Text-align: center">Add A New Event</h2></br>
                <form method="post">
                    <label for="name">Event Name:</label>
                    <input type="text" id="name" name="name" required></br></br>

                    <label for="days">Assigned Days:</label>
                    <select id="days" name="days" required>
                        <option value="Su">Sunday</option>
                        <option value="M">Monday</option>
                        <option value="Tu">Tuesday</option>
                        <option value="W">Wednesday</option>
                        <option value="Th">Thursday</option>
                        <option value="F">Friday</option>
                        <option value="Sa">Saturday</option>
                        <option value="M,W">Mon & Wed</option>
                        <option value="Tu,Th">Tues & Thurs</option>
                        <option value="Sa,Su">Sat & Sun</option>
                        <option value="M,Tu,Th,F">Mon, Tues, Thurs, & Fri</option>
                        <option value="M,Tu,W,Th,F">Mon, Tues, Wed, Thurs, & Fri</option>
                    </select></br></br>

                    <label for="timestart">Time Start:</label>
                    <input type="time" id="timestart" name="timestart" required></br></br>

                    <label for="timeend">Time End:</label>
                    <input type="time" id="timeend" name="timeend" required></br></br>

                    <label for="startdate">Start Date:</label>
                    <input type="date" id="startdate" name="startdate" required></br></br>

                    <label for="enddate">End Date:</label>
                    <input type="date" id="enddate" name="enddate" required></br></br>

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