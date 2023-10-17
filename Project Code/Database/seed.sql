USE todos;

INSERT INTO Teams (TeamName, Description)
VALUES ('Kirkham', 'Family'),
	   ('Smith', 'Family');

INSERT INTO People (FirstName, LastName, Color, Username, PasswordHash)
VALUES ('Brittany', 'Kirkham', 'Green', 'BKirkham', '123'),
	   ('Geoffrey', 'Kirkham', 'Blue', 'GKirkham', 'abc123'),
	   ('Lily','Kirkham', 'Pink', 'LKirkham', 'ABC');

INSERT INTO TeamConnections (TeamID, PersonID)
VALUES (1, 1),
	   (1, 2);

INSERT INTO Tasks (DueBy, Completed, Description)
VALUES ('2023-9-30', false, 'Couch warranty');

INSERT INTO Meetings (Date, Description)
VALUES ('2023-9-23', 'Karate Orientation');

INSERT INTO Events (Weekday, TimeStart, TimeEnd, StartDate, EndDate, Description)
VALUES ('M,T,Th,F', '9:05am', '3:40pm', '2023-9-8', '2023-10-20', 'School'),
	   ('W', '9:50am', '3:40pm', '2023-9-13', '2023-10-18', 'School'),
	   ('M,T,W,Th', '1:00pm', '1:50pm', '2023-9-18', '2023-11-16', 'IS 330');

INSERT INTO Connections (PersonID, TaskID, MeetingID, EventID)
VALUES (1, 1, null, null),
	   (1, null, null, 3),
	   (2, null, 1, null),
	   (2, null, null, 1),
	   (1, null, null, 2);

SELECT * FROM People;