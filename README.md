# Roby parser

Web resource parser.

## Services and Tools

- NGINX
- PHP 8.3
- Composer 2.7
- MySQL 8.0
- OctoberCMS

## Usage

### Commands

Start resource parsing:

```bash
docker exec -t roby-parser-php-fpm php artisan black-sea-digital.parse_resources
```

### Managing resources and pages

[http://localhost/admin/blackseadigital/parser/resources](http://localhost/admin/blackseadigital/parser/resources)

### .env configuration

Number of parallel processes for web resource parsing:

```angular2html
PARSER_QUEUE_PROCESSES=15
```

Number of retries to parse the resource if an error occurs:

```angular2html
PARSER_REQUEST_RETRIES=3
```

Minimum number of characters that page content can contain:

```angular2html
PARSER_MIN_PAGE_CONTENT_SIZE=100
```

## Quick Start Installation

**Step 1.** Install [Docker, Docker Compose](https://www.docker.com/products/docker-desktop/).

**Step 2.** Clone the repository of project.

**Step 3.** Create a `.env` file based on `.env.example` and set up the environment variables:

```bash
cp .env.example .env
```

**Step 4.** Set your **UID** and **GID** in the `.env` file (By default these values are set to **1000**).


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

**Step 5.** Run the containers:

```bash
docker-compose up -d
```

This will run all the services described in `docker-compose.yml` in the background.

**Step 6.** Run project installation:

```bash
docker exec -t roby-parser-php-fpm composer project.install
```

This will run composer install, DB migrations, IDE helper, etc.

**Step 7.** Open the application in your browser:

Application URL - [http://localhost](http://localhost)

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
