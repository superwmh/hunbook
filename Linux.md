

#summary Something about Linux

# 查 distribution 版本 #

```
lsb_release -a
```

# 幾個看狀態的指令 #

```
cat /etc/issue     ; OS version
cat /proc/cpuinfo  ; CPU
cat /proc/version  ; Linux kernel
hostname
free
df -h
uptime
uname -a           ; Linux info
dmesg
```

# suders #

```
# sudo git for apache
Defaults:apache   !requiretty
apache  ALL=(ALL) NOPASSWD: /usr/bin/git
```

# multi core CPU #

指定 2~4 CPU 執行特定工作，留下 1 CPU 閒置，可以避免 CPU 被該作業完全鎖死

```
sudo taskset -c 1,2,3 /etc/init.d/apache2 restart
```

# 設定自己的時區 #

```
tzselect
```

```
export TZ="/usr/share/zoneinfo/Asia/Tapei"
```

```
yum update tzdata
rm /etc/localtime
cp /usr/share/zoneinfo/Asia/Tapei /etc/localtime
```

# 刪除超過多久的檔案 #
```
cd /home/webuser/NA/sessions; find -cmin +2880 | xargs rm

# 進階版，找單一層的目錄，過濾再刪除
cd /tmp/thisIsTemp && find -maxdepth 1 -type d -mmin +10080 | grep thisIsTemp_ | xargs rm -rf 
```

# change the resolution #

```
; This will show the resolutions possible on your monitor
xrandr

; This will immediately change the resolution; in this case to 1024x760.
xrandr -s 1024x760
```

# Google Chrome #

```
vim /etc/yum.repos.d/google.repo

[Google]
name=Google Chrome (i386)
baseurl=http://dl.google.com/linux/rpm/stable/i386
enable=1
gpgcheck=1
gpgkey=http://dl-ssl.google.com/linux/linux_signing_key.pup
```

# YUM Repo #

**http://iuscommunity.org/Repos**

# YUM #

```
yum search ImageMagick
yum install ImageMagick
yum update ImageMagick
yum remove ImageMagick

#清除暫存檔
yum clean all

#列出已安裝的套件
yum list installed

#列出可以更新的套件
yum list updates
```

# PHP on CentOS #

**http://iuscommunity.org/Repos**

```
yum install php
yum install php-pear
yum install php-mbstring
yum update curl
```

## pecl ##

```
#yum install php-pear
#yum install gcc
#pecl channel-update pear.php.net
pecl install json
```

## pecl intl ##

```
yum install icu libicu libicu-devel
export ICU_PATH=/usr
export ICU_LINK=-L/usr/lib64

yum install gcc-c++

pecl install intl

vim /etc/php.d/intl.ini
extension=intl.so
```

## timezone ##

```
yum install ntp
yum update tzdata
rm /etc/localtime
cp -a /usr/share/zoneinfo/Asia/Taipei /etc/localtime
```

```
vim /etc/sysconfig/clock
ZONE="Asia/Taipei"
UTC=false
ARC=false
```

```
vim /etc/php.ini
date.timezone = Asia/Taipei
```

# ls #

```
# 用 ls 指令會列出目錄下的內容，如果想知道目錄下有多少檔案及多少目錄，可以輸入以下指令:

# 顯示檔案數目:
ls -la | grep "^-" | awk 'END {print "Number of files: " NR}'

# 顯示目錄數目:
ls -la | grep "^d" | awk 'END {print "Number of directories: " NR}'
```

# Virtual Box #

## 螢幕解析度 ##

ref: http://forums.virtualbox.org/viewtopic.php?f=3&t=15679

Edit the `/etc/X11/xorg.conf` and add something like this.
```
Section "Screen"
       Identifier "Screen0"
       Device     "Videocard0"
       DefaultDepth     24
       SubSection "Display"
               Viewport   0 0
               Depth     24
               Modes    "1750x1090" "1600x1200" "1600x1024" "1440x900" "1400x1050" "1280x1024" "1280x960" "1280x800" "1152x864" "1152x768" "1024x768" "800x600" "640x480"
       EndSubSection
EndSection
```

## console resolution ##

### ubuntu ###

