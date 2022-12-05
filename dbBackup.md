## create back-up

`mysqldump -u root -p database_name table_name > dump.txt`

## import back-up

Create database database_name

`mysql -u root -p database_name < dump.txt`