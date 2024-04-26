# Roby parser

## Services and Tools

- NGINX
- PHP 8.3
- Composer 2.7
- MySQL 8.0
- OctoberCMS

## Requirements

- [Docker, Docker Compose](https://www.docker.com/products/docker-desktop/)

## Quick Start Installation

**Step 1.** Clone the repository of project.

**Step 2.** Create a `.env` file based on `.env.example` and set up the environment variables:

```bash
cp .env.example .env
```

**Step 3.** Set your **UID** and **GID** in the `.env` file (By default these values are set to **1000**).


You can find out your **UID** and **GID** on **Linux** and **macOS** using the following commands:

 ```bash
id -u
```

```bash
id -g
```

You can find out your **UID** and **GID** on **Windows** using the following commands:

```bash
whoami /user
```

```bash
whoami /groups
```

**Step 4.** Run the containers:

```bash
docker-compose up -d
```

This will run all the services described in `docker-compose.yml` in the background.

**Step 5.** Run project installation:

```bash
docker exec -t roby-parser-php-fpm composer project.install
```

This will run composer install, DB migrations, IDE helper, etc.

**Step 6.** Open the application in your browser:

Application URL - [http://localhost](http://localhost)

Email trap URL - [http://localhost:8025](http://localhost:8025)

## Running and Stopping the Project

After the [quick start installation](#Quick-Start-Installation), you can start and stop the project with the following commands.

Run the containers:

```bash
docker-compose up -d
```

Stop the containers:

```bash
docker-compose down
```

## Additional Commands

Code fix:

```bash
docker exec -t roby-parser-php-fpm composer code.fix
```

Code analysis:

```bash
docker exec -t roby-parser-php-fpm composer code.analyse
```

Code fix and analysis:

```bash
docker exec -t roby-parser-php-fpm composer code.debug
```
