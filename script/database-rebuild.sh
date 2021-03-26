#!/bin/bash
bin/console doctrine:schema:drop --full-database --force --env=test
bin/console doctrine:schema:create --no-interaction --env=test
bin/console doctrine:fixtures:load --no-interaction --env=test