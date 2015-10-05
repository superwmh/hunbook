

# apache2 #

## highperformance.conf ##

```
Listen 80
ServerRoot /usr/local/apache
DocumentRoot /usr/local/apache/htdocs

User  nobody
Group nobody

<IfModule prefork.c>
MaxClients       150
StartServers     5
MinSpareServers  5
MaxSpareServers 10
</IfModule>

<IfModule worker.c>
StartServers         2
MaxClients         150
MinSpareThreads     25
MaxSpareThreads     75
ThreadsPerChild     25
MaxRequestsPerChild  0
</IfModule>

# Assume no memory leaks at all
MaxRequestsPerChild 0

# it's always nice to know the server has started
ErrorLog logs/error_log

# Some benchmarks require logging, which is a good requirement.  Uncomment
# this if you need logging.
#TransferLog logs/access_log

<Directory />
    # The server can be made to avoid following symbolic links,
    # to make security simpler. However, this takes extra CPU time,
    # so we will just let it follow symlinks.
    Options FollowSymLinks

    # Don't check for .htaccess files in each directory - they slow
    # things down
    AllowOverride None

    # If this was a real internet server you'd probably want to
    # uncomment these:
    #order deny,allow
    #deny from all
</Directory>

# If this was a real internet server you'd probably want to uncomment this:
#<Directory "/usr/local/apache/htdocs">
#    order allow,deny
#    allow from all
#</Directory>
```

## mod\_deflate ##

```
<IfModule mod_deflate.c>
    # compress content with type html, text, and css
    AddOutputFilterByType DEFLATE text/html text/plain text/css application/x-javascript
    <IfModule mod_headers.c>
        # properly handle requests coming from behind proxies
        Header append Vary User-Agent
    </IfModule>
</IfModule>
```

## mod\_expires ##

```
<IfModule mod_expires.c>
    ExpiresActive on
    ExpiresByType image/jpg "access 10 years"
    ExpiresByType image/gif "access 10 years"
    ExpiresByType image/png "access 10 years"
    ExpiresDefault "access 30 minutes"
</IfModule>
```

# mysql #

```
/usr/bin/mysqladmin -u root password 'new-password'
/usr/bin/mysqladmin -u root -h p password 'new-password'
/usr/bin/mysql_secure_installation
```

```
mysqltuner.pl
http://blog.mysqltuner.com/download/

tuningprimer.sh
http://www.day32.com/MySQL/tuning-primer.sh
```

## my.cnf ##

```
[mysqld]
datadir=/var/lib/mysql
socket=/var/lib/mysql/mysql.sock
user=mysql
# Default to using old password format for compatibility with mysql 3.x
# clients (those using the mysqlclient10 compatibility package).
#old_passwords=0

# Disabling symbolic-links is recommended to prevent assorted security risks;
# to do so, uncomment this line:
# symbolic-links=0

default-character-set = utf8
character-set-server = utf8
collation-server = utf8_general_ci
init_connect = 'SET collation_connection = utf8_general_ci'
init_connect = 'SET NAMES utf8'

skip-innodb
skip-bdb
skip-networking
skip-locking
connect_timeout=15
key_buffer=16M          ## 64MB for every 1GB of RAM
join_buffer=1M
record_buffer=1M
sort_buffer=2M          ## 1MB for every 1GB of RAM
table_cache=4096
open_files_limit=8196
thread_cache_size=286
max_allowed_packet=5M
wait_timeout=15
query_cache_limit=1M
query_cache_size=256M   ## 32MB for every 1GB of RAM
query_cache_type=1
thread_concurrency=4    ## Number of CPUs x 2
local-infile=0
max_connections=200


[mysqld_safe]
log-error=/var/log/mysqld.log
pid-file=/var/run/mysqld/mysqld.pid
```

```
#http://plog.longwin.com.tw/my_note-unix/2009/06/16/perl-pretty-print-ini-cnf-2009
max_connect_errors = 1844674407370954751
connect_timeout = 20
skip-name-resolve
slave_net_timeout = 30
```


# php #


## extensions ##
```
/usr/lib64/php/modules/
```

## apc ##

```
yum install pcre-devel -y

pecl install apc
#Enable spin locks (EXPERIMENTAL) [no] : yes
#Enable pthread mutexes (default) [yes] : no

vim /etc/php.d/apc.ini
extension=apc.so
apc.stat=0
apc.ttl=86400
#apc.shm_size=64

#wget http://pecl.php.net/get/APC
#tar zxvf APC
#cp APC-3.1.9/apc.php /var/www/html/......
```

## oauth ##

```
yum install php-devel

#yum install libcurl-devel
yum install curl-devel

pecl install oauth-0.99.9
```

## 5.3.10 on CentOS ##

refs. 1: http://iuscommunity.org/Docs/GettingStarted/
```
yum list installed php*
yum erase php php-cli php-common ...
yum install php54
```

