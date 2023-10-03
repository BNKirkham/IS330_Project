USE todos;

/*Selecting data from one table*/
SELECT FirstName, LastName, Color FROM People;

/*Selecting data from two or more tables using an JOIN condition*/
SELECT FirstName, LastName, TeamName, Color 
FROM People
    INNER JOIN TeamConnections
        ON People.PersonID = TeamConnections.EntryID
    INNER JOIN Teams
        ON TeamConnections.EntryID = Teams.TeamID;

/*Inserting a row into a table using INSERT*/
INSERT INTO People (FirstName, LastName, Color, Username, PasswordHash)
VALUES ('Geoffrey', 'Kirkham', 'Blue', 'GKirkham', 'abc123');

/*Updating a row using UPDATE*/
UPDATE Connections
SET PersonID = 2
WHERE TagID = 5;

/*Deleting a row using DELETE*/
DELETE FROM Teams
WHERE TeamID = 0;
