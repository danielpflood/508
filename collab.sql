SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES';

CREATE SCHEMA IF NOT EXISTS `508devDB` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci ;
USE `508devDB` ;

-- -----------------------------------------------------
-- Table `508devDB`.`User`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `508devDB`.`User` ;

CREATE  TABLE IF NOT EXISTS `508devDB`.`User` (
  `userID` INT NOT NULL AUTO_INCREMENT ,
  `dateRegistered` DATETIME NOT NULL ,
  `lastLoggedIn` DATETIME NULL ,
  `lastLoggedOut` DATETIME NULL ,
  `firstName` VARCHAR(35) NULL ,
  `lastName` VARCHAR(35) NULL ,
  `email` VARCHAR(255) NOT NULL ,
  `password` VARCHAR(100) NOT NULL ,
  `ip` VARCHAR(40) NULL ,
  PRIMARY KEY (`userID`) ,
  UNIQUE INDEX `email_UNIQUE` (`email` ASC) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `508devDB`.`Project`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `508devDB`.`Project` ;

CREATE  TABLE IF NOT EXISTS `508devDB`.`Project` (
  `projectID` INT NOT NULL AUTO_INCREMENT ,
  `name` VARCHAR(100) NOT NULL ,
  `dateCreated` DATETIME NOT NULL ,
  `type` VARCHAR(3) NOT NULL DEFAULT 'NA' ,
  PRIMARY KEY (`projectID`) ,
  UNIQUE INDEX `name_UNIQUE` (`name` ASC) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `508devDB`.`Version`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `508devDB`.`Version` ;

CREATE  TABLE IF NOT EXISTS `508devDB`.`Version` (
  `versionID` INT NOT NULL AUTO_INCREMENT ,
  `versionNumber` INT NOT NULL ,
  `projectID` INT NOT NULL ,
  `createdBy` INT NOT NULL ,
  `dateCreated` DATETIME NOT NULL ,
  `changes` VARCHAR(200) NULL DEFAULT 'not specified' ,
  PRIMARY KEY (`versionID`) ,
  INDEX `projectID_idx` (`projectID` ASC) ,
  INDEX `userID_idx` (`createdBy` ASC) ,
  CONSTRAINT `projectIDfk`
    FOREIGN KEY (`projectID` )
    REFERENCES `508devDB`.`Project` (`projectID` )
    ON DELETE CASCADE
    ON UPDATE NO ACTION,
  CONSTRAINT `userIDfk`
    FOREIGN KEY (`createdBy` )
    REFERENCES `508devDB`.`User` (`userID` )
    ON DELETE CASCADE
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `508devDB`.`Message`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `508devDB`.`Message` ;

CREATE  TABLE IF NOT EXISTS `508devDB`.`Message` (
  `messageID` INT NOT NULL AUTO_INCREMENT ,
  `fromID` INT NOT NULL ,
  `toID` INT NOT NULL ,
  `message` VARCHAR(2056) NOT NULL ,
  `dateSent` DATETIME NOT NULL ,
  `dateRead` DATETIME NULL ,
  INDEX `sentID_idx` (`fromID` ASC) ,
  INDEX `recvID_idx` (`toID` ASC) ,
  PRIMARY KEY (`messageID`) ,
  CONSTRAINT `fromIDfk`
    FOREIGN KEY (`fromID` )
    REFERENCES `508devDB`.`User` (`userID` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `toIDfk`
    FOREIGN KEY (`toID` )
    REFERENCES `508devDB`.`User` (`userID` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `508devDB`.`File`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `508devDB`.`File` ;

CREATE  TABLE IF NOT EXISTS `508devDB`.`File` (
  `fileID` INT NOT NULL AUTO_INCREMENT ,
  `filePath` VARCHAR(200) NOT NULL ,
  `uploadDate` DATETIME NOT NULL ,
  `format` VARCHAR(10) NULL ,
  `size` INT NULL ,
  `fileName` VARCHAR(75) NULL ,
  PRIMARY KEY (`fileID`) ,
  UNIQUE INDEX `filePath_UNIQUE` (`filePath` ASC) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `508devDB`.`VersionHasFile`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `508devDB`.`VersionHasFile` ;

CREATE  TABLE IF NOT EXISTS `508devDB`.`VersionHasFile` (
  `versionID` INT NOT NULL ,
  `fileID` INT NOT NULL ,
  INDEX `versionID_idx` (`versionID` ASC) ,
  INDEX `fileID_idx` (`fileID` ASC) ,
  PRIMARY KEY (`versionID`, `fileID`) ,
  CONSTRAINT `versionIDfk`
    FOREIGN KEY (`versionID` )
    REFERENCES `508devDB`.`Version` (`versionID` )
    ON DELETE CASCADE
    ON UPDATE NO ACTION,
  CONSTRAINT `fileIDfk`
    FOREIGN KEY (`fileID` )
    REFERENCES `508devDB`.`File` (`fileID` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `508devDB`.`UserOwnsProject`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `508devDB`.`UserOwnsProject` ;

CREATE  TABLE IF NOT EXISTS `508devDB`.`UserOwnsProject` (
  `userId` INT NOT NULL ,
  `projectID` INT NOT NULL ,
  INDEX `userID_idx` (`userId` ASC) ,
  INDEX `projectID_idx` (`projectID` ASC) ,
  PRIMARY KEY (`userId`, `projectID`) ,
  CONSTRAINT `projectOwnerIDfk`
    FOREIGN KEY (`userId` )
    REFERENCES `508devDB`.`User` (`userID` )
    ON DELETE CASCADE
    ON UPDATE NO ACTION,
  CONSTRAINT `theOwnedProjectIDfk`
    FOREIGN KEY (`projectID` )
    REFERENCES `508devDB`.`Project` (`projectID` )
    ON DELETE CASCADE
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `508devDB`.`Comment`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `508devDB`.`Comment` ;

CREATE  TABLE IF NOT EXISTS `508devDB`.`Comment` (
  `commentID` INT NOT NULL AUTO_INCREMENT ,
  `comment` VARCHAR(512) NOT NULL ,
  `dateMade` DATETIME NOT NULL ,
  `author` INT NOT NULL ,
  PRIMARY KEY (`commentID`) ,
  INDEX `authorfk_idx` (`author` ASC) ,
  CONSTRAINT `authorfk`
    FOREIGN KEY (`author` )
    REFERENCES `508devDB`.`User` (`userID` )
    ON DELETE CASCADE
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `508devDB`.`ProjectHasComment`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `508devDB`.`ProjectHasComment` ;

CREATE  TABLE IF NOT EXISTS `508devDB`.`ProjectHasComment` (
  `projectID` INT NOT NULL ,
  `commentID` INT NOT NULL ,
  PRIMARY KEY (`projectID`, `commentID`) ,
  INDEX `projectID_idx` (`projectID` ASC) ,
  INDEX `commentID_idx` (`commentID` ASC) ,
  CONSTRAINT `projectWithCommentIDfk`
    FOREIGN KEY (`projectID` )
    REFERENCES `508devDB`.`Project` (`projectID` )
    ON DELETE CASCADE
    ON UPDATE NO ACTION,
  CONSTRAINT `theProjectCommentIDfk`
    FOREIGN KEY (`commentID` )
    REFERENCES `508devDB`.`Comment` (`commentID` )
    ON DELETE CASCADE
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `508devDB`.`VersionHasComment`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `508devDB`.`VersionHasComment` ;

CREATE  TABLE IF NOT EXISTS `508devDB`.`VersionHasComment` (
  `versionID` INT NOT NULL ,
  `commentID` INT NOT NULL ,
  PRIMARY KEY (`versionID`, `commentID`) ,
  INDEX `versionID_idx` (`versionID` ASC) ,
  INDEX `commentID_idx` (`commentID` ASC) ,
  CONSTRAINT `versionWithCommentIDfk`
    FOREIGN KEY (`versionID` )
    REFERENCES `508devDB`.`Version` (`versionID` )
    ON DELETE CASCADE
    ON UPDATE NO ACTION,
  CONSTRAINT `theVersionCommentIDfk`
    FOREIGN KEY (`commentID` )
    REFERENCES `508devDB`.`Comment` (`commentID` )
    ON DELETE CASCADE
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `508devDB`.`ProjectHasCollaborator`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `508devDB`.`ProjectHasCollaborator` ;

CREATE  TABLE IF NOT EXISTS `508devDB`.`ProjectHasCollaborator` (
  `projectID` INT NOT NULL ,
  `userID` INT NOT NULL ,
  PRIMARY KEY (`projectID`, `userID`) ,
  INDEX `projectID_idx` (`projectID` ASC) ,
  INDEX `userID_idx` (`userID` ASC) ,
  CONSTRAINT `projectWithCollaboratorsIDfk`
    FOREIGN KEY (`projectID` )
    REFERENCES `508devDB`.`Project` (`projectID` )
    ON DELETE CASCADE
    ON UPDATE NO ACTION,
  CONSTRAINT `theUserThatCollaboratesIDfk`
    FOREIGN KEY (`userID` )
    REFERENCES `508devDB`.`User` (`userID` )
    ON DELETE CASCADE
    ON UPDATE NO ACTION)
ENGINE = InnoDB;



SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;

-- -----------------------------------------------------
-- Data for table `508devDB`.`User`
-- -----------------------------------------------------
START TRANSACTION;
USE `508devDB`;
INSERT INTO `508devDB`.`User` (`userID`, `dateRegistered`, `lastLoggedIn`, `lastLoggedOut`, `firstName`, `lastName`, `email`, `password`, `ip`) VALUES (1, '2012-11-14 12:59:25', '2012-11-14 14:16:07', '2012-11-14 14:17:01', 'John', 'Smith', 'jsmith@gmail.com', 'smithypass', NULL);
INSERT INTO `508devDB`.`User` (`userID`, `dateRegistered`, `lastLoggedIn`, `lastLoggedOut`, `firstName`, `lastName`, `email`, `password`, `ip`) VALUES (2, '2012-11-14 13:30:26', '2012-11-14 09:17:01', '2012-11-13 14:12:01', 'Alex', 'Jones', 'ajones@gmail.com', 'jonesypass', NULL);

COMMIT;

-- -----------------------------------------------------
-- Data for table `508devDB`.`Project`
-- -----------------------------------------------------
START TRANSACTION;
USE `508devDB`;
INSERT INTO `508devDB`.`Project` (`projectID`, `name`, `dateCreated`, `type`) VALUES (1, 'Johns First Project', '2012-11-14 13:59:25', 'als');

COMMIT;

-- -----------------------------------------------------
-- Data for table `508devDB`.`Version`
-- -----------------------------------------------------
START TRANSACTION;
USE `508devDB`;
INSERT INTO `508devDB`.`Version` (`versionID`, `versionNumber`, `projectID`, `createdBy`, `dateCreated`, `changes`) VALUES (1, 1, 1, 1, '2012-11-14 13:59:25', 'created project');
INSERT INTO `508devDB`.`Version` (`versionID`, `versionNumber`, `projectID`, `createdBy`, `dateCreated`, `changes`) VALUES (2, 2, 1, 2, '2012-11-14 15:20:25', 'just added a wav');
INSERT INTO `508devDB`.`Version` (`versionID`, `versionNumber`, `projectID`, `createdBy`, `dateCreated`, `changes`) VALUES (3, 3, 1, 1, '2012-11-15 03:20:25', 'removed orginial.wav');

COMMIT;

-- -----------------------------------------------------
-- Data for table `508devDB`.`Message`
-- -----------------------------------------------------
START TRANSACTION;
USE `508devDB`;
INSERT INTO `508devDB`.`Message` (`messageID`, `fromID`, `toID`, `message`, `dateSent`, `dateRead`) VALUES (1, 2, 1, 'can i remix your project?', '2012-11-14 14:59:25', NULL);

COMMIT;

-- -----------------------------------------------------
-- Data for table `508devDB`.`File`
-- -----------------------------------------------------
START TRANSACTION;
USE `508devDB`;
INSERT INTO `508devDB`.`File` (`fileID`, `filePath`, `uploadDate`, `format`, `size`, `fileName`) VALUES (1, '/files/1-10/original.wav', '2012-11-14 14:01:25', 'wav', 93000000, 'original.wav');
INSERT INTO `508devDB`.`File` (`fileID`, `filePath`, `uploadDate`, `format`, `size`, `fileName`) VALUES (2, '/files/1-10/remix.wav', '2012-11-14 15:03:33', 'wav', 95888340, 'remix.wav');

COMMIT;

-- -----------------------------------------------------
-- Data for table `508devDB`.`VersionHasFile`
-- -----------------------------------------------------
START TRANSACTION;
USE `508devDB`;
INSERT INTO `508devDB`.`VersionHasFile` (`versionID`, `fileID`) VALUES (1, 1);
INSERT INTO `508devDB`.`VersionHasFile` (`versionID`, `fileID`) VALUES (2, 1);
INSERT INTO `508devDB`.`VersionHasFile` (`versionID`, `fileID`) VALUES (2, 2);
INSERT INTO `508devDB`.`VersionHasFile` (`versionID`, `fileID`) VALUES (3, 2);

COMMIT;

-- -----------------------------------------------------
-- Data for table `508devDB`.`UserOwnsProject`
-- -----------------------------------------------------
START TRANSACTION;
USE `508devDB`;
INSERT INTO `508devDB`.`UserOwnsProject` (`userId`, `projectID`) VALUES (1, 1);

COMMIT;

-- -----------------------------------------------------
-- Data for table `508devDB`.`Comment`
-- -----------------------------------------------------
START TRANSACTION;
USE `508devDB`;
INSERT INTO `508devDB`.`Comment` (`commentID`, `comment`, `dateMade`, `author`) VALUES (1, '\"I like your project!\"', '2012-11-14 14:12:33', 2);
INSERT INTO `508devDB`.`Comment` (`commentID`, `comment`, `dateMade`, `author`) VALUES (2, '\"Thanks for your wav!\"', '2012-11-14 17:59:25', 1);

COMMIT;

-- -----------------------------------------------------
-- Data for table `508devDB`.`ProjectHasComment`
-- -----------------------------------------------------
START TRANSACTION;
USE `508devDB`;
INSERT INTO `508devDB`.`ProjectHasComment` (`projectID`, `commentID`) VALUES (1, 1);

COMMIT;

-- -----------------------------------------------------
-- Data for table `508devDB`.`VersionHasComment`
-- -----------------------------------------------------
START TRANSACTION;
USE `508devDB`;
INSERT INTO `508devDB`.`VersionHasComment` (`versionID`, `commentID`) VALUES (2, 2);

COMMIT;

-- -----------------------------------------------------
-- Data for table `508devDB`.`ProjectHasCollaborator`
-- -----------------------------------------------------
START TRANSACTION;
USE `508devDB`;
INSERT INTO `508devDB`.`ProjectHasCollaborator` (`projectID`, `userID`) VALUES (1, 1);
INSERT INTO `508devDB`.`ProjectHasCollaborator` (`projectID`, `userID`) VALUES (1, 2);

COMMIT;
