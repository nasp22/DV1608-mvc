Get going Laminas Mezzio
====================

Documentation

* https://github.com/mezzio/mezzio
* https://docs.mezzio.dev/mezzio/



Install it
-----------------------

Install using composer create project into the directory `app`.

Use Plates as a template engine when the installation program asks you to, othervise you will get a more pure REST server which serves JSON responses.

```
composer create-project mezzio/mezzio-skeleton app
ls app
```

You can open the PHP built in webserver to verify the installation.

```
php -S localhost:8080 -t app/public
```



Make it run in your Apache locally
-----------------------

Needs extra configuration to run in a sub directory.

Needs to be further investigated.
https://github.com/mezzio/mezzio/issues/69



Make it run on the student server
-----------------------

Not tested.



Implement views, routes and controllers
-----------------------

Not tested.



Problem
-----------------------

The installation did not complete due to isses above.
