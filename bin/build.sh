#!/bin/sh
echo "***********************************************"
echo "* STARTS: service apache2                     *"
service apache2 restart
echo "* RUNS: service apache2                       *"
echo "***********************************************"
cd /home/project
echo "* STARTS composer install                     *"
composer install
echo "* ENDS: composer install                      *"
echo "***********************************************"
chmod -R 777 storage
chmod -R 777 bootstrap/cache
echo "* STARTS: npm install                         *"
npm install
echo "*                DONE                         *"
echo "***********************************************"
echo "* STARTS: npm run prod                        *"
npm run prod
echo "*                DONE                         *"
echo "***********************************************"
tail -f /dev/null