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
	`user_id` INT,
	`address_id` INT,
	`first_name` VARCHAR(20) NOT NULL,
	`middle_initial` VARCHAR(1) NOT NULL,
	`last_name` VARCHAR(20) NOT NULL,
	`gender` VARCHAR(1) NOT NULL,
	`phone_number` VARCHAR(12) NULL DEFAULT NULL,
	`DOB` DATE NOT NULL,
    `totalDue` INT DEFAULT 0,
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
	`admin_ID` INT NOT NULL,
	`username` VARCHAR(25) NOT NULL,
	`password` VARCHAR(15) NOT NULL,
	`deleted` BOOLEAN NOT NULL)
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
	`d_first_name` VARCHAR(20) NOT NULL,
	`d_middle_initial` VARCHAR(1) NOT NULL,
	`d_last_name` VARCHAR(20) NOT NULL,
	`d_phone_number` VARCHAR(12) NULL DEFAULT NULL,
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

-- -----------------------------------------------------
-- Table `discount_clinic`.`transaction`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `discount_clinic`.`transaction` ( 
	`transaction_id` INT NOT NULL,
    `amount` INT NOT NULL,
	`appointment_id` INT NOT NULL,
	`deleted` BOOLEAN NOT NULL,
	FOREIGN KEY(`appointment_id`) REFERENCES `discount_clinic`.`appointment`(`appointment_id`),
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



DELIMITER $$
CREATE TRIGGER `doctor_patient_list` AFTER INSERT ON `appointment` FOR EACH ROW
	-- if a patient has had an appointment with a doctor, and the tuple isn't already in doctor_patient list, and the appointment isn't deleted
    -- (unapproved specialist appointments are marked deleted until approval), add it to doctor_patient list
    IF ( (SELECT COUNT(*) FROM `doctor_patient` WHERE `doctor_patient`.`DID` = NEW.`doctor_id` AND `doctor_patient`.`PID` = NEW.`patient_id`) < 1
    AND NEW.deleted IS FALSE )
    THEN
		INSERT INTO `doctor_patient` VALUES (NEW.`doctor_id`,NEW.`patient_id`,FALSE);
	END IF
$$
DELIMITER ;

/*
 Sets an appointment w/ specialist to deleted if the patient doesn't have approval for that appointment. (Doesn't actually prevent tuple from
 being inserted into appointment.)
 When the approval bool is set to false, this will prevent an appointment's transaction amount from being added to the patient's statement/bill,
 because until approval bool is set to true, appointment deleted attribute will be true
 Both of these are indicators that a specific appointment has not happened yet / is not happening yet
 Additionally, the doctor_patient_list trigger prevents doctor-patient values matching from what's in appointments list with deleted=true from
 being inserted into the doctor_patient list. So, we won't see a specialist-patient combination in doctor_patient 
 */
DELIMITER $$
CREATE TRIGGER `specialty_approval_trig` BEFORE INSERT ON `appointment` FOR EACH ROW
BEGIN
/*
IF (SELECT appointment.deleted FROM appointment WHERE appointment.doctor_id=NEW.doctor_id AND appointment.patient_id=NEW.patient_id) IS TRUE 
AND (SELECT approval_bool FROM approval WHERE specialist_doctor_id = NEW.doctor_id AND patient_id = NEW.patient_id) IS TRUE
	THEN
		UPDATE appointment,approval SET appointment.deleted = FALSE WHERE appointment.doctor_id=NEW.doctor_id AND appointment.patient_id=NEW.patient_id
        AND specialist_doctor_id = NEW.doctor_id AND patient_id = NEW.patient_id;
*/
IF (SELECT specialty FROM doctor WHERE doctor_id = NEW.doctor_id) <> 'primary'
	THEN
		IF (SELECT approval_bool FROM approval WHERE specialist_doctor_id = NEW.doctor_id AND patient_id = NEW.patient_id) IS FALSE
        -- add AND the patient has a primary doctor in doctor_patient (?)
			THEN
                SIGNAL SQLSTATE '02000' SET MESSAGE_TEXT = "You need approval to see a specialist.";
		ELSEIF (SELECT COUNT(*) FROM approval WHERE specialist_doctor_id = NEW.doctor_id AND patient_id = NEW.patient_id) = 0 
			THEN
				INSERT INTO approval (patient_id,specialist_doctor_id,approval_bool) 
                VALUES (NEW.patient_id,NEW.doctor_id,FALSE);
				SET NEW.deleted = TRUE; -- just mark as deleted because DELETE statement gives Error Code: 1442. Can't update table 'appointment' in stored function/trigger because it is already used by statement which invoked this stored function/trigger.
                UPDATE transaction SET transaction.deleted = TRUE WHERE transaction.appointment_id = NEW.appointment_id;
		END IF;
        /*
		IF ( (SELECT COUNT(*) FROM approval WHERE specialist_doctor_id = NEW.doctor_id AND patient_id = NEW.patient_id AND approval_bool IS FALSE) = 1
        AND (NEW.deleted IS TRUE) )
			THEN
                SIGNAL SQLSTATE '02000' SET MESSAGE_TEXT = "You need a GP to see a specialist."; -- doesn't work; transaction rolls back insert into from previous elseif statement
		END IF;
        */
	END IF;
END $$
DELIMITER ;


-- This trigger is supposed to be activated once the insert into approval inside of `specialty_approval_trig` is done.
-- Unfortunately it doesn't do anything.
DELIMITER $$
CREATE TRIGGER `approval_insert_trig` AFTER INSERT ON `approval` FOR EACH ROW
BEGIN
IF ( (SELECT COUNT(approval_id) FROM approval,appointment WHERE NEW.specialist_doctor_id = appointment.doctor_id AND NEW.patient_id = appointment.patient_id AND NEW.approval_bool IS FALSE) = 1
AND (SELECT appointment.deleted FROM appointment,patient WHERE NEW.specialist_doctor_id = appointment.doctor_id AND NEW.patient_id = appointment.patient_id) IS TRUE )
	THEN
		DELETE FROM appointment WHERE (SELECT appointment.deleted FROM appointment,approval WHERE appointment.doctor_id = NEW.specialist_doctor_id AND appointment.patient_id = NEW.patient_id ) IS TRUE;
END IF;
END $$
DELIMITER ;


DELIMITER $$
CREATE TRIGGER `is_not_in_doctor_patient_list_for_patient` BEFORE UPDATE ON `approval` FOR EACH ROW
BEGIN
IF
(SELECT NEW.primary_doctor_id FROM approval) NOT IN (SELECT DID FROM doctor_patient WHERE doctor_patient.PID = NEW.patient_id)
THEN
SIGNAL SQLSTATE '02000' SET MESSAGE_TEXT = "Permission denied. Not a primary doctor of this specific patient.";
END IF;
END $$
DELIMITER ;


-- If appointment is approved, change the appointment's deleted value back to false from true
DELIMITER $$
CREATE TRIGGER `approval_update` AFTER UPDATE ON `approval` FOR EACH ROW
BEGIN
-- if approval_bool has been updated to true and the associated appointment.deleted is currently true
	-- update the associated appointment.deleted value to false
IF ( (SELECT NEW.approval_bool FROM approval,appointment WHERE NEW.specialist_doctor_id = appointment.doctor_id AND NEW.patient_id = appointment.patient_id) IS TRUE
AND
(SELECT appointment.deleted FROM appointment,approval WHERE appointment.doctor_id = NEW.specialist_doctor_id AND appointment.patient_id = NEW.patient_id) IS TRUE )
-- AND patient-doctor combo already exists in doctor_patient
THEN
	UPDATE appointment SET appointment.deleted=FALSE WHERE appointment.doctor_id = NEW.specialist_doctor_id AND appointment.patient_id = NEW.patient_id IS TRUE;
    UPDATE transaction SET transaction.deleted=FALSE WHERE transaction.appointment_id = (SELECT appointment_id FROM appointment WHERE appointment.deleted=FALSE AND appointment.doctor_id = NEW.specialist_doctor_id AND appointment.patient_id = NEW.patient_id);
END IF;
END $$
DELIMITER ;



-- Ben's Trigger --
-- THE PATIENT RECIEVES A MESSAGE THAT THE PATIENT MUST BE APPROVED TO CREATE AN APPOINTMENT WITH A SPECIALIST
/*
DELIMITER $$
CREATE TRIGGER `approval_trigger` BEFORE INSERT ON `appointment` FOR EACH ROW BEGIN
IF ((
(SELECT doctor.specialty
FROM doctor, approval, patient, appointment
WHERE doctor.specialty <> 'primary' AND new.appointment_id = approval.appointment_id AND doctor.doctor_id = approval.specialist_doctor_id AND approval.patient_id = patient.patient_id AND approval.patient_id = new.patient_id) <> 'primary')
AND
(SELECT approval.approval_bool
FROM doctor, approval, patient, appointment
WHERE approval.approval_bool = FALSE AND new.appointment_id = approval.appointment_id AND doctor.doctor_id = approval.specialist_doctor_id AND approval.patient_id = patient.patient_id AND approval.patient_id = new.patient_id AND new.doctor_id = approval.specialist_doctor_id) = FALSE
)
THEN
SIGNAL SQLSTATE '45000'
SET MESSAGE_TEXT = "You need approval from a primary physician.";
END IF;
END $$
DELIMITER ;
*/


DELIMITER $$
CREATE TRIGGER `transaction_adds_balance_to_patient_totalDue` AFTER INSERT ON `transaction`
FOR EACH ROW
IF (SELECT NEW.`deleted`) IS FALSE
AND
(SELECT `deleted` FROM `appointment` WHERE `appointment_id` = NEW.`appointment_id`) IS FALSE
THEN
UPDATE `patient`,`appointment`,`transaction` SET `patient`.`totalDue`=(`patient`.`totalDue`+NEW.`amount`) WHERE `patient`.`patient_id`=`appointment`.`patient_id`
AND `appointment`.`appointment_id`=NEW.`appointment_id`;
END IF
$$
DELIMITER ;

DELIMITER $$
CREATE TRIGGER `transaction_update` AFTER UPDATE ON `transaction`
FOR EACH ROW
IF (SELECT NEW.`deleted`) IS FALSE
AND
(SELECT `deleted` FROM `appointment` WHERE `appointment_id` = NEW.`appointment_id`) IS FALSE
THEN
UPDATE `patient`,`appointment`,`transaction` SET `patient`.`totalDue`=(`patient`.`totalDue`+NEW.`amount`) WHERE `patient`.`patient_id`=`appointment`.`patient_id`
AND `appointment`.`appointment_id`=NEW.`appointment_id`;
END IF
$$
DELIMITER ;

/*
-- Data for discount_clinic.user
INSERT INTO discount_clinic.user (user_ID, role, username, password, email, deleted) VALUES
(1, 'doctor', 'doctor1', 'password1', 'doctor1@example.com', FALSE),
(2, 'doctor', 'doctor2', 'password2', 'doctor2@example.com', FALSE),
(3, 'patient', 'patient1', 'password3', 'patient1@example.com', FALSE),
(4, 'patient', 'patient2', 'password4', 'patient2@example.com', FALSE),
(5, 'doctor', 'doctor3', 'password5', 'doctor3@example.com', FALSE);

-- Data for discount_clinic.address
INSERT INTO discount_clinic.address (address_id, street_address, city, state, zip, deleted) VALUES
(1, '123 Main St', 'Anytown', 'CA', 12345, FALSE),
(2, '456 Oak St', 'Othertown', 'NY', 67890, FALSE),
(3, '789 Pine St', 'Somewhere', 'FL', 54321, FALSE),
(4, '936 Gerund St', 'Anywhere', 'TX', 77339, FALSE);


-- Data for discount_clinic.patient
INSERT INTO discount_clinic.patient (patient_id, user_id, address_id, first_name, middle_initial, last_name, gender, phone_number, DOB, totalDue, deleted) VALUES
(1, 3, 1, 'John', 'D', 'Doe', 'M', '555-1234', '2000-01-01', 0, FALSE),
(2, 4, 2, 'Jane', 'E', 'Smith', 'F', '555-5678', '1995-05-05', 0, FALSE);

-- Data for discount_clinic.office
INSERT INTO discount_clinic.office (office_id, address_id, deleted) VALUES
(1, 3, FALSE),
(2, 3, FALSE);

-- Data for discount_clinic.doctor
INSERT INTO discount_clinic.doctor (doctor_id, user_id, d_first_name, d_middle_initial, d_last_name, d_phone_number, gender, DOB, specialty, deleted) VALUES
(1, 1, 'Dr. Jane', 'K', 'Doe', '555-2222', 'F', '1980-01-01', 'primary', FALSE),
(2, 2, 'Dr. John', 'S', 'Smith', '555-1111', 'M', '1975-01-01', 'cardiology', FALSE),
(3, 5, 'Dr. Amy', 'N', 'Cox', '840-3335', 'F', '2000-07-17', 'primary', FALSE);
*/

/*
INSERT INTO discount_clinic.appointment (appointment_id, patient_id, doctor_id, office_id, time, date, diagnosis, deleted) VALUES
(1, 1, 1, 1, '10:00', '2023-04-01', NULL, FALSE),
(2, 1, 3, 1, '12:00', '2023-09-10', NULL, FALSE),
(3, 1, 2, 1, '12:00', '2023-09-12', NULL, FALSE);

INSERT INTO discount_clinic.transaction (transaction_id, amount, appointment_id, deleted) VALUES
(1, 50, 1, FALSE),
(2, 80, 2, FALSE),
(3, 120, 3, FALSE);
*/

-- need to add constraint to approval or appointment_approval trig where random doctor cannot change approval unless they're in
-- the doctor_patient list for a specific patient

/* Queries to test specialty_approval_trig trigger and approval_update trigger and  
`transaction_adds_balance_to_patient_totalDue` with:  */
/*
INSERT INTO discount_clinic.appointment (appointment_id, patient_id, doctor_id, office_id, time, date, diagnosis, deleted) VALUES
(3, 1, 2, 1, '12:00', '2023-09-12', NULL, FALSE);

UPDATE discount_clinic.approval SET approval_bool=TRUE, primary_doctor_id=1, approval_date='2023-09-15' WHERE specialist_doctor_id=2 AND approval_id=1 AND patient_id=1;

INSERT INTO discount_clinic.transaction (transaction_id, amount, appointment_id, deleted) VALUES
(3, 120, 3, FALSE);
*/
/* Make sure to execute them one at a time in separate sql file */