```
as root edit /etc/default/grub uncomment the GRUB_GFXMODE=640x480
and change the resolution to something you can use e.g. 1024x768

edit /etc/grub.d/00_header search for: set gfxmode=${GRUB_GFXMODE}
on the next line insert: set gfxpayload=keep verify that the new line
is before insmod gfxterm

run update-grub
run reboot
```

### CentOS ###
Edit `/etc/grub.conf`, Add `vga=791`
(ArchLinux: /boot/grub/grub.conf)

```
title CentOS (2.6.18-53.1.19.el5PAE)
  root (hd0,0)
  kernel /vmlinuz-2.6.18-53.1.19.el5PAE ro root=/dev/VolGroup00/LogVol00 console=ttyS0,57600 console=tty0 vga=791
  initrd /initrd-2.6.18-53.1.19.el5PAE.img
```

## ssh ##

```
cd "c:\Program Files\Oracle\VirtualBox"
VBoxManage modifyvm CentOS --natpf1 "guestssh,tcp,,2424,,22"
VBoxManage modifyvm CentOS --natpf2 "guesthttp,tcp,,8001,,80"
```

## HTTP Setup ##

```
Website Name: mirror.centos.org
CentOS Directory: centos/5.6/os/i386

// mirrors
//http://mirror01.idc.hinet.net/CentOS/5.6/os/i386/
//http://ftp.stu.edu.tw/Linux/CentOS/5.6/os/i386/
//http://ftp.tc.edu.tw/Linux/CentOS/5.6/os/i386/
//http://ftp.twaren.net/Linux/CentOS/5.6/os/i386/
//http://ftp.isu.edu.tw/pub/Linux/CentOS/5.6/os/i386/
//http://ftp.cse.yzu.edu.tw/pub/CentOS/5.6/os/i386/
```

# .screenrc #

```
caption always "%{= bk} %{= bY} [%n]%t @ %H %{-} %= %{= bR} %l %{-} | %{= KG} %Y-%m-%d %{-} "
hardstatus alwayslastline " %-Lw%{= Bw}%n%f %t%{-}%+Lw %=| %0c:%s "
bindkey -d -k kb stuff "\010"

#bindkey \033[D prev
#bindkey \033[D next

#caption always "%{.KW} %-w%{.mW}[%n] %t%{.KW}%+w"
#hardstatus alwayslastline "%{R}[ %{w}%1` %{R}]%=%{M}%e %{G}"

#termcapinfo xterm "Co#256:AB=\E[48;5;%dm:AF=\E[38;5;%dm"
#term $TERM # depend on $TERM
#term xterm # or specified term
```

# .vimrc #

```

"gvim setting
"colorscheme desert
"set guifont=mingliu:h12

"security
set nomodeline


" 游標移動後, 一樣可以用 backspace, del 等刪除動作
set bs=2

" 過長不要斷行
set nowrap

" 搜尋到的字加 hilight
set hlsearch
set incsearch

" 忽略大小寫, 都可以搜尋到
"set ignorecase

" terminal title 會設為 filename
set title

set runtimepath=~/.vim,$VIMRUNTIME
set history=50

filetype on
"set path+=/home/y/share/pear
"set path+=/var/phplib
set number
set cindent
"set autoindent
"set smartindent

" \t 會以 4個空格代替
set expandtab
set shiftwidth=4

set softtabstop=4
set tabstop=4

" :sp 開檔時, 上面會列出所有檔案
set wildmenu

" 可以用 {{{ }}} 縮排 Folded
set foldmarker={{{,}}}
set foldmethod=marker

" Remove trailing whitespaces
" map \ :%s/[     ]*$//g
map \ :%s/\s*$//g

" {{{ syntax highlight
syntax on
":highlight 可以看到所有的顏色
" 顏色 Templates
"colorscheme default
"colorscheme desert
"hi Comment ctermbg=black ctermfg=darkcyan
"hi Comment ctermbg=7 ctermfg=0 term=reverse cterm=reverse
"hi Comment ctermfg=darkcyan
hi Comment term=standout cterm=bold ctermfg=0
" /usr/share/vim/vim70/colors/desert.vim
highlight Search term=reverse ctermbg=3 ctermfg=0
highlight Normal ctermbg=black ctermfg=white
"highlight Folded term=bold ctermbg=2 ctermfg=7
highlight Folded ctermbg=black ctermfg=darkcyan

