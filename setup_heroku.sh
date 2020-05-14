#!/bin/bash

sudo yum groupinstall "Development Tools" –y
mkdir -p /home/ec2-user/lib
cd /home/ec2-user/lib
wget https://cli-assets.heroku.com/heroku-linux-x64.tar.gz
tar -xzf heroku-linux-x64.tar.gz
rm heroku-linux-x64.tar.gz
sudo ln -s /home/ec2-user/lib/heroku/bin/heroku /usr/bin/heroku
cd $HOME/environment

heroku --version

heroku login -i

sudo yum install postgresql-server postgresql-contrib -y