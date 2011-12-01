Introduction
============

Uses cases:

* Migrate data between two databases.
* Aggregate data
* Import a CSV or an Excel file to the database and validate each rows.

[![Build Status](https://secure.travis-ci.org/GromNaN/Angetl.png)](http://travis-ci.org/GromNaN/Angetl)

Readers
-------

* CSV
* Pdo (database)
* Qif (bank accounts)
* RSS
* XML

Filters
-------

* Closure: Apply any function to each record to modify it
* Map: Rename and aggregate fields
* Unique: Ensure records are uniques
* Validation: Validate records using Symfony2 validator


Writers
-------

* CSV
* ... Others to come



Credits
-------

* Jérôme Tamarelle <jerome@tamarelle.net>

License
-------

Angetl is released under the MIT License. See the bundled LICENSE file for details.
