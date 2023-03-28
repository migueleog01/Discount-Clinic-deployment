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




