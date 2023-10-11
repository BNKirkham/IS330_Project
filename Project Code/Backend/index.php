Hello, <br><br>

<?php
    $dsn = 'mysql:host=localhost;dbname=todos';
    $username = 'root';
    $password = '';

    try {
        $db = new PDO($dsn, $username, $password);
    } catch (PDOException $e) {
        echo "There was an error";
        exit();
    }

    // Prepare the SQL statement for execution

    $stmt = $db->prepare("SELECT * FROM People");

    // Execute the prepared statement

    $stmt->execute();

    // Fetch all of the remaining rows in the result set and display them

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        echo "<span style='color: 'black''>Name & Color: </span>
            <span style='color: ".$row['Color']."'>" . $row['FirstName'] . " " . $row['LastName'] . "</span><br>";
    }
    ?>

    <h1>Add Data to Database</h1>
    <form action="process_form.php" method="post">
        <label for="FirstName">First Name:</label>
        <input type="text" name="FirstName" id="FirstName" required><br><br>

        <label for="LastName">Last Name:</label>
        <input type="text" name="LastName" id="LastName" required><br><br>

        <label for="Username">Username:</label>
        <input type="text" name="Username" id="Username" required><br><br>

        <label for="PasswordHash">Password:</label>
        <input type="password" name="PasswordHash" id="PasswordHash" required><br><br>

        <label for="Color">Favorite Color:</label>
        <input type="text" name="Color" id="Color"><br><br>

        <input type="submit" value="Submit">
    </form>


<br>It Worked!!!