<?php
    require_once('util/secure_conn.php'); 
    require_once('util/valid_admin.php');  

    if (isset($_POST['submit'])) {   //Submission of New Team Form
        $teamname = $_POST['teamname'];
        $detail = $_POST['detail'];

        $stmt = $db->prepare("INSERT INTO Teams (TeamName, Description) VALUES (:teamname, :detail)");

        $stmt->bindParam(':teamname', $teamname);
        $stmt->bindParam(':detail', $detail);

        $stmt->execute();

        echo "You added a team successfully";
    }
    if (isset($_POST['submit2'])) {  //Submission of New User Form
        $firstname = $_POST['firstname'];
        $lastname = $_POST['lastname'];
        $color = $_POST['color'];
        $username = $_POST['username'];
        $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
        $admin = $_POST['admin'];
        $teamID = $_POST['team'];

        $stmt = $db->prepare("INSERT INTO People (FirstName, LastName, Color, UserName, PasswordHash, Administrator) VALUES (:firstname, :lastname, :color, :username, :password, :admin)");

        $stmt->bindParam(':firstname', $firstname);
        $stmt->bindParam(':lastname', $lastname);
        $stmt->bindParam(':color', $color);
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':password', $password);        
        $stmt->bindParam(':admin', $admin);

        $stmt->execute();

        $personID = $db->lastInsertId();

        $stmt = $db->prepare("INSERT INTO TeamConnections (TeamID, PersonID) VALUES (:teamid, :personID)");
        $stmt->bindParam(':teamid', $teamID);
        $stmt->bindParam(':personID', $personID);

        $stmt->execute();

        echo "You added a user successfully";
    }
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Admin Page</title>
        <link rel="stylesheet" type="text/css" href="main.css"/>
    </head>
    <body>
        <?php
            include("util/nav_menu.php")
        ?>
        <header>
            <h1>Add Users and Teams</h1>
        </header>
        <div class="container">
            <div class="container">
                <h1>Create a New Team</h2>
                <form method="post">
                    <label for="teamname">Team Name:</label>
                    <input type="text" id="teamname" name="teamname" required></br>

                    <label for="detail">Team Type:</label>
                    <select id="detail" name="detail" required>
                        <option value="Family">Family</option>
                        <option value="Class">School Class</option>
                        <option value="Workgroup">Work Group</option>
                        <option value="Other">Other</option>
                    </select></br>
                
                    <input type="submit" name="submit" value="Submit">
                </form> 
            </div> 
            <div class="container">
                <h1>Add A New User</h2>
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

                    <label for="username">User Name:</label>
                    <input type="text" id="username" name="username" required></br>

                    <label for="password">Password:</label>
                    <input type="password" id="password" name="password" required></br>

                    <label for="admin">Are they an admin?</label>
                    <select id="admin" name="admin" required>
                        <option value="1">Yes</option>
                        <option value="0">No</option>
                    </select></br>

                    <label for="team">Assigned Team:</label>
                    <select id="team" name="team" required>
                        <?php 
                            $query = "SELECT TeamID, TeamName FROM Teams";
                            $stmt = $db->query($query);
                            $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
                            foreach ($data as $row) {
                                echo "<option value='{$row['TeamID']}'>{$row['TeamName']}</option>";
                            }
                        ?>
                    </select></br>
                
                    <input type="submit" name="submit2" value="Submit">
                </form> 
            </div> 
        </div> 
    </body>
</html>