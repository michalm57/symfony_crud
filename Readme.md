# Symfony Project Setup
This README provides instructions on how to set up and run a Symfony project using Docker Compose. The project utilizes Docker containers for PHP, Apache, PostgreSQL database, and pgAdmin.

## Requirements
Docker and Docker Compose installed on your system.

PHP

Composer

Symfony

Apache

PostgreSQL database

pgAdmin

## Installation Steps
Clone the repository and navigate to the project directory:

git clone git@github.com:michalm57/symfony_crud.git

cd symfony_crud

Create a .env file:In the project root directory, create a new .env file with the following contents:
```python
APP_ENV=dev
APP_SECRET=ad0ea8abb1095405060cd81c0c741d7d
DATABASE_URL=postgresql://symfony_crud:password@database:5432/symfony_crud
MESSENGER_TRANSPORT_DSN=doctrine://default?auto_setup=0
EMAIL_LABS_APP_KEY=APP_KEY
EMAIL_LABS_SECRET_KEY=SECRET_KEY
EMAIL_LABS_SEND_URL=https://api.emaillabs.net.pl/api/sendmail
```
Build and start Docker containers:

Run the following command to build and start the Docker containers:
```python
docker-compose up -d --build
```
Access the application:
The Symfony application should now be running. Access it in your web browser at http://localhost. 

You can start developing your Symfony project!

Database Access
The PostgreSQL database is accessible through the database container. You can connect to it using your preferred PostgreSQL client with the following credentials:
```python
Host: localhost
Port: 5432
Database Name: symfony_crud
Username: symfony_crud
Password: password
```

pgAdmin Access
pgAdmin, a web-based PostgreSQL administration tool, is available at http://localhost:5050. 
Use the following credentials to log in:

```python
Email: your_email@example.com
Password: your_password
```

## Important Note
This .env file is for development purposes only. In a production environment, use proper environment variables and avoid storing production secrets in version control.
Enjoy working with your Symfony project using Docker containers! Happy coding!