Built using php 8.1, mysql 8.0, docker and composer. Developed for Ubuntu runnign on WSL2. Uses a forked version of the 'codeguy/upload' simple filehandling composer package.

CLI instructions:

docker-compose build  

docker-compose up -d

docker network inspect naturalhr_app-net

docker exec -it naturalhr_app-net bash

sudo chmod -R a+rwx storage

composer require codeguy/upload:dev-master 
