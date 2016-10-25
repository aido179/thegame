#!/bin/bash
echo "Deploying..."
sudo git fetch origin
sudo git checkout master -f
sudo git merge origin/master
sudo php composer.phar install
echo "Deployment complete."