refs. 2: http://www.webtatic.com/packages/php53/
```
rpm -Uvh http://repo.webtatic.com/yum/centos/5/latest.rpm
yum --enablerepo=webtatic install php
yum --enablerepo=webtatic install php-pear
yum --enablerepo=webtatic install php-pecl-apc
#yum --enablerepo=webtatic install perl-Net-OAuth

pecl install oauth

php -v
```
**TODO:** 檢查 php.ini 設定

# user/group #

```
usermod -G apache wmh
```

# app #

```
chown apache:apache * -R
```

# unixbench #

```
wget http://byte-unixbench.googlecode.com/files/unixbench-5.1.2.tar.gz
tar xzf unixbench-5.1.2.tar.gz
cd unixbench-5.1.2

yum -y install gcc gcc-c autoconf gcc-c++ time

sed -i "s/GRAPHIC_TESTS = defined/#GRAPHIC_TESTS = defined/g" ./Makefile
make
./Run
```

# python 2.6 #

```
su -c 'rpm -Uvh http://download.fedora.redhat.com/pub/epel/5/i386/epel-release-5-4.noarch.rpm'
yum install python26

wget -q http://peak.telecommunity.com/dist/ez_setup.py
python26 ez_setup.py
```

# wcadmin #

```
service httpd status
uname -a
service httpd status
service httpd restart
service mysql status
yum install fetchmail wget bzip2 unzip zip nmap openssl lynx fileutils ncftp gcc gcc-c++
yum install mysql mysql-devel mysql-server
chkconfig --levels 235 mysqld on
/etc/init.d/mysqld start
yum install php php-devel php-gd php-imap php-ldap php-mysql php-odbc php-pear php-xml php-xmlrpc curl curl-devel perl-libwww-perl ImageMagick libxml2 libxml2-devel
nano -w /etc/httpd/conf/httpd.conf
service httpd restart
chkconfig --levels 235 httpd on

cd /etc/ssh
nano -w sshd_config
service sshd reload

nano -w /etc/motd
perl -MCPAN -e shell
cd /usr/local/src/
wget http://www.configserver.com/free/csf.tgz
tar -xvzf csf.tgz
cd csf
./install.directadmin.sh
nano -w /etc/csf/csf.conf
service csf restart
cd /usr/local/src
wget http://downloads.sourceforge.net/rkhunter/rkhunter-1.3.6.tar.gz
tar -xvzf rkhunter-1.3.6.tar.gz
cd rkhunter*
./installer.sh --layout /usr/local --install
rkhunter -c -sk
cd /usr/local/src
wget ftp://ftp.pangeia.com.br/pub/seg/pac/chkrootkit.tar.gz
tar -xvzf chkrootkit.tar.gz
cd chkrootkit*
make sense
./chkrootkit
cd /usr/local/src
wget http://www.rfxnetworks.com/downloads/prm-current.tar.gz
tar -xvzf prm-current.tar.gz
cd prm*
./install.sh
cd /usr/local/src
wget http://www.r-fx.ca/downloads/spri-current.tar.gz
tar -xvzf spri-current.tar.gz
cd spri*
./install.sh
cd /usr/local/src
wget http://www.r-fx.ca/downloads/sim-current.tar.gz
tar -xvzf sim-current.tar.gz
cd sim*
./setup -q
cd /usr/local/src
wget http://www.r-fx.ca/downloads/lsm-current.tar.gz
tar -xvzf lsm-current.tar.gz
cd lsm*
./install.sh
cd /usr/local/src
wget http://www.rfxn.com/downloads/maldetect-current.tar.gz
tar -xvzf maldetect-current.tar.gz
cd mal*
./install.sh
nohup maldet -a &
nano -w /etc/my.cnf
nano -w /etc/httpd/conf/extra/httpd-default.conf
nano -w /etc/httpd/conf/extra/httpd-mpm.conf
service httpd restart
mv /etc/sysctl.conf /etc/sysctl.conf.bak
nano -w /etc/sysctl.conf 
/sbin/sysctl -p
mv /etc/host.conf /etc/host.back
echo "# Lookup names via DNS first then fall back to /etc/hosts." > /etc/host.conf
echo "order bind,hosts" >> /etc/host.conf
echo "# We have machines with multiple IP addresses." >> /etc/host.conf
echo "multi on" >> /etc/host.conf
echo "# Check for IP address spoofing." >> /etc/host.conf
echo "nospoof on" >> /etc/host.conf
chmod 0750 `which curl` 2>&-; chmod 0750 `which fetch` 2>&-; chmod 0750 `which wget` 2>&-
nano -w /etc/named.conf
cd /usr/local/src
wget http://www.webbycart.com/hardtmp.sh
sh hardtmp.sh
nano -w /etc/fstab
mount -o remount /dev/shm
adduser -g wheel wcadmin
passwd wcadmin
nano -w /etc/ssh/sshd_config
service sshd reload
nano -w /usr/local/lib/php.ini
service httpd restart
php -i | grep php.ini
nano -w /etc/php.ini
nano -w /etc/httpd/conf/extra/httpd-default.conf
nano -w /etc/php.ini
service httpd restart
nano -w /etc/httpd/conf/extra/httpd-default.conf
service rpcidmapd stop
chkconfig rpcidmapd off
chkconfig --del rpcidmapd
service anacron stop
chkconfig anacron off
chkconfig --del anacron
service nfslock stop
chkconfig nfslock off
service cups stop
chkconfig cups off
service bluetooth stop
chkconfig bluetooth off
service avahi-daemon stop
chkconfig avahi-daemon off
service hidd stop
chkconfig hidd off
service pcscd stop
chkconfig pcscd off
service gpm stop
chkconfig gpm off
service xfs stop
chkconfig xfs off
service atd stop
chkconfig atd off
nano -w /etc/exim.conf
nano -w /etc/dovecot.conf
mkdir /usr/local/updatescript
cd /usr/local/updatescript
wget http://tools.web4host.net/update.script
chmod 755 update.script
./update.script MODsecurity2Apache2
./update.script MODsecurity2Apache2Rules
cd /usr/local/updatescript
./update.script MODevasiveApache2
cd /usr/local/src
wget http://jaist.dl.sourceforge.net/sourceforge/nagiosplug/nagios-plugins-1.4.11.tar.gz
tar -xvzf nagios-plugins-1.4.11.tar.gz
cd nagios-plugins-1.4.11
./configure --prefix=/usr/local/nagios
make
make install
cd /usr/local/src/
wget http://nchc.dl.sourceforge.net/sourceforge/nagios/nrpe-2.12.tar.gz
tar -xvzf nrpe-2.12.tar.gz
cd nrpe-2.12
./configure 
make all
cp src/nrpe /usr/local/nagios/libexec/
cp src/check_nrpe /usr/local/nagios/libexec/
cp sample-config/nrpe.cfg /usr/local/nagios/libexec/
adduser nagios
chown -R nagios.nagios /usr/local/nagios/
echo "command[check_disk]=/usr/local/nagios/libexec/check_disk -w 20% -c 10%" >> /usr/local/nagios/libexec/nrpe.cfg
echo "command[check_swap]=/usr/local/nagios/libexec/check_swap -w 20% -c 10%" >> /usr/local/nagios/libexec/nrpe.cfg
echo "command[check_mysql]=/usr/local/nagios/libexec/check_mysql" >> /usr/local/nagios/libexec/nrpe.cfg
echo "command[check_pop3]=/usr/local/nagios/libexec/check_pop -H localhost -p 110" >> /usr/local/nagios/libexec/nrpe.cfg
echo "command[check_smtp]=/usr/local/nagios/libexec/check_smtp -H localhost -p 25" >> /usr/local/nagios/libexec/nrpe.cfg
nano -w /etc/services
nano -w /etc/xinetd.d/nrpe
echo "208.101.58.42:allow" >> /etc/hosts.allow
yum -y install xinetd
/etc/init.d/xinetd restart
```

