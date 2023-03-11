<p align="center"><a href="https://demo.eazy.codes" target="_blank"><img src="https://github.com/PopovMaxim/PheonixEngine/blob/main/public/assets/media/logos/logo-short-white.png?raw=true" width="400" alt="Pheonix Engine"></a></p>

## About This Repo

(Important note! This script is distributed «as is» and will not be maintained. If you need completed 100% worked script (example: https://demo.eazy.codes), let me mail on: pmapkm@gmail.com)

This repository contains a script that allows you to run the MLM platform enchanted for sell Forex Experts and provides next features:

- User Registration (simple register or register by partner link)
- License server for Forex Experts (key generator and checker)
- Billing (Cryptocurrency refills)
- Telegram Bot Integration
- Transfer (Transfer Internal Currency between users)
- Transactions (Transaction history)
- Withdraw (Withdraw Internal Currency on TRC20 Crypto Wallet)
- Subscribe (subscribe on EA packages)
- Binary Tree
- Line Marketing (Any number of levels, by default: 10)
- Partners
- Leader pull
- Knowledge Base
- Education Center
- Customer Support
- Admin Panel
- Faq
- Notifications
- Packages

and other features...

## Requirements
- *nix os (e.g. ubuntu, centos or etc.)
- Nginx
- Composer
- NodeJs v.16^ & npm v.9^
- PostgreSQL 14^
- Supervisord

## Installation
1) clone this repo
2) composer install
3) npm install
4) php artisan storage:link
5) php artisan key:generate 
6) config .env file (config file below)
7) config supervisord (config file below)

#### .env file
Next props of environment must will be filled. Other parameters can be left unchanged.
```
APP_NAME=
APP_ENV=local
APP_KEY= // paste key stage 5 
APP_DEBUG=false
APP_URL=

QUEUE_CONNECTION=database
SESSION_DRIVER=database
SESSION_LIFETIME=120

LOG_CHANNEL=daily

DB_CONNECTION=pgsql
DB_HOST=127.0.0.1
DB_PORT=5432
DB_DATABASE=
DB_USERNAME=
DB_PASSWORD=
DB_SCHEMA=public

MAIL_MAILER=smtp
MAIL_HOST=
MAIL_PORT=25
MAIL_USERNAME=
MAIL_PASSWORD=
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=""
MAIL_FROM_NAME="${APP_NAME}"
```

#### Supervisord config
```
[program:pheonix-worker]
process_name=%(program_name)s_%(process_num)02d
command=php /path-to-pheonix/artisan queue:work --queue=mail --sleep=3 --tries=3 --max-time=3600
autostart=true
autorestart=true
stopasgroup=true
killasgroup=true
user=root
numprocs=8
redirect_stderr=true
stdout_logfile=/path-to-pheonix/storage/logs/worker.log
stopwaitsecs=3600
```
