user=$1
pass=$2
database=$3

echo "migration:refresh"
php artisan migrate:refresh
sleep 1
echo "db:seed"
php artisan db:seed 
sleep 1
echo "alter table"
sh alter_table.sh $1 $2 $3