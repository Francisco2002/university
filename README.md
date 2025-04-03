# University demo system

This project implements a simple university system to control the management of classes and registration

## Technologies
- Docker
    - create services for database and http server
- PostgresSQL
- Apache Server + PHP (with PDO to database connection)

## How to run
- make sure that you have Docker installed in your machine. You can follow the installation steps in documentation
    - on [MacOS](https://docs.docker.com/desktop/setup/install/mac-install/)
    - on [Windows](https://docs.docker.com/desktop/setup/install/windows-install/)
    - on [Linux](https://docs.docker.com/desktop/setup/install/linux/)
- create, in the root of project, a .env file with the variables shown in .env.example
- run the command `docker compose up --build`.
    - maybe you should run this command with sudo, if your user haven't permission to run docker
- access `http://localhost:8000` and see the initial interface

## Database init script
In `database/` directory, there is a `init.sql` file, that includes the definition of the tables in the database with initial tuples in some of them