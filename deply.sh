#!/bin/bash

# Run this script inside the kimai2 docker container
# docker exec -it kimaiadmin_kimai_1 /bin/bash

cd /opt/kimai/var/plugins && \
rm -rf ApprovalBundle && \
curl -LOk https://github.com/serek-dev/ApprovalBundle/archive/main.zip && \
unzip main.zip -d ApprovalBundle && \
mv ApprovalBundle/ApprovalBundle-main/* ApprovalBundle && \
rm main.zip && \
cd .. && cd .. && \
php bin/console cache:clear && \
php bin/console kimai:bundle:approval:install || true # ignore error if already installed
