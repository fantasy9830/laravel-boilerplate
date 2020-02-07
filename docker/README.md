# Docker

## Install Docker Engine - Community

<https://docs.docker.com/install/linux/docker-ce/ubuntu/>

## Add your user to the docker group

```bash
sudo usermod -aG docker $(whoami)
```

## Install Docker Compose

<https://docs.docker.com/compose/install/>

## Run

```bash
docker-compose up -d mysql nginx php www
```
