Jodn14 projekt Ramverk1
==================================

Code and build Status (Tavis-ci and Scrutinizer)
----------------------------------
[![Build Status](https://travis-ci.com/lindhjonathan/projekt.svg?branch=master)](https://travis-ci.com/lindhjonathan/projekt)

[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/lindhjonathan/projekt/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/lindhjonathan/projekt/?branch=master)
[![Build Status](https://scrutinizer-ci.com/g/lindhjonathan/projekt/badges/build.png?b=master)](https://scrutinizer-ci.com/g/lindhjonathan/projekt/build-status/master)
[![Code Intelligence Status](https://scrutinizer-ci.com/g/lindhjonathan/projekt/badges/code-intelligence.svg?b=master)](https://scrutinizer-ci.com/code-intelligence)

Table of content
------------------------------------

 * [Install and setup](#Install-and-setup-Database)
 * [Dependency](#Dependency)
 * [License](#License)

Install and setup Database
------------------------------------
Clone the existing GitHub repo by copying the following command into your terminal.

```bash
git clone https://github.com/lindhjonathan/projekt jodn14projekt

cd jodn14projekt
```

Install dependencies with composer.

```bash
composer install
```

Now to create and add tables to the database.

```bash
mkdir data
touch data/db.sqlite
chmod 777 data/*

sqlite3 data/db.sqlite < sql/ddl/setup_sqlite.sql
```
Now point your webserver to jodn14projekt/htdocs and may I suggest you start your
lookaround by creating a new user.

Dependency
------------------

This application is an implementation of the Anax framework.
It should not require any dependencies other than those specified in the composer.json.

License
------------------
[![License](https://poser.pugx.org/jodn14/weather/license)](https://packagist.org/packages/jodn14/weather)
This software carries a MIT license. See [LICENSE.txt](LICENSE.txt) for details.

```
 .  
..:  Copyright (c) 2018 Jonathan Lindh (lindh.jonathan@gmail.com)
```
