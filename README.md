![Homepage](docs/images/homepage.png)


1. Clone repository

```bash
git clone https://github.com/zafki3l/Educational-Institution-Accreditation-v2.git
cd Educational-Institution-Accreditation-v2
```

2. Copy .env file

```bash
cp .env.example .env
```

3. Setup enviroment variables
```bash
MYSQL_HOST='db' # Docker service name
MYSQL_USER='user' # Your user
MYSQL_PASSWORD='secret' # Your password
MYSQL_DATABASE='educational_institution_accreditation' # Your database
MYSQL_PORT=3306 # Your port

MONGO_PORT=27017 # Default MongoDB port
MONGO_COLLECTION='logs' # Your mongo collection
MONGO_DATABASE='app_logs' # Your mongo database
DOCKER_GID=YOUR_GID # Run `id -g` to get your group id
DOCKER_UID=YOUR_UID # Run `id -u` to get your user id
```

4. Docker compose up
```bash
docker compose up -d --build
```


5. Run 'composer install' to install dependencies
```bash
docker compose exec app composer install
```

6. Run 'composer migrate' to create database
```bash
docker compose exec app composer migrate
```

After setup, open your browser:
```bash 
http://localhost
```