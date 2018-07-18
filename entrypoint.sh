#!/usr/bin/env bash

set -e

install() {
    sudo -u www-data composer install
    sudo -u www-data php bin/console assets:install
}

tests() {
    php vendor/bin/phpunit -c /src/
}

run() {
    docker-php-entrypoint
}

case "$1" in
"install")
    echo "Install"
    install
    ;;
"tests")
    echo "Tests"
    tests
    ;;
"run")
    echo "Run"
    run
    ;;
*)
    echo "Custom command : $@"
    exec "$@"
    ;;
esac
