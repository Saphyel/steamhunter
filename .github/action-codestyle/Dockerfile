FROM saphyel/php:latest

LABEL "com.github.actions.name"="Check code style"
LABEL "com.github.actions.description"="Run CS-Fixer and PHPStan to find code smells"
LABEL "com.github.actions.icon"="mic"
LABEL "com.github.actions.color"="purple"

RUN composer install

ADD entrypoint.sh /entrypoint.sh
ENTRYPOINT ["/entrypoint.sh"]