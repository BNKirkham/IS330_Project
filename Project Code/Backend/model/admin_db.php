<?php
function add_admin($username, $password) {
    global $db;
    $hash = password_hash($password, PASSWORD_DEFAULT);
    $query = 'INSERT INTO People (UserName, PasswordHash)
              VALUES (:username, :password)';
    $statement = $db->prepare($query);
    $statement->bindValue(':username', $username);
    $statement->bindValue(':password', $hash);
    $statement->execute();
    $statement->closeCursor();
}

function is_valid_admin_login($username, $password) {
    global $db;

    $query = 'SELECT PasswordHash FROM People
              WHERE UserName = :username';
    $statement = $db->prepare($query);
    $statement->bindValue(':username', $username);
    $statement->execute();
    $row = $statement->fetch();
    $statement->closeCursor();

    if($row === False)
    {
        return False;
    }
    $hash = $row['PasswordHash'];
    return password_verify($password, $hash);
}
?>