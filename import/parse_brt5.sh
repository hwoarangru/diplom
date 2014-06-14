#!/bin/bash

I='NextStep'
while [ "$I" = 'NextStep' ]
do
	I=`/usr/bin/php /adv/vhosts/www.bmw-autokraft.ru/htdocs/import/parse_brt5.php`
done