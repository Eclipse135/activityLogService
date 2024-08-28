# ActivityLogService on Symfony

This repo is for personal use only and contains a test task - ActivityLogService, on Symfony 7 framework

![Fancy image, cuz I can :3](https://i.imgur.com/u2Vmoe3.png)

## Information:
ActivityLogService uses Strategy Pattern approach.

in the Service\ActivityLogService\Types directory you can find 3 example classes:
- AdminEditedProduct;
- GrantProductToUserViaAdminPanel;
- UserBuysProduct;

All those classes implement ActivityLogInterface

## Usage:

The main logic consists in passing as first parameter any class that implements ActivityLogInterface
```php
$activityLog->logActivity(ActivityLogInterface $activityLogClass, array $data);
```

Real examples:
```php
$activityLogService->logActivity(new GrantProductToUserViaAdminPanel(), [...]);
$activityLogService->logActivity(new AdminEditedProduct(), [...]);
$activityLogService->logActivity(new UserBuysProduct(), [...]);
```

To get the type title use:
```php
$activityLog->getActivityType(ActivityLog $activityLog)
```

To get the message use:
```php
$activityLog->getActivityMessage(ActivityLog $activityLog)
```

## Extension:
In order to extend the functionality of ActivityLogService, implement ActivityLogInterface and it's stubs
Then just pass this class as first parameter to ActivityLog's logActivity method.


## Installation

1. Clone the repository
```
git clone git@github.com:Eclipse135/activityLogService.git .
```
2. Install dependencies
```
composer install
```
3. Configure your database in `.env` or run the one from docker compose
```
docker compose up -d database
```
if you will use the docker, then assure that you configure the right port for database, since it's dynamic.
To find the port run
```
docker ps
```
Or if you already have symfony-cli installed on your system, then just use 
```
symfony console ...
```
instead of
```
php bin/console ...
```

You can find how to install symfony console here:
https://github.com/symfony-cli/symfony-cli

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
7. Serve the project using Symfony CLI
```
symfony serve
```

