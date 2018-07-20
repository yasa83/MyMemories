mysql> CREATE TABLE picture
    ->(
    ->id INT(11) NOT NULL AUTO_INCREMENT PRI,
    ->title VARCHAR(255) NOT NULL utf8_general_ci,
    ->date datetime NOT NULL,
    ->detail text NOT NULL,
    ->img_name VARCHAR(255),
    ->);
    Query OK,0 rows affected (0.02 sec)
    mysql>