CREATE DATABASE IF NOT EXISTS todos;
USE todos;

DROP TABLE IF EXISTS Event;
DROP TABLE IF EXISTS Meeting;
DROP TABLE IF EXISTS Task;
DROP TABLE IF EXISTS Person;

CREATE TABLE Person (
    PersonID INT PRIMARY KEY AUTO_INCREMENT,
    FirstName VARCHAR(55),
    LastName VARCHAR(55),
    Color VARCHAR(55),
    UserName VARCHAR(15),
    Password VARCHAR(25)
);

CREATE TABLE Task (
    TaskID INT PRIMARY KEY AUTO_INCREMENT,
    PersonID INT,
    DueBy DATE,
    Completed BOOLEAN default false,
    Description TEXT,
    FOREIGN KEY (PersonID) REFERENCES Person(PersonID)
);

CREATE TABLE Meeting (
    MeetingID INT PRIMARY KEY AUTO_INCREMENT,
    PersonID INT,
    Date DATETIME,
    Description TEXT,
	FOREIGN KEY (PersonID) REFERENCES Person(PersonID)
);

CREATE TABLE Event (
    EventID INT PRIMARY KEY AUTO_INCREMENT,
    PersonID INT,
    WeekDay VARCHAR(55),
    TimeStart TIME,
    TimeEnd TIME,
    StartDate DATE,
    EndDate DATE,
    Description TEXT,
	FOREIGN KEY (PersonID) REFERENCES Person(PersonID)
);