hi Cursor ctermbg=Gray ctermfg=Blue
"hi Visual ctermbg=yellow ctermfg=blue
"hi Visual cterm=bold ctermbg=darkcyan ctermfg=yellow
highlight clear SpellBad
highlight SpellBad term=underline cterm=underline ctermfg=red
"set background=light
"colorscheme desert
" }}}

" {{{ 下面出現一列 bar.
set ls=2
set statusline=%<%f\ %m%=\ %h%r\ %-19([%p%%]\ %3l,%02c%03V%)%y
"highlight StatusLine ctermfg=2 ctermbg=0
"highlight StatusLine ctermfg=blue ctermbg=white
highlight StatusLine term=bold,reverse cterm=bold,reverse
" }}}
" {{{ 像 ultraedit 一樣有一列的顏色
" Line highlight
set cursorline
" Column highlight
" set cursorcolumn
"highlight CursorLine cterm=none ctermbg=blue
"highlight CursorLine cterm=none ctermbg=7 ctermfg=0
"highlight CursorLine cterm=none ctermbg=4 ctermfg=7
highlight CursorLine cterm=none ctermbg=4
" }}}
" {{{ UTF-8 Big5 Setting
" 檔案存檔會存成utf-8編碼
" "set fileencoding=utf-8
" "
" " 以下四個設下去. vim 編出來都是 utf-8 編碼的.
"set fileencoding=utf-8
"set fileencodings=big5,utf-8
"set termencoding=utf-8
"設定自動轉換為 UTF-8 編碼
" vim 新開的檔案預設是 utf-8 編碼(寫檔)
set fileencoding=utf-8
" vim 新開的檔案預設是 utf-8 編碼(讀檔)
set fileencodings=utf-8,big5,euc-jp,gbk,euc-kr,utf-bom,iso8859-1
" 內部在用的encode(vim 內部在用的 encode)
set encoding=utf8
set tenc=utf8
" 使用 <F12> 來將文字編碼轉換成 Big5
map <F12> :set tenc=big5<cr>

" vim 啟動後，是使用 utf-8 編碼
" 所有可能的編碼

" set termencoding=big5
" 當 Terminal.app 的 Display > encoding 是設成 Big5-hkscs，也就是說 terminal
" 會把鍵盤的輸入以 big5 編碼方式送到 vim 時，vim 需要有這個設定，才會將 big5 的輸入
" 轉成上面設定的 utf-8 編碼。如果你的 Terminal.app 是用 utf-8
" 編碼，則可忽略此項。
" }}}
" {{{ For PHP Hot Key
" Map ; to run PHP parser check
"noremap ; :!php -l %<CR>
" Map <CTRL>-P to run actual file with PHP CLI
"noremap <C-P> :w!<CR>:!php %<CR>
" Map <CTRL>-M to search phpm for the function name currently under the cursor (insert mode only)
"inoremap <C-H> <ESC>:!phpm <C-R>=expand("<cword>")<CR><CR>
" Automatic close char mapping
"inoremap  { {<CR>}<C-O>O
"inoremap [ []<LEFT>
"inoremap ( ()<LEFT>
"inoremap " ""<LEFT>
"inoremap ' ''<LEFT>
" }}}
" {{{ 直接按 F8 (Tlist, function list)
"source $HOME/.vim/phpdoc.vim
"ctags apt-get install exuberant-ctags
" }}}
" {{{ ctrl + n, ctrl + p(會自動把function列出)
set dictionary-=~/.vim/funclist.txt
set complete-=k complete+=k
" }}}
" {{{ 會自動到最後離開的位置
if has("autocmd")
    autocmd BufRead *.txt set tw=78
    autocmd BufReadPost *
    \ if line("'\"") > 0 && line ("'\"") <= line("$") |
    \   exe "normal g'\"" |
    \ endif
endif
" }}}
" {{{ save .vimrc, auto exec, .vimrc 如果存檔, 就會立刻實現

