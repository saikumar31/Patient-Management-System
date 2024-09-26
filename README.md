# Patient-Management-System

A PHP-Laravel-based Patient Management System that allows for managing doctors, patients, and appointments. This system is Dockerized for easy setup and deployment, ensuring a consistent development environment.

Tech Stack:
  Backend: PHP 8.2 (Laravel Framework)
  Frontend: Blade, Bootstrap 5
  Database: MySQL 5.7
  Containerization: Docker, Docker Compose
  Other Tools: Composer, Artisan CLI
Features:
  Manage Doctors, Patients, and Appointments
  Appointment scheduling with conflict handling for doctors
  Search functionality for doctors and patients
  Real-time CRUD operations
  Dockerized environment for simplified setup
  Database seeding for quick setup of demo data
  
Prerequisites:
  Ensure you have the following installed on your system:
  Docker
  Docker Compose
  Installation and Setup

Follow the steps below to set up and run the project locally using Docker.

1. Clone the repository:
`git clone https://github.com/saikumar31/Patient-Management-System.git`

2. Navigate to the project directory:
`cd patient-management-system`

4. Build the Docker containers:
docker-compose build

6. Start the containers:
`docker-compose up`
This will start the application, database, and all necessary services.

7. Run database migrations:
Once the Docker containers are up, you need to run the database migrations.
`docker exec -it patient_management_app bash` and then 
`php artisan migrate`

8. Access the Application:
Open your browser and go to:
`http://localhost:8001`
You should now see the Patient Management System running.

9.Usage:
  You can create new doctors, patients, and appointments using the web interface at localhost:8081.
  To populate the database with sample data, refer to the next section on Database Seeding.

10.Database Seeding
  If you'd like to populate the database with sample data (doctors, patients, appointments), you can run the following command:
  `docker exec -it patient_management_app bash`
  `php artisan db:seed`
  This will insert demo data into the database.

11. MySQL Access
  You can access mysql database from phpmyadmin
  To access the MySQL database directly, go to:
  `http://localhost:8081/phpmyadmin`
  Username: root
  Password: root
  You can use this interface to manage the database or inspect tables directly.

12. Stopping and Removing Containers
  To stop the running Docker containers:
  Use Ctrl + C in the terminal where Docker is running.

13. To completely remove the Docker containers:
  `docker-compose down`
  This will stop and remove the containers, but the data will still persist unless volumes are explicitly removed.

Notes:
Make sure Docker is running before executing the commands.
If you need to run additional Artisan commands, use docker exec -it patient_management_app bash to access the Laravel container.
