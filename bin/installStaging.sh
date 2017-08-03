echo start;
STAGING='geo';
WEBROOT=/var/www/$STAGING;
PUBLIC=$WEBROOT/public_html;
USER='jesse';
SERVER=$USER'@jdillman.com';cd $PUBLIC;
sudo chown -R $USER:www-data $PUBLIC;

echo "Installing Git deployment";
cd $WEBROOT;
mkdir $STAGING.git;
cd $STAGING.git;
git init --bare;
cd hooks;
touch post-receive;
echo "#!/bin/sh
unset GIT_DIR;
export GIT_WORK_TREE=$WEBROOT/build;
export GIT_DIR=$WEBROOT/$STAGING.git;
git checkout -f master;
rsync -r $WEBROOT/build/* $PUBLIC/" >> post-receive;

cd $WEBROOT;
mkdir build;
cd build;

cd $WEBROOT/$STAGING.git/hooks;
chmod 775 post-receive;