# backup\_daily.sh #

```
export MYAPP="helloworld"
cd /var/www/html/labs/backup
mysqldump -u -p ${MYAPP} -e > ${MYAPP}_`date +%d`.sql
gzip ${MYAPP}_`date +%d`.sql -f
python26 ~/gsutil/gsutil cp ${MYAPP}_`date +%d`.sql.gz gs://bak/
cd /var/www/html/labs/Dropbox-0.4.0
php daily_backup.php
rm /var/www/html/labs/backup/${MYAPP}_`date -d yesterday +%d`.sql.gz
cd /var/www/html
tar jcvf ${MYAPP}.tar.bz2 ${MYAPP}/
python26 ~/gsutil/gsutil cp ${MYAPP}.tar.bz2 gs://bak/
mv ${MYAPP}.tar.bz2 /var/www/html/labs/backup/
```

# My VPS Installation #

```
tzselect
5
43
1
yum update tzdata -y
rm /etc/localtime -f
cp -a /usr/share/zoneinfo/Asia/Taipei /etc/localtime

yum install screen -y
wget http://jsgears.googlecode.com/svn/trunk/settings/.screenrc
wget http://jsgears.googlecode.com/svn/trunk/settings/.vimrc
mkdir .ssh
cd .ssh
wget http://jsgears.googlecode.com/svn/trunk/settings/.ssh/authorized_keys

yum install mysql-server -y
yum install php-mysql -y
yum install php -y
yum install php-pear -y
yum install php-mbstring -y
yum update curl -y
yum install gcc -y
pecl channel-update pear.php.net
pecl install json

vim /etc/php.ini
date.timezone = Asia/Taipei

vim /etc/php.d/json.ini
extension=json.so

yum install ntp -y
/usr/sbin/ntpdate tock.stdtime.gov.tw
crontab -e
10 5 * * * /usr/sbin/ntpdate tock.stdtime.gov.tw && /sbin/hwclock -w

yum install p7zip -y
```