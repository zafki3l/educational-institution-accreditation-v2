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
DOCKER_GID=1000 # Run `id -g` to get your group id
DOCKER_UID=1000 # Run `id -u` to get your user id
```

4. Docker compose up
```bash
docker compose up -d --build
```

5. Enter application container
```bash
docker compose exec app sh
```
You should see:
```bash
/var/www/html $
```


6. Run 'composer install' to install dependencies
```bash
composer install
```

7. Run 'composer migrate' to create database
```bash
composer migrate
```

After setup, open your browser:
```bash 
http://localhost
```