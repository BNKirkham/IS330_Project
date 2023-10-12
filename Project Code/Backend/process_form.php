<?php
// Check if the form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve data from the form
    $FirstName = $_POST["FirstName"];
    $LastName = $_POST["LastName"];
    $Username = $_POST["Username"];
    $PasswordHash = $_POST["PasswordHash"];
//  $PasswordHash = PasswordHash($_POST["PasswordHash"], PASSWORD_DEFAULT); 
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

    if ($db->query($sql) != FALSE) {
        echo "Data inserted successfully!";
    } else {
        echo "An error has occurred";
    }

} else {
    echo "Form not submitted.";
}
?>

<script>
        // Use JavaScript to delay and redirection
    setTimeout(function() {
        window.location.href = 'index.php';
    }, 5000); 
</script>