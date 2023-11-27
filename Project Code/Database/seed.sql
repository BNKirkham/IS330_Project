USE todos;

INSERT INTO Teams (TeamName, Description)
VALUES ('Kirkham 3.0', 'Family'),
	   ('Kirkham 2.0', 'Family');

INSERT INTO People (FirstName, LastName, Color, Username, PasswordHash, Administrator)
VALUES ('Brittany', 'Kirkham', 'Green', 'BKirkham', '$2y$10$ufyXaFan.Q50je6dQSATc.S6/naHM7jlwaMWyzdo9FCxd143iIzxW', '1'),
	   ('Geoffrey', 'Kirkham', 'Blue', 'GKirkham', '$2y$10$ufyXaFan.Q50je6dQSATc.S6/naHM7jlwaMWyzdo9FCxd143iIzxW', '0'),
	   ('Lily','Kirkham', 'Pink', 'null', 'null', '0'),
       ('Laura', 'Kirkham', 'Orange', 'LKirkham', '$2y$10$ufyXaFan.Q50je6dQSATc.S6/naHM7jlwaMWyzdo9FCxd143iIzxW', '0'),
       ('Mike', 'Kirkham', 'Blue', 'MKirkham', '$2y$10$ufyXaFan.Q50je6dQSATc.S6/naHM7jlwaMWyzdo9FCxd143iIzxW', '0'),
       ('Addie','Kirkham', 'Pink', 'null', 'null', '0'),
       ('Nick','Kirkham', 'Red', 'null', 'null', '0');

INSERT INTO TeamConnections (TeamID, PersonID)
VALUES (1, 1),
	   (1, 2),
       (1, 3),
       (2, 4),
       (2, 5),
       (2, 6),
       (2, 7);

INSERT INTO Tasks (DueBy, Completed, Description)
VALUES ('2023-9-30', '0', 'Couch warranty');

INSERT INTO Meetings (Date, Time, Description)
VALUES ('2023-9-23', '15:00:00', 'Karate Orientation');

INSERT INTO Events (Weekday, TimeStart, TimeEnd, StartDate, EndDate, Description)
VALUES ('M,T,Th,F', '09:05:00', '15:40:00', '2023-9-8', '2023-10-20', 'School'),
	   ('W', '09:50:00', '15:40:00', '2023-9-13', '2023-10-18', 'School'),
	   ('M,T,W,Th', '13:00:00', '13:50:00', '2023-9-18', '2023-11-16', 'IS 330');

INSERT INTO Connections (PersonID, TaskID, MeetingID, EventID)
VALUES (1, 1, null, null),
	   (1, null, null, 3),
	   (2, null, 1, null),
	   (3, null, null, 1),
	   (3, null, null, 2);

SELECT * FROM Meetings;