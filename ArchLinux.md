# Upgrade pacman from 4.0 to 4.1 #

```
pacman -Rns package-query yaourt
pacman -Syu

# https://aur.archlinux.org/packages/package-query/
# https://aur.archlinux.org/packages/yaourt/
cd /tmp
wget http://mir.archlinux.fr/~tuxce/releases/package-query/package-query-1.2.tar.gz
wget https://aur.archlinux.org/packages/pa/package-query/package-query.tar.gz
wget http://mir.archlinux.fr/~tuxce/releases/yaourt/yaourt-1.3.tar.gz
wget https://aur.archlinux.org/packages/ya/yaourt/yaourt.tar.gz
tar zxf package-query-1.2.tar.gz
tar zxf package-query.tar.gz
tar zxf yaourt-1.3.tar.gz
tar zxf yaourt.tar.gz
cp package-query/PKGBUILD  package-query-1.2/
cp yaourt/PKGBUILD yaourt-1.3/
cd package-query
makepkg -s --asroot
pacman -U package-query-1.2-2-x86_64.pkg.tar.xz
cd ../yaourt-1.3
makepkg -s --asroot
pacman -U yaourt-1.3-1-any.pkg.tar.xz
```


# Packer #

```
sudo pacman -Syy
sudo packer {keyword}
```

# systemd #

```
systemctl status mysql
systemctl start mysql
systemctl enable mysql
```

```
/etc/systemd/system/multi-user.target.wants/httpd.service

PrivateTmp=false
```

# yaourt #

```
sudo yaourt ...
```