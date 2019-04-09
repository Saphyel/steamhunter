#!/bin/sh -l

sh -c "composer install"
sh -c "composer cs-fixer --dry-run"
sh -c "composer phpstan"
