#!/bin/bash

set -e

install() {
    sudo -u www-data composer install
}

tests() {
#    php vendor/bin/phpunit -c /src/
    echo "Dummy testing"
}

run() {
    /usr/local/bin/docker-php-entrypoint
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
    docker-php-entrypoint
    ;;
*)
    echo "Custom command : $@"
    exec "$@"
    ;;
esac
