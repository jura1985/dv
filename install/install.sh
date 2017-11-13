#!/usr/bin/env bash

title() {
    local color='\033[1;37m'
    local nc='\033[0m'
    printf "\n${color}$1${nc}\n"
}

title "Unzip secure config files if you dont know the password ask someone form the organisation"
unzip /var/www/dv/docroot/profiles/dv/modules/dv_features/dv_secure/config/install/yml.zip /var/www/dv/docroot/profiles/dv/modules/dv_features/dv_secure/config/install/

title "Install Ansible"
sudo apt-get install software-properties-common -y
sudo apt-add-repository ppa:ansible/ansible -y
if [ -f /etc/apt/sources.list.d/ansible-ansible-jessie.list ]; then
    sudo sed -i 's/jessie/trusty/g' /etc/apt/sources.list.d/ansible-ansible-jessie.list
fi
sudo apt-get update
sudo apt-get install ansible -y

title "Get Ansible roles"
ansible-galaxy install -r requirements.yml

title "Provision playbook for $(whoami)"
ansible-playbook -i "localhost" -c local playbook.yml

title "Run Composer Install"
composer install --no-interaction

title "Remove PHP used only for Composer setup"
sudo apt-get remove -y --purge php*
sudo rm /etc/php -R

title "Provision server playbook"
cd /var/www/dv/
ansible-playbook playbook.yml

cd /var/www/dv/
touch blt/project.local.yml
echo "environment: local" >> blt/project.local.yml
vednor/bin/blt custom:reinstall