autocmd! bufwritepost .vimrc source %
" }}}
" {{{ mail 的話自動開啟 spell 功能
"autocmd FileType mail setlocal spell
" }}}
highlight TabLine ctermbg=blue
highlight TabLineFill ctermbg=green
highlight TabLineSel ctermbg=red
```

# .bashrc #

```
export PATH=/usr/kerberos/bin:/usr/local/bin:/bin:/usr/bin:/home/hunter_wu/bin:/usr/sbin:
umask 022

# screen setting
if [ "x$WINDOW" == "x" ]; then
  if [ "x$YROOT_NAME" == "x" ]; then
    PS1="\e[30;1m\u@\h\e[0m\e[36;1m[\w]\e[0m\e[33;1m\#\e[0m > "
  else
    PS1="\e[30;1m\u@\h:$YROOT_NAME\e[36;1m[\w]\e[33;1m\#\e[0m > "
  fi  
else
  if [ "x$YROOT_NAME" == "x" ]; then
    PS1="\e[30;1m[w$WINDOW]\e[34m\u@\h\e[0m\e[36;1m[\w]\e[31;1m#\# \e[30;1m>\e[0m "
  else
    PS1="\e[30;1m\u@\h:$YROOT_NAME\e[0m\e[32;1m[\w]\e[0m\e[32;1m[W$WINDOW]\e[0m\e[33;1m\#\e[0m> "
  fi  
fi

# man page color setting
export LESS_TERMCAP_mb=$'\E[01;31m'
export LESS_TERMCAP_md=$'\E[01;31m'
export LESS_TERMCAP_me=$'\E[0m'
export LESS_TERMCAP_se=$'\E[0m'
export LESS_TERMCAP_so=$'\E[01;44;33m'
export LESS_TERMCAP_ue=$'\E[0m'
export LESS_TERMCAP_us=$'\E[01;32m'

# set screen name
ScreenName="\[\033k\H:\w\033\134\]"

# misc
export LANG=zh_TW.UTF-8
export LSCOLORS=gxfxcxdxbxegedabagacad

# set alias
alias ll="ls -la"
alias dblogin="mysql -u root -{{PASSWORD_HERE}}"
alias gowww="cd /home/dev/$USER/www" 
alias gogo='cd /home/dev/hunter_wu/'
alias goconf='cd /etc/httpd/conf.d';
alias gogit='cd /var/cache/git/';
alias gotrac='cd /var/www/trac';
alias reload="source ~/.bashrc";
alias addtracuser="sudo /usr/bin/htpasswd /etc/httpd/dav_git.passwd "
alias goconf='cd /etc/httpd/conf.d/'
alias restart='sudo /etc/init.d/httpd restart'
alias adduser="sudo adduser "
alias gitci="git commit -a "

SSH_ENV="$HOME/.ssh/environment"

function start_agent {
echo "Initialising new SSH agent..."
/usr/bin/ssh-agent | sed 's/^echo/#echo/' > "${SSH_ENV}"
echo succeeded
chmod 600 "${SSH_ENV}"
. "${SSH_ENV}" > /dev/null
/usr/bin/ssh-add;
}

if [ -f "${SSH_ENV}" ]; then
. "${SSH_ENV}" > /dev/null
ps -ef | grep ${SSH_AGENT_PID} | grep ssh-agent$ > /dev/null || {
start_agent;
}
else
start_agent;
fi
```

# CentOS 6 #

## 中文輸入 ##
```
yum install "@Chinese Support"
```

System -> Preferences -> Input Method

# Applications #

## memcache ##

```
/usr/bin/memcached-tool 127.0.0.1:11211 stats
/usr/bin/memcached-tool 127.0.0.1:11211 display
/usr/bin/memcached-tool 127.0.0.1:11211 dump
```


# Gentoo #

## 改 ip ##

```
vim /etc/conf.d/network (or net, ethx)
/etc/init.d/network restart
```

## 開機啟動 ##

`rc-update`

```
/etc/local.d/*.start
```

- or -

```
vi /etc/init.d/rc.local
chmod +x rc.local
rc-update add rc.local default
```


# dm-crypt #

```
fdisk -l /dev/sdc
cfdisk /dev/sdc
cryptsetup -y create myEncFS /dev/sdc1
dmsetup ls
mkfs -t ext4 /dev/mapper/myEncFS
mount /dev/mapper/myEncFS /mnt/secure_hd
```