#!/bin/bash
# Deployment steps for a Wordpress site. Should be run on each deployment.
# Usage: ./deploy.sh <environment>
# environment is one of: local, dev, staging, live.
ENV=$1
REPO_ROOT=`pwd`
PARENT_DIR=`dirname $REPO_ROOT`

VAGRANT_CORE_FOLDER="/vagrant"

if [[ -f "$REPO_ROOT/public/$ENV.wp-config.php" ]]; then
  if [[ ! -f "$REPO_ROOT/public/wp-config.php" || -w "$REPO_ROOT/public/wp-config.php" ]]; then
    echo 'Copying wp-config file'
    cd $REPO_ROOT/public && cp $ENV.wp-config.php wp-config.php >/dev/null
  fi
fi

echo 'Creating and simlinking uploads directory' 
if [[ ! -d $PARENT_DIR/common/public/wp-content/uploads ]]; then
  mkdir -p $PARENT_DIR/common/public/wp-content/uploads
fi
cd $REPO_ROOT/public/wp-content && ln -fns $PARENT_DIR/common/public/wp-content/uploads
