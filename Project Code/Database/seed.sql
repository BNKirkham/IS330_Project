USE todos;

INSERT INTO Person (FirstName, Color)
VALUES ('Brittany', 'Green'),
	   ('Lily', 'Pink');

INSERT INTO Task (PersonID, DueBy, Description)
VALUES (1, '2023-9-30', 'Couch warranty');

INSERT INTO Meeting (PersonID, Date, Description)
VALUES (2, '2023-9-23', 'Karate Orientation');

INSERT INTO Event (PersonID, Weekday, TimeStart, TimeEnd, StartDate, EndDate, Description)
VALUES (2,'M,T,Th,F', '9:05am', '3:40pm', '2023-9-8', '2023-10-20', 'School'),
	   (2,'W', '9:50am', '3:40pm', '2023-9-13', '2023-10-18', 'School'),
	   (1,'M,T,W,Th', '1:00pm', '1:50pm', '2023-9-18', '2023-11-16', 'IS 330');

SELECT * FROM Event;