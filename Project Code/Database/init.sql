CREATE DATABASE IF NOT EXISTS todos;
USE todos;

DROP TABLE IF EXISTS Events;
DROP TABLE IF EXISTS Meetings;
DROP TABLE IF EXISTS Tasks;
DROP TABLE IF EXISTS Connections;
DROP TABLE IF EXISTS People;
DROP TABLE IF EXISTS Groups;
DROP TABLE IF EXISTS GroupConnections;

CREATE TABLE Groups (
	GroupID INT PRIMARY KEY AUTO_INCREMENT,
	GroupName VARCHAR(55),
	Description VARCHAR(255)
);

CREATE TABLE GroupConnections (
	EntryID INT PRIMARY KEY AUTO_INCREMENT,
	GroupID INT,
	PersonID INT,
	FOREIGN KEY (GroupID) REFERENCES Groups(GroupID)
	FOREIGN KEY (PersonID) REFERENCES People(PersonID)
);

CREATE TABLE People (
    PersonID INT PRIMARY KEY AUTO_INCREMENT,
    FirstName VARCHAR(55),
    LastName VARCHAR(55),
    Color VARCHAR(55),
    UserName VARCHAR(15),
    PasswordHash VARCHAR(25)
);

CREATE TABLE Connections (
	TagID INT PRIMARY KEY AUTO_INCREMENT,
	PersonID INT,
	TaskID INT,
	MeetingID INT,
	EventID INT,
	FOREIGN KEY (PersonID) REFERENCES People(PersonID),
    FOREIGN KEY (TaskID) REFERENCES Tasks(TaskID),
    FOREIGN KEY (MeetingID) REFERENCES Meetings(MeetingsID),
    FOREIGN KEY (EventID) REFERENCES Events(EventID)
);

CREATE TABLE Tasks (
    TaskID INT PRIMARY KEY AUTO_INCREMENT,
    TagID INT,
    DueBy DATE,
    Completed BOOLEAN default false,
    Description TEXT,
    FOREIGN KEY (TagID) REFERENCES Connections(TagID)
);

CREATE TABLE Meetings (
    MeetingID INT PRIMARY KEY AUTO_INCREMENT,
    TagID INT,
    Date DATETIME,
    Description TEXT,
    FOREIGN KEY (TagID) REFERENCES Connections(TagID)
);

CREATE TABLE Events (
    EventID INT PRIMARY KEY AUTO_INCREMENT,
    TagID INT,
    WeekDay VARCHAR(55),
    TimeStart TIME,
    TimeEnd TIME,
    StartDate DATE,
    EndDate DATE,
    Description TEXT,
    FOREIGN KEY (TagID) REFERENCES Connections(TagID)
);

