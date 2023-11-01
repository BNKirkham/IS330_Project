CREATE DATABASE IF NOT EXISTS todos;
USE todos;

DROP TABLE IF EXISTS Connections;
DROP TABLE IF EXISTS Events;
DROP TABLE IF EXISTS Meetings;
DROP TABLE IF EXISTS Tasks;
DROP TABLE IF EXISTS TeamConnections;
DROP TABLE IF EXISTS People;
DROP TABLE IF EXISTS Teams;

CREATE TABLE Teams (
	TeamID INT PRIMARY KEY AUTO_INCREMENT,
	TeamName VARCHAR(55),
	Description VARCHAR(255)
);

CREATE TABLE People (
    PersonID INT PRIMARY KEY AUTO_INCREMENT,
    FirstName VARCHAR(55),
    LastName VARCHAR(55),
    Color VARCHAR(55),
    UserName VARCHAR(15),
    PasswordHash VARCHAR(255),
    Administrator BOOLEAN
);

CREATE TABLE TeamConnections (
	EntryID INT PRIMARY KEY AUTO_INCREMENT,
	TeamID INT,
	PersonID INT,
	FOREIGN KEY (TeamID) REFERENCES Teams(TeamID),
	FOREIGN KEY (PersonID) REFERENCES People(PersonID)
);

CREATE TABLE Tasks (
    TaskID INT PRIMARY KEY AUTO_INCREMENT,
    DueBy DATE,
    Completed BOOLEAN default false,
    Description TEXT
);

CREATE TABLE Meetings (
    MeetingID INT PRIMARY KEY AUTO_INCREMENT,
    Date DATETIME,
    Description TEXT
);

CREATE TABLE Events (
    EventID INT PRIMARY KEY AUTO_INCREMENT,
    WeekDay VARCHAR(55),
    TimeStart TIME,
    TimeEnd TIME,
    StartDate DATE,
    EndDate DATE,
    Description TEXT
);

CREATE TABLE Connections (
	TagID INT PRIMARY KEY AUTO_INCREMENT,
	PersonID INT,
	TaskID INT,
	MeetingID INT,
	EventID INT,
	FOREIGN KEY (PersonID) REFERENCES People(PersonID),
    FOREIGN KEY (TaskID) REFERENCES Tasks(TaskID),
    FOREIGN KEY (MeetingID) REFERENCES Meetings(MeetingID),
    FOREIGN KEY (EventID) REFERENCES Events(EventID)
);