#!/bin/bash
cd ~/Projects/chippyash/source/phpunit-coverage-listener
vendor/phpunit/phpunit/phpunit -c phpunit.dev.xml --testdox-html contract.html test/
tdconv -t "Chippyash PHPUnit Coverage Listener" contract.html docs/Test-Contract.md
rm contract.html

