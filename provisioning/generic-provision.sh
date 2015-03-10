#!/bin/bash
sudo apt-get -y install software-properties-common
sudo apt-add-repository -y ppa:ansible/ansible
sudo apt-get update
sudo apt-get -y install ansible
sudo ansible-galaxy install nbz4live.php-fpm jdauphant.nginx
cd /home/vagrant/$1/provisioning
ansible-playbook -i inventory/dev --connection=local devservers.yml
