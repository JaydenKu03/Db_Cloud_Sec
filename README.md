## Getting Started

These instructions will give you a copy of the project up and running on
your local machine for development and testing purposes. 

A step by step series of examples that tell you how to get a development
environment running. If you already have the downloaded file inside the htdocs folder, 
you can skip the "clone repository". 

### Clone repository 

    git clone https://github.com/JaydenKu03/Db_Cloud_Sec.git

### Install drivers for establish connection to SQL Server

    https://learn.microsoft.com/en-us/sql/connect/php/download-drivers-php-sql-server?view=sql-server-ver16

### Note
- Make sure your php version match the drivers version.

### Instruction
1. After u install the drivers folder, find the drivers that match your php version and move to the folder "xampp/php/ext"

2. Find a file call 'php_ini' in the folder "xampp/php" and add the drivers description

3. Open SSMS and create a database call `FYP_System`

2. Open the sample_data.sql in SSMS and execute it for creating sample data

3. Start Apache option in XAMPP 

4. Open browser, URL to Login Page: http://localhost/MMU-FYP-System-PART2/login.php

5. Some sample account to login: 
  -  ID: 80004  Password: admin123
  -  ID: 50001  Password: supervisor123
  -  ID: 10001  Password: student123