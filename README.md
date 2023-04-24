# Discount-Clinic
Medical Clinic Project
Discount Clinic Database System

Team 4 Project Link: https://discount-clinic.azurewebsites.net/login.php
Link to project code: https://github.com/migueleog01/Discount-Clinic-deployment

Purpose:

This database is designed to streamline appointment scheduling and management of personal information for patients, doctors, and admins. Patients can register using a patient registration form and view their appointments, cancel appointments, update their personal information, view transactions on the transactions page, and schedule appointments with primary doctors or specialists (with primary doctor approval). Doctors can view their appointments and update their personal information, including their specialty. Admins can view reports for appointments, patients, and doctors at specific offices. Additionally, they can create or delete doctors, offices, or patients. 

The database was set up using Microsoft Azure, and MySQL was used to add triggers and create tables for data. The front-end was designed using HTML and CSS, while PHP was used to connect to the back-end database, resulting in a well-organized user-interface for efficient use. The team behind this database application is committed to delivering a successful project outcome while prioritizing data privacy and security through the use of secure access by user authentication. 

Installation:

To install the database system, follow these steps:

1. Install a compatible version of MySQL.
2. Create a new database in your MySQL.
3. Run the SQL dump file titled ‘mysql_Dump_File.sql` to create the necessary tables and data in your new database.

Usage:

Once the database system is installed, you can use it to manage information and appointment scheduling based on the user.
 
Login Info Based on User Type (*slashes indicate different usernames that can be used):

Admin
Username: admin
Password: 123

Patient
Username: pjared/prehman/prao
Password: 123

Doctor
Username: dben/damanda/dmiguel/dsteven/duma
Password: 123


Here are some examples of common usage scenarios for these various users:

Patients: 

Registering
Can only be done by patients
Choose your primary doctor
Redirected from signup page to patient registration form

Viewing appointments (past, current, future)
Navigate to home, where you’ll be directed when you sign in
Specialist appointment status will be viewable 
Option to cancel appointments is also present
Appointments can be filtered by date

Patient Profile Page
By navigating to the profile page, personal and emergency info can be easily updated
Patient can change primary doctor or be presented with the option to delete their account
Clicking one of the aforementioned buttons will direct you to a secondary page where these actions can be carried out

Scheduling Appointments
Navigate to the schedule appointments page to which you are given the option to filter by date, state, and time
Based on the chosen state, offices are offered to the user to pick from
Consequently, choosing an office gives the user an option to choose a doctor from that office
Can choose from any primary doctor or specialist (however, specialist appointments require primary doctor approval)

Viewing Transactions
Navigate to transactions where payment method can be selected from the drop down menu and the amount due can be paid
Negative balances can occur if payment is overpaid
Doctor: 

Viewing and approving appointments
Go to the home page upon login
Appointments page and home page will display the same information 
Go to Approval to approve patient specialist appointments

Updating personal information
Navigate to the Profile page to update personal information
Name, gender, phone number, and specialty can be updated

Admin: 

When logged in as an admin, you have the ability to view all the reports for the clinic website. These include reports of the appointments, patients, and doctors at any specific office
When you choose the report type of appointment, you will be prompted to choose a doctor type of either primary or specialist
If you choose a patient as the report type, you can filter the data based on their gender and age range
If you choose a doctor as the report type, you can filter based on whether the doctor is primary or specialist

Files:
The prefix of each file is a given indicator of which user type the page is for. For example, ‘admin_’ refers to pages made for the admin. 





