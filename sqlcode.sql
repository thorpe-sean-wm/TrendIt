CREATE SCHEMA `trenditdb` ;

CREATE TABLE `trenditdb`.`users` (
  `userID` INT NOT NULL AUTO_INCREMENT,
  `username` VARCHAR(32) NULL,
  `password` VARCHAR(40) NULL,
  `email` VARCHAR(45) NULL,
  `joinDate` TIMESTAMP NULL,
  `firstName` VARCHAR(45) NULL,
  `lastName` VARCHAR(45) NULL,
  `birthday` DATETIME NULL,
  `gender` VARCHAR(6) NULL,
  `phoneNumber` INT(12) NULL,
  PRIMARY KEY (`userID`),
  UNIQUE INDEX `userID_UNIQUE` (`userID` ASC),
  UNIQUE INDEX `username_UNIQUE` (`username` ASC),
  UNIQUE INDEX `password_UNIQUE` (`password` ASC),
  UNIQUE INDEX `email_UNIQUE` (`email` ASC)
  );
CREATE TABLE `trenditdb`.`posts` (
  `postID` INT NOT NULL AUTO_INCREMENT,
  `userID` INT NULL,
  `post` VARCHAR(150) NULL,
  `postTime` TIMESTAMP NULL,
  PRIMARY KEY (`postID`),
  UNIQUE INDEX `postID_UNIQUE` (`postID` ASC)
  );
CREATE TABLE `trenditdb`.`followers` (
  `followID` INT NOT NULL AUTO_INCREMENT,
  `userID` INT NULL,
  `followingID` INT NULL,
  `followTime` TIMESTAMP NULL,
  PRIMARY KEY (`followID`),
  UNIQUE INDEX `followID_UNIQUE` (`followID` ASC),
  UNIQUE INDEX `userID_UNIQUE` (`userID` ASC),
  UNIQUE INDEX `followingID_UNIQUE` (`followingID` ASC)
  );
CREATE TABLE `trenditdb`.`likes` (
  `likeID` INT NOT NULL AUTO_INCREMENT,
  `postID` INT NULL,
  `userID` INT NULL,
  `likeTime` TIMESTAMP NULL,
  PRIMARY KEY (`likeID`),
  UNIQUE INDEX `likeID_UNIQUE` (`likeID` ASC)
  );
  CREATE TABLE `trenditdb`.`comments` (
  `commentID` INT NOT NULL AUTO_INCREMENT,
  `postID` INT NULL,
  `userID` INT NULL,
  `comment` VARCHAR(75) NULL,
  `commentTime` TIMESTAMP NULL,
  PRIMARY KEY (`commentID`),
  UNIQUE INDEX `commentID_UNIQUE` (`commentID` ASC)
  );
