# User maintenance CRUD Project

Basic API to interact with users information.

This project is based on fake data.

For demo purposes you can login into de app with these credentials

Email: test@demo.com
Password: password

## Browser Support

![Chrome](https://raw.github.com/alrra/browser-logos/master/src/chrome/chrome_48x48.png)
Latest ✔

## Dependencies

You must have installed composer and docker on their latest versions

https://getcomposer.org/

https://www.docker.com/get-started

## How to use

Copy .env.example file to .env

```bash
cp .env.example .env
```

Run:

```bash
composer install
```

```bash
./vendor/bin/sail up -d
```

```bash
./vendor/bin/sail artisan key:generate
```

```bash
./vendor/bin/sail artisan migrate:fresh --seed
```

or

```bash
./vendor/bin/sail artisan migrate --seed
```

#### Base URL

http://localhost
