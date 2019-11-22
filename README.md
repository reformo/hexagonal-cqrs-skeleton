# WORK IN PROGRESS
# Hexagonal (Ports and Adapters) Architecture and CQRS Ready Zend Expressive Skeleton.


An opinionated framework to develop CQRS applications using hexagonal architecture structure.

### Built on basically these libraries:
- Zend Expressive (Zend ServiceManager, FastRoute, Twig)
- Tactician CommandBus by thephpleague.com
- Doctrine DBAL
- Symfony Console


### Coding standard
[Doctrine Coding Standart](https://github.com/doctrine/coding-standard) is used

## Installation
```bash
composer create-project reformo/hexagonal-cqrs-skeleton MyApplication
```

## Development Server

### FrontWeb

```bash
composer run --timeout=0 start-frontweb
```

### PrivateApi

```bash
composer run --timeout=0 start-private-api
```


## Production Server using Swoole
### FrontWeb
Since Swoole has problems with native PHP sessions, FrontWeb will give 500 Server Error until we fixed it.
```bash
bin/zend-expressive-swoole start --module FrontWeb
```
### PrivateApi
```bash
bin/zend-expressive-swoole start --module PrivateApi
```