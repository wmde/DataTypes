# DataTypes

PHP library defining the DataTypes\DataType class of which instances represent a type of value,
such as "positive integer" or "percentage".

[![Build Status](https://secure.travis-ci.org/wmde/DataTypes.png?branch=master)](http://travis-ci.org/wmde/DataTypes)
[![Code Coverage](https://scrutinizer-ci.com/g/wmde/DataTypes/badges/coverage.png?s=81ca9034e898d0ff2ee603ffdcf07835c9b5f0d3)](https://scrutinizer-ci.com/g/wmde/DataTypes/)
[![Scrutinizer Quality Score](https://scrutinizer-ci.com/g/wmde/DataTypes/badges/quality-score.png?s=2405ce60c089e7454598ae50e235f001b68bd5cb)](https://scrutinizer-ci.com/g/wmde/DataTypes/)
[![Dependency Status](https://www.versioneye.com/php/data-values:data-types/dev-master/badge.png)](https://www.versioneye.com/php/data-values:data-types/dev-master)

On [Packagist](https://packagist.org/packages/data-values/data-types):
[![Latest Stable Version](https://poser.pugx.org/data-values/data-types/version.png)](https://packagist.org/packages/data-values/data-types)
[![Download count](https://poser.pugx.org/data-values/data-types/d/total.png)](https://packagist.org/packages/data-values/data-types)

## Installation

You can use [Composer](http://getcomposer.org/) to download and install
this package as well as its dependencies. Alternatively you can simply clone
the git repository and take care of loading yourself.

### Composer

To add this package as a local, per-project dependency to your project, simply add a
dependency on `data-values/data-types` to your project's `composer.json` file.
Here is a minimal example of a `composer.json` file that just defines a dependency on
DataTypes 0.1.0:

    {
        "require": {
            "data-values/data-types": "0.1.*"
        }
    }

### Manual

Get the DataTypes code, either via git, or some other means. Also get all dependencies.
You can find a list of the dependencies in the "require" section of the composer.json file.
Load all dependencies and the load the DataTypes library by including its entry point:
DataTypes.php.

## Tests

This library comes with a set up PHPUnit tests that cover all non-trivial code. You can run these
tests using the PHPUnit configuration file found in the root directory. The tests can also be run
via TravisCI, as a TravisCI configuration file is also provided in the root directory.

## Authors

DataTypes has been written by the Wikidata team at [Wikimedia Germany](https://wikimedia.de)
for the [Wikidata project](https://wikidata.org/).

## Release notes

### 0.2.1 (2014-05-06)

* migrate i18n to JSON
* run tests on PHP 5.6 and HHVM on travis

### 0.2 (2014-03-14)

#### Breaking changes

* dataTypes.DataType JavaScript object may not be initialized providing a dataValues.DataValue object anymore.
* Removed dataTypes.DataType.getLabel().
* Removed global DataType registration in the dataTypes object; DataTypeStore is to be used instead.
* Split up generic "dataTypes" ResourceLoader module into "dataTypes.DataType" and "dataTypes.DataTypeStore".

#### Enhancements

* Removed MediaWiki and DataValues dependencies from JavaScript code.
* Made code PSR-4 compliant
* Removed ResourceLoader dependency of QUnit tests.
* Implemented DataTypeStore.

### 0.1.1 (2013-12-23)

* Remove assumption about where the extension is installed in the resource loading paths.

### 0.1 (2013-12-15)

Initial release.

## Links

* [DataTypes on Packagist](https://packagist.org/packages/data-values/data-types)
* [DataTypes on Ohloh](https://www.ohloh.net/p/DataTypesPHP)
* [TravisCI build status](https://travis-ci.org/wmde/DataTypes)
* [DataTypes on ScrutinizerCI](https://scrutinizer-ci.com/g/wmde/DataTypes/)
