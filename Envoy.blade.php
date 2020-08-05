@servers(['prod' => ['gitlab_deploy@'.$host],  'staging' => ['gitlab_deploy@'.$host]])
@include('web/vendor/autoload.php')

@task('prod-deploy', ['on' => 'prod'])
    cd hdweb
    docker login -u "{{$docker_user}}" -p "{{$docker_password}}" {{$docker_registry}}
    docker-compose pull
    docker-compose down hd
    docker-compose up hd
    docker-compose exec hd php artisan optimize:clear
    docker-compose exec hd php artisan optimize
    docker-compose exec hd php artisan migrate --force
@endtask

@task('staging-deploy', ['on' => 'staging'])
    cd hdweb-staging
    docker login -u "{{$docker_user}}" -p "{{$docker_password}}" {{$docker_registry}}
    docker-compose pull
    docker-compose down
    docker-compose up
    docker-compose exec hd php artisan optimize:clear
    docker-compose exec hd php artisan optimize
    docker-compose exec hd php artisan migrate:fresh --force --seed
@endtask