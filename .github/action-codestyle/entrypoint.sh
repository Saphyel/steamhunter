#!/bin/sh -l

sh -c "composer install"
sh -c "composer cs-checker"
sh -c "bin/phpunit"
sh -c "composer phpstan"
