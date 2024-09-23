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
bash
Copy code
git clone https://github.com/saikumar31/Patient-Management-System.git
2. Navigate to the project directory:
bash
Copy code
cd patient-management-system
3. Build the Docker containers:
bash
Copy code
docker-compose build
4. Start the containers:
bash
Copy code
docker-compose up
This will start the application, database, and all necessary services.

5. Run database migrations:
Once the Docker containers are up, you need to run the database migrations.

bash
Copy code
docker exec -it patient_management_app bash
php artisan migrate
6. Access the Application:
Open your browser and go to:

arduino
Copy code
http://localhost:8081
You should now see the Patient Management System running.

Usage

You can create new doctors, patients, and appointments using the web interface at localhost:8081.
To populate the database with sample data, refer to the next section on Database Seeding.

7.Database Seeding

If you'd like to populate the database with sample data (doctors, patients, appointments), you can run the following command:
bash
Copy code
docker exec -it patient_management_app bash
php artisan db:seed
This will insert demo data into the database.

8. MySQL Access

You can access mysql database from phpmyadmin
To access the MySQL database directly, go to:

bash
Copy code
http://localhost:8081/phpmyadmin
Username: root
Password: root
You can use this interface to manage the database or inspect tables directly.

9. Stopping and Removing Containers

To stop the running Docker containers:
Use Ctrl + C in the terminal where Docker is running.

10. To completely remove the Docker containers:
bash
Copy code
docker-compose down
This will stop and remove the containers, but the data will still persist unless volumes are explicitly removed.

License

This project is licensed under the MIT License. See the LICENSE file for details.

Contact

For any issues, feel free to reach out or open an issue on GitHub.

Notes:
Make sure Docker is running before executing the commands.
If you need to run additional Artisan commands, use docker exec -it patient_management_app bash to access the Laravel container.
