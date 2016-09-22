#!/bin/bash

if [ -z "$1" ]; then
    echo -e "Error:\n\tProvide IP as the first param"
    echo -e "Usage:\n\t$0 <IP>"
    exit 1
fi

/etc/init.d/denyhosts stop
echo '
/var/lib/denyhosts/hosts
/var/lib/denyhosts/hosts-restricted
/var/lib/denyhosts/hosts-root
/var/lib/denyhosts/hosts-valid
/var/lib/denyhosts/users-hosts
/etc/hosts.deny
' | grep -v "^$" | xargs sed -i "/$1/d"
/etc/init.d/denyhosts start
