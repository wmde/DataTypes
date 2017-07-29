#! /bin/bash

set -x

if [ "$QUNIT" == true ]; then

cd js/lib/TestRunner
phantomjs runTests.phantom.js ../../../tests/qunit/runTests.html
cd ../../..
else

php phpunit-4.8.phar

fi

./node_modules/.bin/eslint .
