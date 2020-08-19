@servers(['prod' => ['gitlab_deploy@129.16.220.7'],  'staging' => ['gitlab_deploy@129.16.220.7']])

@task('prod-deploy', ['on' => 'prod'])
    cd hdweb
    docker login -u "{{$docker_user}}" -p "{{$docker_password}}" {{$docker_registry}}
    docker-compose pull
    docker-compose up -d
    docker-compose exec -T hd php artisan storage:link && docker-compose exec -T hd php artisan optimize && docker-compose exec -T hd php artisan migrate --force;
    echo "Done"
@endtask

@task('staging-deploy', ['on' => 'staging'])
    cd hdweb-staging
    docker login -u "{{$docker_user}}" -p "{{$docker_password}}" {{$docker_registry}}
    docker-compose pull
    docker-compose up -d
    docker-compose exec -T hd php artisan storage:link;
    docker-compose exec -T hd php artisan optimize;
    docker-compose exec -T hd php artisan migrate:fresh --force --seed;
    echo "Done"
@endtask
