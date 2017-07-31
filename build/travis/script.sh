#! /bin/bash

set -x

if [ "$QUNIT" == true ]; then

cd js/lib/TestRunner
phantomjs runTests.phantom.js ../../../tests/qunit/runTests.html
cd -

fi

composer ci
./node_modules/.bin/eslint .
