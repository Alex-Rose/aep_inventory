# aep_inventory
Inventory management website

## Kohana deployment
There are three files to edit in order to get this repo online.
* application/bootstrap.php
* application/config/database.php
* .htaccess

### Database
An empty database is included in this repository. It should be removed or made inaccessible before going online.
The config file (application/config/database.php) should reflect your environment.

### .htaccess
This file is used to redirect requests to index.php with parameters. If your website is not under www.domain.com, the RewriteBase should be set to whichever directory it lives in. For example if the root of the website is in http://step.polymtl.ca/~services/biere:
```htaccess
RewriteBase /~services/biere
```

### Bootstrap.php
This contains the core settings for Kohana framework. Here are somme common options to be toyed with :
* Timezone
* Locale
* Cookie salt
* Kohana environment (dev, test, prod)

You must also change the parameter _base_url_ in _Kohana::init_

## Developing
Here are a few tricks to help developing more efficiently

### Keeping a development environment up and running
A development environment should be completely distinct from the production website itself. It should also have its own database.

### Working with git
I would recommend the use of scripts to hide your local changes in the three config files since they should only reflect your development environment and not the production environment. For example, I use these before and after commiting :

*prepare_commit.sh*
```bash
#!/bin/bash

if [ -f .commit_state ]; then
    echo "Already in commit state!"
    exit 1
fi

touch .commit_state
rm -f .dev_state

cp -f .htaccess .htaccess.bak
cp -f application/bootstrap.php application/bootstrap.php.bak
cp -f application/config/database.php application/config/database.php.bak

git add application/classes/*
git add application/views/*
git add assets/*

git checkout .htaccess
git checkout application/bootstrap.php
git checkout application/config/database.php
```

*replace_commit.sh*
```bash
#!/bin/bash

if [ -f .dev_state ]; then
    echo "Already in dev state!"
    exit 1
fi

touch .dev_state
rm -f .commit_state

rm -f .htaccess
rm -f application/bootstrap.php
rm -f application/config/database.php

mv .htaccess.bak .htaccess
mv application/bootstrap.php.bak application/bootstrap.php
mv application/config/database.php.bak application/config/database.php
```

## Kohana Framework deprecated
As of 2017, Kohana is a deprecated PHP framework and the latest version 3.3.6 was released on 25. July 2016.
This application was built on **Kohana 3.3.3** and since the development is done, it makes perfect sense to 
keep Kohana as is. Servicing and further enhancements can still be done on this application for as long as
PHP5 stays around. I took the liberty of making a copy of the Kohana documentation for version 3.3.3, which can be
found here : http://step.polymtl.ca/~alexrose/kohana_doc/v2docs.kohanaframework.org/3.3/guide/. This should be
more than enough to continue development, but the framework's source code is always available for reading and
patching.

Farewell, Kohana
