export POSTGRES_DB=ridecome_database
export POSTGRES_PORT=5434
export ENV_MODE=dev
rm -rf ./docker-postgresql-data-for-${ENV_MODE}
docker-compose -f ./docker-compose-postgresql.yml down --volumes
docker-compose -f ./docker-compose-postgresql.yml down --remove-orphans
docker-compose -f ./docker-compose-postgresql.yml up