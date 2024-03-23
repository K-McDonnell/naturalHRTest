Built using php 8.1, mysql 8.0, docker and composer.

cli instructions
docker-compose build  

docker-compose up -d

docker network inspect naturalhr_app-net

docker exec -it naturalhr_app-net bash

sudo chmod -R a+rwx storage

composer require codeguy/upload:dev-master 
