# Maintenance #

## Find and Optimize Fragmented Tables ##

```
SELECT TABLE_NAME,Data_free
  FROM information_schema.TABLES
 WHERE TABLE_SCHEMA NOT IN ('information_schema','mysql')
  AND Data_free > 0;
```
```
OPTIMIZE TABLE %TABLENAME%
```

# mysqlcheck #

```
mysqlcheck -r your_database
```
```
mysqlcheck -o your_database
```

# Data Rows Check #

```
mysqldump -t --comment=FALSE --skip-opt db_anme table_name | grep 'INSERT INTO' | awk 'END {print NR}'
```