#!/bin/bash

# alter table automation
# change the column type of 'REBUTTALS.ID' & 'REBUTTAL_IMPORT_FILES.ID' from INTEGER to
# 'REBUTTALS.ID' & 'REBUTTAL_IMPORT_FILES.ID type VARBINARY

# USAGE
# ./alter_table user pass database

user=$1
pass=$2
database=$3

# mysql -u $1 -p$2 -D $3 -s -e "ALTER TABLE genres MODIFY uid varbinary(32) NOT NULL"
# mysql -u $1 -p$2 -D $3 -s -e "ALTER TABLE manga_genres MODIFY uid varbinary(32) NOT NULL"
# mysql -u $1 -p$2 -D $3 -s -e "ALTER TABLE manga_genres MODIFY genre_uid varbinary(32) NOT NULL"
mysql -u $1 -p$2 -D $3 -s -e "ALTER TABLE dramas MODIFY id varbinary(32)"
# mysql -u $1 -p$2 -D $3 -s -e "ALTER TABLE manga_genres MODIFY manga_id varbinary(32) NOT NULL"
# mysql -u $1 -p$2 -D $3 -s -e "ALTER TABLE manga_genres ADD FOREIGN KEY (manga_id) REFERENCES mangas(id)"

# mysql -u $1 -p$2 -D $3 -s -e "ALTER TABLE manga_chapters MODIFY manga_id varbinary(32) NOT NULL"
# mysql -u $1 -p$2 -D $3 -s -e "ALTER TABLE manga_chapters ADD FOREIGN KEY (manga_id) REFERENCES mangas(id)"


echo "done!"
