# Simple-File-Uploader (under development)

1. execute database.sql (after install mysql)

2. add the database connections in scripts/db.php

3. in php.ini file, uncomments the two lines:

extension=pdo_mysql

extension_dir = "ext"

4. from the project root run:

php -S localhost:8000