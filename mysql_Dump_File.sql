DROP DATABASE IF EXISTS `discount_clinic`;
CREATE DATABASE `discount_clinic`; 
USE `discount_clinic`;

SET character_set_client = utf8mb4 ;

-- -----------------------------------------------------
-- Table `discount_clinic`.`user`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `discount_clinic`.`user` (
	`user_ID` INT NOT NULL AUTO_INCREMENT,
	`role` VARCHAR(7) NOT NULL,
	`username` VARCHAR(25) NOT NULL UNIQUE,
	`password` VARCHAR(15) NOT NULL,
    -- `email` VARCHAR(50) NOT NULL,
	`deleted` BOOLEAN DEFAULT FALSE,
  PRIMARY KEY (`user_ID`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8mb4
COLLATE = utf8mb4_0900_ai_ci;


-- -----------------------------------------------------
-- Table `discount_clinic`.`address`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `discount_clinic`.`address` (
	`address_id` INT NOT NULL AUTO_INCREMENT,
	`street_address` VARCHAR(50) NOT NULL,
	`city` VARCHAR(20) NOT NULL,
	`state` CHAR(2) NOT NULL,
	`zip` INT(5) NOT NULL,
	`deleted` BOOLEAN NOT NULL,
  PRIMARY KEY (`address_id`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8mb4
COLLATE = utf8mb4_0900_ai_ci;


-- -----------------------------------------------------
-- Table `discount_clinic`.`patient`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `discount_clinic`.`patient` (
	`patient_id` INT NOT NULL AUTO_INCREMENT,
    -- `doctor_id` INT,
	`user_id` INT,
    `primary_doctor_id` INT NULL,
	`address_id` INT,
	`first_name` VARCHAR(20) NOT NULL,
	`middle_initial` VARCHAR(1) NOT NULL,
	`last_name` VARCHAR(20) NOT NULL,
	`gender` VARCHAR(1) NOT NULL,
	`phone_number` VARCHAR(12) NULL DEFAULT NULL,
	`DOB` DATE NOT NULL,
    `total_owe` INT NOT NULL DEFAULT 0,
	`deleted` BOOLEAN NOT NULL,
	FOREIGN KEY(`address_id`) REFERENCES `discount_clinic`.`address`(`address_id`),
	FOREIGN KEY(`user_id`) REFERENCES `discount_clinic`.`user`(`user_ID`),
	PRIMARY KEY (`patient_id`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8mb4
COLLATE = utf8mb4_0900_ai_ci;

-- -----------------------------------------------------
-- Table `discount_clinic`.`admin`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `discount_clinic`.`admin` (
	`admin_ID` INT NOT NULL AUTO_INCREMENT,
    `user_id` INT,
	`username` VARCHAR(25) NOT NULL,
	`password` VARCHAR(15) NOT NULL,
	`deleted` BOOLEAN NOT NULL,
    FOREIGN KEY(`user_id`) REFERENCES `discount_clinic`.`user`(`user_ID`),
    PRIMARY KEY (`admin_ID`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8mb4
COLLATE = utf8mb4_0900_ai_ci;

-- -----------------------------------------------------
-- Table `discount_clinic`.`office`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `discount_clinic`.`office` (
	`office_id` INT NOT NULL AUTO_INCREMENT,
	`address_id` INT,
	`deleted` BOOLEAN NOT NULL,
	FOREIGN KEY(`address_id`) REFERENCES `discount_clinic`.`address`(`address_id`),
	PRIMARY KEY (`office_id`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8mb4
COLLATE = utf8mb4_0900_ai_ci;

-- -----------------------------------------------------
-- Table `discount_clinic`.`doctor`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `discount_clinic`.`doctor` (
	`doctor_id` INT NOT NULL AUTO_INCREMENT,
	`user_id` INT,
	`first_name` VARCHAR(20) NOT NULL,
	`middle_initial` VARCHAR(1) NOT NULL,
	`last_name` VARCHAR(20) NOT NULL,
	`phone_number` VARCHAR(12) NULL DEFAULT NULL,
    `gender` VARCHAR(1) NOT NULL,
    `DOB` DATE NOT NULL,
	`specialty` VARCHAR(20) DEFAULT 'primary',
	`deleted` BOOLEAN NOT NULL,
	FOREIGN KEY(`user_id`) REFERENCES `discount_clinic`.`user`(`user_ID`),
	PRIMARY KEY (`doctor_id`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8mb4
COLLATE = utf8mb4_0900_ai_ci;

-- -----------------------------------------------------
-- Table `discount_clinic`.`appointment`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `discount_clinic`.`appointment` (
	`appointment_id` INT NOT NULL AUTO_INCREMENT,
	`patient_id` INT NOT NULL,
	`doctor_id` INT NOT NULL,
	`office_id` INT NOT NULL,
	`time` VARCHAR(5) NOT NULL,
	`date` DATE NOT NULL,
	`diagnosis` VARCHAR(50) NULL DEFAULT NULL,
	`deleted` BOOLEAN NOT NULL,
	FOREIGN KEY(`patient_id`) REFERENCES `discount_clinic`.`patient`(`patient_id`),
	FOREIGN KEY(`doctor_id`) REFERENCES `discount_clinic`.`doctor`(`doctor_id`),
	FOREIGN KEY(`office_id`) REFERENCES `discount_clinic`.`office`(`office_id`),
	PRIMARY KEY (`appointment_id`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8mb4
COLLATE = utf8mb4_0900_ai_ci;

-- -----------------------------------------------------
-- Table `discount_clinic`.`emergency_contact`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `discount_clinic`.`emergency_contact` (
	`patient_id` INT NOT NULL,
	`e_first_name` VARCHAR(20) NOT NULL,
	`e_middle_initial` VARCHAR(1) NOT NULL,
	`e_last_name` VARCHAR(20) NOT NULL,
	`phone_number` VARCHAR(12) NULL DEFAULT NULL,
	`relationship` VARCHAR(20) NULL DEFAULT NULL,
	`deleted` BOOLEAN NOT NULL,
	FOREIGN KEY(`patient_id`) REFERENCES `discount_clinic`.`patient`(`patient_id`),
	PRIMARY KEY (`patient_id`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8mb4
COLLATE = utf8mb4_0900_ai_ci;

/*
-- -----------------------------------------------------
-- Table `discount_clinic`.`medicine`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `discount_clinic`.`medicine` (
	`medicine_id` INT NOT NULL,
	`patient_id` INT NOT NULL,
	`medical_history_id` INT NOT NULL,
	`medicine_name` VARCHAR(45) NOT NULL,
	`quantity` VARCHAR(10) NOT NULL,
	`doctor_perscribed` VARCHAR(20) NOT NULL,
	`deleted` BOOLEAN NOT NULL,
	PRIMARY KEY (`medicine_id`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8mb4
COLLATE = utf8mb4_0900_ai_ci;


-- -----------------------------------------------------
-- Table `discount_clinic`.`medicial_history`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `discount_clinic`.`medicial_history` (
	`medical_history_id` INT NOT NULL,
	`patient_id` INT NOT NULL,
	`doctor_id` INT NOT NULL,
	`appointment_id` INT NULL,
	`deleted` BOOLEAN NOT NULL,
	FOREIGN KEY(`patient_id`) REFERENCES `discount_clinic`.`patient`(`patient_id`),
	FOREIGN KEY(`doctor_id`) REFERENCES `discount_clinic`.`doctor`(`doctor_id`),
	PRIMARY KEY (`medical_history_id`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8mb4
COLLATE = utf8mb4_0900_ai_ci;
*/

-- -----------------------------------------------------
-- Table `discount_clinic`.`transaction`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `discount_clinic`.`transaction` ( 
	`transaction_id` INT NOT NULL AUTO_INCREMENT,
    `patient_id` INT NOT NULL,
	`appointment_id` INT NOT NULL,
	`amount` INT NOT NULL,
	`pay` BOOLEAN NOT NULL,
	FOREIGN KEY(`patient_id`) REFERENCES `discount_clinic`.`patient`(`patient_id`),
	PRIMARY KEY (`transaction_id`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8mb4
COLLATE = utf8mb4_0900_ai_ci;

-- -----------------------------------------------------
-- Table `discount_clinic`.`approval`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `discount_clinic`.`approval` ( 
	`approval_id` INT NOT NULL AUTO_INCREMENT,
	`patient_id` INT NOT NULL,
    `primary_doctor_id` INT NULL,
	`specialist_doctor_id` INT NOT NULL,
	`approval_date` DATE NULL,
    `approval_bool` TINYINT(1) DEFAULT FALSE,
	FOREIGN KEY (`patient_id`) REFERENCES `discount_clinic`.`patient`(`patient_id`),
    FOREIGN KEY(`primary_doctor_id`) REFERENCES `discount_clinic`.`doctor`(`doctor_id`),
    FOREIGN KEY(`specialist_doctor_id`) REFERENCES `discount_clinic`.`doctor`(`doctor_id`),
	PRIMARY KEY (`approval_id`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8mb4
COLLATE = utf8mb4_0900_ai_ci;

/*
-- -----------------------------------------------------
-- Table `discount_clinic`.`doctor_patient`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `doctor_patient` (
	`DID` INT NOT NULL,
	`PID` INT NOT NULL,
	`deleted` TINYINT(1) DEFAULT FALSE,
	PRIMARY KEY (`DID`,`PID`),
	FOREIGN KEY (`DID`) REFERENCES `doctor`(`doctor_id`),
	FOREIGN KEY (`PID`) REFERENCES `patient`(`patient_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
*/

-- -----------------------------------------------------
-- Table `discount_clinic`.`doctor_office`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `doctor_office` (
	`DID` INT NOT NULL,
	`OID` INT NOT NULL,
	PRIMARY KEY (`DID`,`OID`),
	FOREIGN KEY (`DID`) REFERENCES `doctor`(`doctor_id`),
	FOREIGN KEY (`OID`) REFERENCES `office`(`office_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- -------------------------
-- CREATING TRIGGERS 
-- -------------------------
-- EVERY TIME AN APPOINTMENT IS CREATED/DELETED THE TOTAL AMOUNT THE PATIENT OWES IS MODIFIED TO INCREASE/DECREASE
DELIMITER $$
CREATE TRIGGER `update_total_owe` AFTER INSERT ON `transaction` FOR EACH ROW
BEGIN
	IF new.pay = 0
    THEN
		UPDATE patient
		SET total_owe = total_owe + new.amount
		WHERE patient.patient_id = new.patient_id;
	ELSE
		UPDATE patient
		SET total_owe = total_owe - new.amount
		WHERE patient.patient_id = new.patient_id;
	END IF;
END $$
DELIMITER ;



-- APPROVAL TRIGGER THAT CHECKS IF YOU HAVE APPROVAL TO SEE THE SPECIALIST
DELIMITER $$
CREATE TRIGGER `approval_trigger` BEFORE INSERT ON `appointment` FOR EACH ROW
BEGIN 
	-- IF THE DOCTOR YOU WANT AN APPOINTMENT WITH IS NOT A PRIMARY DOCTOR
	IF (((SELECT doctor.specialty FROM doctor WHERE new.doctor_id = doctor.doctor_id) <> 'primary') 
    AND 
    -- IF THE APPROVAL STATUS WITH THE DOCTOR IS FALSE
    (SELECT approval.approval_bool FROM approval WHERE new.patient_id = approval.patient_id AND new.doctor_id = approval.specialist_doctor_id) = FALSE)
	THEN
		SIGNAL SQLSTATE '45000' 
		SET MESSAGE_TEXT = "You need an approval from a primary physician.";
	END IF;
END $$
DELIMITER ; 



-- CREATES AN APPROVAL FOR THE PATIENT TO SEE THE SPECIALIST
DELIMITER $$
CREATE TRIGGER `create_approval` BEFORE INSERT ON `appointment` FOR EACH ROW
BEGIN
	DECLARE approval_count, patient_primary_doctor_id  INT(5);
    SET approval_count = (SELECT COUNT(*) FROM approval) + 1;
    SET patient_primary_doctor_id = (SELECT patient.primary_doctor_id FROM patient WHERE new.patient_id = patient.patient_id);
    
	IF ((SELECT doctor.specialty FROM doctor WHERE new.doctor_ID = doctor.doctor_id) <> 'primary')
	THEN
        IF NOT EXISTS (SELECT 1 FROM approval WHERE approval.patient_id = new.patient_id AND approval.specialist_doctor_id = new.doctor_id) THEN
			INSERT INTO `discount_clinic`.`approval`
			(`approval_id`,`patient_id`, `primary_doctor_id`, `specialist_doctor_id`, `approval_date`, `approval_bool`) VALUES
			(approval_count,new.patient_id,patient_primary_doctor_id,new.doctor_id, new.date, FALSE);
            SET new.deleted = TRUE;
            -- CALL message();
            
		END IF;
    END IF;
END $$
DELIMITER ; 



-- THE USER CANNOT CREATE ANOTHER APPOINTMENT IF THE PATIENT ALREADY HAS AN EXISTING APPOINTMENT AT THIS TIME
DELIMITER $$
CREATE TRIGGER `paitent_appointment_time_trigger` BEFORE INSERT ON `appointment` FOR EACH ROW BEGIN
IF (SELECT COUNT(*)
FROM appointment
WHERE appointment.patient_id = new.patient_id AND appointment.time = new.time AND appointment.date = new.date AND appointment.appointment_id <> new.appointment_id) >= 1
THEN
SIGNAL SQLSTATE '45000' 
SET MESSAGE_TEXT = "You already have an appointment at this time.";
END IF;
END $$
DELIMITER ;


-- THE USER CANNOT CREATE AN APPOINTMENT IF THE DOCTOR ALREADY HAS AN APPOINTMENT AT THIS TIME
DELIMITER $$
CREATE TRIGGER `doctor_appointment_time_trigger` BEFORE INSERT ON `appointment` FOR EACH ROW BEGIN
IF (SELECT COUNT(*)
FROM appointment
WHERE  appointment.time = new.time AND appointment.date = new.date AND appointment.doctor_id = new.doctor_id AND appointment.appointment_id <> new.appointment_id) >= 1
THEN
SIGNAL SQLSTATE '45000' 
SET MESSAGE_TEXT = "This doctor already has an appointment at this time.";
END IF;
END $$
DELIMITER ;


-- A PATIENT CANNOT HAVE THE SAME ADDRESS_ID AS AN OFFICE
DELIMITER $$
CREATE TRIGGER `patient_office_address_trigger` BEFORE INSERT ON `patient` FOR EACH ROW BEGIN
IF (SELECT COUNT(*) >= 1
FROM patient
WHERE patient.address_id = new.address_id ) >= 1
THEN
SIGNAL SQLSTATE '45000' 
SET MESSAGE_TEXT = "This address already belongs to an office.";
END IF;
END $$
DELIMITER ;


-- A NEW OFFICE CANNOT HAVE THE SAME ADDRESS_ID AS AN EXISTING OFFICE
DELIMITER $$
CREATE TRIGGER `office_address_trigger` BEFORE INSERT ON `office` FOR EACH ROW BEGIN
IF (SELECT COUNT(*) >= 1
FROM office
WHERE office.address_id = new.address_id) >= 1
THEN
SIGNAL SQLSTATE '45000' 
SET MESSAGE_TEXT = "This address already belongs to an existing office.";
END IF;
END $$
DELIMITER ;


-- A NEW OFFICE CANNOT HAVE THE SAME ADDRESS_ID TO A PATIENT
DELIMITER $$
CREATE TRIGGER `office_patient_address_trigger` BEFORE INSERT ON `office` FOR EACH ROW BEGIN
IF (SELECT COUNT(*) >= 1
FROM patient
WHERE patient.address_id = new.address_id) >= 1
THEN
SIGNAL SQLSTATE '45000' 
SET MESSAGE_TEXT = "This address already belongs to a patient";
END IF;
END $$
DELIMITER ;

-- INSERT A NEW TRANSACTION AFTER AN INSERT ON APPOINTMENT
DELIMITER $$
CREATE TRIGGER `discount_clinic`.`insert_transaction` AFTER INSERT ON `discount_clinic`.`appointment` FOR EACH ROW
BEGIN
    DECLARE transaction_count INT(5);
    SET transaction_count = (SELECT COUNT(*) FROM transaction) + 1;
    INSERT INTO `discount_clinic`.`transaction` (transaction_id, patient_id, appointment_id, amount, pay) VALUES 
    (transaction_count, new.patient_id, new.appointment_id, 50, 0);
END $$
DELIMITER ;

-- updates appointment.deleted to false when approval.approval_bool is updated to true
DELIMITER $$
CREATE TRIGGER `discount_clinic`.`update_deleted` AFTER UPDATE ON `discount_clinic`.`approval` FOR EACH ROW
BEGIN
	IF (NEW.approval_bool = 1)
    THEN
		UPDATE appointment
        SET appointment.deleted=FALSE 
        WHERE NEW.patient_id=appointment.patient_id 
        AND NEW.specialist_doctor_id=appointment.doctor_id;
END IF;
END $$
DELIMITER ;


DELIMITER $$
CREATE TRIGGER `discount_clinic`.`current_time` BEFORE UPDATE ON `discount_clinic`.`approval` FOR EACH ROW
BEGIN
    SET NEW.approval_date = CURDATE();
END $$
DELIMITER ;


USE discount_clinic;
INSERT INTO user (role, username, password) VALUES ('admin', 'admin', '123');
