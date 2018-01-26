# Marketplace Mock
Built in Symfony 3
## Installation
Clone repository
### Install dependencies
`php composer.phar install`
### Add Configuration

Create config/parameters.yml and set DB & Fb api params

### Create database
`php bin/console doctrine:database:create`
### Update database with entitites
`php bin/console doctrine:schema:update --force`
### Go to
`localhost:8000/`
