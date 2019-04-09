#!/bin/sh -l

sh -c "composer cs-fixer --dry-run"
sh -c "composer phpstan"
