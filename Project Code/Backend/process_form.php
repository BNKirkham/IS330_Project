<?php
// Check if the form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve data from the form
    $FirstName = $_POST["FirstName"];
    $LastName = $_POST["LastName"];
    $Username = $_POST["Username"];
    $PasswordHash = $_POST["PasswordHash"];
    $Color = $_POST["Color"];

    // Perform data validation here (e.g., length checks, input sanitization)

    // Connect to your database (replace with your database credentials)
    $dsn = 'mysql:host=localhost;dbname=todos';
    $username = 'root';
    $password = '';

    try {
        $db = new PDO($dsn, $username, $password);
    } catch (PDOException $e) {
        echo "There was an error";
        exit();
    }

    // SQL query to insert data into the database
    $sql = "INSERT INTO People (FirstName, LastName, Color, Username, PasswordHash)
    VALUES ('$FirstName', '$LastName', '$Color', '$Username', '$PasswordHash')";

    if ($db->query($sql) === TRUE) {
        echo "Data inserted successfully!";
    } else {
        echo "An error has occurred";
    }

    // Close the database connection
   // $db->close();
} else {
    echo "Form not submitted.";
}
?>