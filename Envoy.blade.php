@servers(['prod' => ['gitlab_deploy@129.16.220.7'],  'staging' => ['gitlab_deploy@129.16.220.7']])

@task('prod-deploy', ['on' => 'prod'])
    cd hdweb
    docker login -u "{{$docker_user}}" -p "{{$docker_password}}" {{$docker_registry}}
    docker-compose pull
    docker-compose down hd
    docker-compose up hd -d
    docker-compose exec -T hd php artisan optimize
    docker-compose exec -T hd php artisan migrate --force
@endtask

@task('staging-deploy', ['on' => 'staging'])
    cd hdweb-staging
    docker login -u "{{$docker_user}}" -p "{{$docker_password}}" {{$docker_registry}}
    docker-compose pull
    docker-compose down
    docker-compose up -d
    docker-compose exec -T hd php artisan optimize
    docker-compose exec -T hd php artisan migrate:fresh --force --seed
@endtask
