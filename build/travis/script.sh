#! /bin/bash

set -x

if [ "$QUNIT" == true ]; then

cd js/lib/TestRunner
phantomjs runTests.phantom.js ../../../tests/qunit/runTests.html

else

phpunit

fi