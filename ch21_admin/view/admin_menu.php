<?php
    require_once('util/secure_conn.php');  // require a secure connection
    require_once('util/valid_admin.php');  // require a valid admin user

    $teamName = $_SESSION['current_user_team_name']; 

    // Check if form was submitted
    if (isset($_POST['submit'])) {
        $firstname = $_POST['firstname'];
        $lastname = $_POST['lastname'];
        $color = $_POST['color'];
        $teamID = $_SESSION['current_user_team_id']; 

        $stmt = $db->prepare("INSERT INTO People (FirstName, LastName, Color) VALUES (:firstname, :lastname, :color)");

        $stmt->bindParam(':firstname', $firstname);
        $stmt->bindParam(':lastname', $lastname);
        $stmt->bindParam(':color', $color);

        $stmt->execute();

        //pull PersonID of added user
        $personID = $db->lastInsertId();

        //insert $team into TeamConnections table with PersonID
        $stmt = $db->prepare("INSERT INTO TeamConnections (TeamID, PersonID) VALUES (:teamID, :personID)");
        $stmt->bindParam(':teamID', $teamID);
        $stmt->bindParam(':personID', $personID);

        $stmt->execute();

        echo "You added a team member successfully";
    }

    if(isset($_SESSION['current_user_team_id'])) {
      $teamID = $_SESSION['current_user_team_id']; 

      $stmt = $db->query("SELECT FirstName, LastName, Color FROM People JOIN TeamConnections ON People.PersonID = TeamConnections.PersonID WHERE TeamConnections.TeamID = $teamID");
    } else {
        throw new Exception('Should not be able to get here if not logged in');
    }

?>

<!DOCTYPE html>
<html>
    <head>
        <title>Our Team</title>
        <link rel="stylesheet" type="text/css" href="main.css"/>
    </head>
    <body>
        <?php
            include("util/nav_menu.php")
        ?>
        <header>
            <h1>Team <?php echo "$teamName";?></h1>
        </header>
        </br>
        <div class="container">
            <h2>Team Members</h2>
            <table>
                <tr>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Assigned Color</th>
                </tr>
                <?php while ($row = $stmt->fetch()): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row['FirstName']); ?></td>
                        <td><?php echo htmlspecialchars($row['LastName']); ?></td>
                        <td><?php echo htmlspecialchars($row['Color']); ?></td>
                    </tr>
                <?php endwhile; ?>
            </table>
            <div class="container">
                <h1>Add A New Member</h2>
                <form method="post">
                    <label for="firstname">First Name:</label>
                    <input type="text" id="firstname" name="firstname" required></br>

                    <label for="lastname">Last Name:</label>
                    <input type="text" id="lastname" name="lastname" required></br>

                    <label for="color">Assigned Color:</label>
                    <select id="color" name="color" required>
                        <option style="color:Blue" value="Blue">Blue</option>
                        <option style="color:Red" value="Red">Red</option>
                        <option style="color:Yellow" value="Yellow">Yellow</option>
                        <option style="color:Orange" value="Orange">Orange</option>
                        <option style="color:Pink" value="Pink">Pink</option>
                        <option style="color:Purple" value="Purple">Purple</option>
                        <option style="color:Lime" value="Lime">Lime</option>
                        <option style="color:Gray" value="Gray">Gray</option>
                        <option style="color:Maroon" value="Maroon">Maroon</option>
                        <option style="color:Navy" value="Navy">Navy</option>
                        <option style="color:Olive" value="Olive">Olive</option>
                    </select></br>
            
                    <input type="submit" name="submit" value="Submit">
                </form>
            </div> 
        </div>
    </body>
</html>