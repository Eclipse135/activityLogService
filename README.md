# ActivityLogService on Symfony

This repo is for personal use only and contains a test task - ActivityLogService, on Symfony 7 framework


## Installation

1. Clone the repository
```
git clone git@github.com:Eclipse135/activityLogService.git .
```
2. Install dependencies
```
composer install
```
3. Configure your database in `.env`
4. Create database (not necessary if already exist)
```
php bin/console doctrine:database:create
```
5. Run migrations
```
php bin/console doctrine:migrations:migrate
```
6. Load fixtures
```
php bin/console doctrine:fixtures:load
```

