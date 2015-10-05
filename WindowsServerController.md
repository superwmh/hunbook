# SC.EXE create #

Creates a service entry in the registry and Service Database.

## SYNTAX ##

```
sc create [service name] [binPath= ] <option1> <option2>...
```

## CREATE OPTIONS ##

```
NOTE: The option name includes the equal sign.
 type= <own|share|interact|kernel|filesys|rec|error>
       (default = own)
 start= <boot|system|auto|demand|disabled|error>
       (default = demand)
 error= <normal|severe|critical|error|ignore>
       (default = normal)
 binPath= <BinaryPathName>
 group= <LoadOrderGroup>
 tag= <yes|no>
 depend= <Dependencies(separated by / (forward slash))>
 obj= <AccountName|ObjectName>
       (default = LocalSystem)
 DisplayName= <display name>
 password= <password>
```

**每個參數的等號後面都要有個空格**

## Examples ##

```
sc create "ssh-agent" binPath= "\"C:\Program Files\PuTTY\pageant.exe\" d:\ssh-keys\identity.ppk d:\ssh-keys\
id-rsa.ppk d:\ssh-keys\id-dsa.ppk"
```