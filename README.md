Discount Clinic Database System

Team 4 project web link: https://discount-clinic.azurewebsites.net/login.php
Link to project code: https://github.com/migueleog01/Discount-Clinic-deployment

The GitHub Discount-Clinic-deployment folder contains all of the project files, including the sql dump file named mysql_Dump_File.sql.

The database connection details are in dbh-inc.php.

Purpose:

This database is designed to streamline appointment scheduling and management of personal information for patients, doctors, and admins. Patients can register using a patient registration form and view their appointments, cancel appointments, update their personal information, view transactions on the transactions page, and schedule appointments with primary doctors or specialists (with primary doctor approval). Doctors can view their appointments and update their personal information, including their specialty. Admins can view reports for appointments, patients, and doctors at specific offices. Additionally, they can create or delete doctors, offices, or patients. 

The database was set up using Microsoft Azure, and MySQL was used to add triggers and create tables for data. The front-end was designed using HTML and CSS, while PHP was used to connect to the back-end database, resulting in a well-organized user-interface for efficient use. The team behind this database application is committed to delivering a successful project outcome while prioritizing data privacy and security through the use of secure access by user authentication. 

Installation and Testing:

To test the website in the cloud:

https://discount-clinic.azurewebsites.net/

To access the web application and database internals, follow these steps:

Download the latest available version of XAMPP here: https://www.apachefriends.org/download.html

If your installer does not begin XAMPP installation and instead throws a “‘xampp-osx-8.2.0-0-installer’ cannot be opened because the developer cannot be verified”, go to Privacy & Security under System Settings and allow the application access to your Downloads folder.

Once the installation finishes, XAMPP will open. 
Go to Manage Servers.
Start the ProFTPD and Apache Web Server servers.

If the XAMPP application folder is not already in Applications, move it there.

Next, download the project folder from GitHub, as seen here: https://github.com/migueleog01/Discount-Clinic-deployment

After unzipping the folder files, move your project folder inside of your XAMPP folder. From there, move the project folder inside of the htdocs folder. 

To access the database in the cloud, you will need to connect to it using the login credentials defined in dbh-inc.php. You can use a database client like MySQL Workbench to connect to the database. Download version 8.0.25 of MySQL Workbench: https://downloads.mysql.com/archives/workbench/

(Note that you may also download a local version of the database from the project folder, though it is not necessary. Run the SQL dump file titled mysql_Dump_File.sql to create the necessary tables and data in your new database.)

After installing MySQL Workbench, move it to your Applications folder. 

Open MySQL Workbench. On the Welcome page, you will see a plus icon next to MySQL Connections. Click on this to create a new instance. The access details are in dbh-inc.php. Here is what each field should look like under Parameters:


Connection Name: ​​Local instance MySQL80
Connection Method: Standard (TCP/IP)
Port: 3306
Hostname: discountclinic.mysql.database.azure.com
Username: adminLogin


Under SSL:

In the SSL CERT File field, link to the path where DigiCertGlobalRootCA.crt.pem is located. This file is inside of the project folder that you moved to Applications => XAMPP => htdocs.



Open your browser and type in the address bar: localhost/yourprojectfoldername to test the website.

Note: If you are not using XAMPP, which has inbuilt PHP and a PHP server, you will need to install a suitable web server and PHP environment to run the website locally.

Usage:

Once the database system is installed, you can use it to manage information and appointment scheduling based on the user.
 
Login Info Based on User Type (*slashes indicate different usernames that can be used):

Admin
Username: admin
Password: 123

Patient
Username: pjared/pessani/prao
Password: 123

Doctor
Username: dben/damanda/dmiguel/dsteven/duma/dmason
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

*Note that when choosing an office, in order to populate the doctor dropdown, you will have to toggle once back and forth between the office you want to select and another listed office within the same state. This is a minor bug.

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

