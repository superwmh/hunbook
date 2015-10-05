# Virtual Directory #

```
Alias /myproject1/ "D:/Workspace/GitRepositories/myproject1/"

<Directory "D:/Workspace/GitRepositories/myproject1">
    Options Indexes MultiViews FollowSymLinks
    AllowOverride None
    Order allow,deny
    Allow from all
</Directory>
```


# CodeIgniter Rewrite Rule #

```
<Directory "D:/Workspace/GitRepositories/myproject2">
    RewriteEngine on
    RewriteCond $1 !^(index\.php|js|css|robots\.txt)
    RewriteRule ^(.*)$ index.php/$1 [L]
</Directory>
```

# Virtual Host #

## httpd.conf ##

```
# Dynamic Shared Object (DSO) Support
LoadModule vhost_alias_module modules/mod_vhost_alias.so

# Virtual hosts
Include conf/extra/httpd-vhosts.conf
```

## httpd-vhosts.conf ##

```
NameVirtualHost 127.0.0.1:8000

<VirtualHost w1.example.com:8000>
    DocumentRoot "D:/Workspace/GitRepositories/w1"
    ServerName myproject3.example.com
    ServerAdmin admin@example.com
    ErrorLog "logs/myproject3.example.com-error.log"
    CustomLog "logs/myproject3.example.com-access.log" common
</VirtualHost>

<VirtualHost w2.example.com:8000>
    DocumentRoot "D:/Workspace/GitRepositories/w2"
    ServerName myproject3.example.com
</VirtualHost>
```

# SSL #

## key & cert files ##

```
http://jsgears.googlecode.com/svn/trunk/settings/h.com/h.com.server.crt
http://jsgears.googlecode.com/svn/trunk/settings/h.com/h.com.server.key
```

## extra/httpd-ssl.conf ##

```
SSLSessionCache        "shmcb:/PathTo/Apache2.2/logs/ssl_scache(512000)"

ServerName h.com:443

SSLCertificateFile "/PathTo/Apache2.2/conf/h.com.server.crt"

SSLCertificateKeyFile "/PathTo/Apache2.2/conf/h.com.server.key"
```

## Refs ##

  * https://www.ssllabs.com/ssltest/analyze.html
  * http://linuxwindowsmaster.com/how-to-disable-the-support-for-sslv2-low-encryption-ciphers/