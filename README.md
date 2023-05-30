# How to start the project.
### 1. Install docker + docker-compose on your environment
- https://docs.docker.com/get-docker/
- https://docs.docker.com/compose/install/

### 2. bind the host to the local ip
- `   sudo echo "127.0.0.1  local.boxify.be" >> /etc/hosts`
- `   sudo echo "127.0.0.1 local.boxify.be" >> /etc/hosts`
- `   sudo echo "127.0.0.1 fr.local.boxify.be" >> /etc/hosts`
- `   sudo echo "127.0.0.1 nl.local.boxify.be" >> /etc/hosts`
- `   sudo echo "127.0.0.1 loc.boxify.be" >> /etc/hosts`
- `   sudo echo "127.0.0.1 fr.loc.boxify.be" >> /etc/hosts`
- `   sudo echo "127.0.0.1 nl.loc.boxify.be" >> /etc/hosts`

### 3. Import staging database
- Take stgaing databse export in sql format and name the file **boxify_demo.sql** (with help of admin or team lead)
- Create directory **dbimport** directly inside this project directory.
- Copy **boxify_demo.sql** file in to directory **dbimport**

### 4. Once docker is installed, you can run
- Run `docker-compose up -d` to start the projet (context directory is same as project directory)
- Run `docker-compose stop` to stop the projet (context directory is same as project directory)

### 5. Once docker containers are up. Import the database
- Run `docker exec -it web-app-v2-boxify-db-1 /bin/sh` to connect the terminal with mysql docker container
- Run `mysql -u root -p boxify_demo < /opt/boxify_demo.sql` to import the database. (It will ask for password. Enter `root` as a password)
- Run `exit` to exit from the mysql docker container.

### 6. Install composer by connecting to php docker container
- Run `docker exec -it web-app-v2-php-1 /bin/sh` to connect the terminal with php docker container.
- Run `composer install` to make sure all php depedencies are installed.
- Run `exit` to exit from the php docker container.

### 7. Navigate to webesite
- Open browser and hit the url `http://local.boxify.be/`

# FAQ.
### To access to the database locally
- You can access to the database locally with a logiciel like <a href="https://dbeaver.io/****">DBWEAVER</a>.
- You can also use MySQL Workbench to connect with database

###  help to switch from multiple version of php on linux os
- `sudo update-alternatives --config php`

### build the assets (run inside php docker container)
- `npm run production` for production
- `npm run dev` for dev
