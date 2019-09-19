#!/bin/bash

# alter table automation
# change the column type of 'REBUTTALS.ID' & 'REBUTTAL_IMPORT_FILES.ID' from INTEGER to
# 'REBUTTALS.ID' & 'REBUTTAL_IMPORT_FILES.ID type VARBINARY

# USAGE
# ./alter_table user pass database

user=$1
pass=$2
database=$3

mysql -u $1 -p$2 -D $3 -s -e "DELETE t1 FROM genres t1 INNER JOIN genres t2 WHERE t1.id < t2.id AND t1.genre_name = t2.genre_name "


echo "done!"