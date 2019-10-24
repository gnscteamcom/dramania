#!/bin/bash

# alter table automation
# change the column type of 'REBUTTALS.ID' & 'REBUTTAL_IMPORT_FILES.ID' from INTEGER to
# 'REBUTTALS.ID' & 'REBUTTAL_IMPORT_FILES.ID type VARBINARY

# USAGE
# ./alter_table user pass database

user=$1
pass=$2
database=$3

mysql -u $1 -p$2 -D $3 -s -e "ALTER TABLE dramas MODIFY id varbinary(32)"
# mysql -u $1 -p$2 -D $3 -s -e "ALTER TABLE movies MODIFY id varbinary(32)"
mysql -u $1 -p$2 -D $3 -s -e "ALTER TABLE drama_tags MODIFY drama_id varbinary(32)"
mysql -u $1 -p$2 -D $3 -s -e "ALTER TABLE drama_tags ADD FOREIGN KEY (drama_id) REFERENCES dramas(id)"

echo "done!"
