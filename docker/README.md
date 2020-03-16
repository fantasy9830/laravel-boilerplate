# Docker

## Install Docker Engine - Community

<https://docs.docker.com/install/linux/docker-ce/ubuntu/>

## Add your user to the docker group

```bash
sudo usermod -aG docker $(whoami)
```

## Install Docker Compose

<https://docs.docker.com/compose/install/>

## Recovery .env

```bash
cp .env.example .env

cp mysql/createdb.sql.example mysql/createdb.sql
```

## Run

```bash
docker-compose up -d mysql nginx php www
```

### Enter your container

```bash
docker-compose exec www bash
```
