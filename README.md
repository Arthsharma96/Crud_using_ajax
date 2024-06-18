AJAX CRUD Application with CodeIgniter
-------------------------------------------------------------------------------------
Prerequisites
PHP version >= 5.6
MySQL or compatible database
Web server (Apache, Nginx, etc.)
-------------------------------------------------------------------------------------
Installation
Clone the repository:

git clone https://github.com/your_username/ajax-crud-codeigniter.git


-------------------------------------------------------------------------------------
Create the database and table:

Create the ajax_crud database:
CREATE DATABASE ajax_crud;

Create the users table inside ajax_crud:

USE ajax_crud;
CREATE TABLE users (
    id INT(11) NOT NULL AUTO_INCREMENT,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL,
    PRIMARY KEY (id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

------------------------------------------------------------------------------------
Access the application through your web server:
http://localhost/ajax-crud-codeigniter/

