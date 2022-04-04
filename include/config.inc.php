<?php
# Configuration file for various includes
# Must be included before anything else


#		LDAP vars		#
define('LDAP_URI','ldap://127.0.0.1');
define('BIND_DN','CN=admin,DC=nigez,DC=com');
define('BIND_PW','100883Elv');
define('BASE_DN','DC=nigez,DC=com');
define('USERS_OU','OU=TDCoinUsers, DC=nigez, DC=com');
define('DOMAIN','nigez.com');

define('SEARCH_TYPES', array(
    'webpage',
    'news',
    'image',
    'video',
    'audio',
    'dictionary',
    'buy'
));
