PROJECT_DIR="/opt/gm-exchange-api-stage" # absolute path to project
GIT_BRANCH="dev" # branch to pull source from

cd $PROJECT_DIR;

CURRENT_DIR=$(pwd)

echo Fetching last state from branch $GIT_BRANCH...
git fetch origin &&
git reset --hard origin/$GIT_BRANCH

docker-compose up -d --build

docker-compose exec fpm php artisan cache:clear
docker-compose exec fpm php artisan config:cache
docker-compose exec fpm php artisan route:cache

docker-compose exec fpm php artisan migrate:status
docker-compose exec fpm php artisan migrate
