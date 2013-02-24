SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES';

DROP SCHEMA IF EXISTS `508devDB` ;
CREATE SCHEMA IF NOT EXISTS `508devDB` DEFAULT CHARACTER SET latin1 ;
USE `508devDB` ;

-- -----------------------------------------------------
-- Table `508devDB`.`User`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `508devDB`.`User` ;

CREATE  TABLE IF NOT EXISTS `508devDB`.`User` (
  `userID` INT NOT NULL AUTO_INCREMENT ,
  `dateRegistered` DATETIME NOT NULL ,
  `lastLoggedIn` DATETIME NULL DEFAULT NULL ,
  `lastLoggedOut` DATETIME NULL DEFAULT NULL ,
  `firstName` VARCHAR(35) NULL DEFAULT NULL ,
  `lastName` VARCHAR(35) NULL DEFAULT NULL ,
  `email` VARCHAR(255) NOT NULL ,
  `password` VARCHAR(100) NOT NULL ,
  `ip` VARCHAR(40) NULL DEFAULT NULL ,
  `username` VARCHAR(45) NOT NULL ,
  PRIMARY KEY (`userID`, `username`) ,
  UNIQUE INDEX `email_UNIQUE` (`email` ASC) ,
  UNIQUE INDEX `username_UNIQUE` (`username` ASC) )
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
  `dateRead` DATETIME NULL DEFAULT NULL ,
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
  `format` VARCHAR(10) NULL DEFAULT NULL ,
  `size` INT NULL DEFAULT NULL ,
  `fileName` VARCHAR(75) NULL DEFAULT NULL ,
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
