#!/bin/bash
echo "Deploying..."
sudo git fetch origin
sudo git checkout master -f
sudo git merge origin/master
echo "Deployment complete."
