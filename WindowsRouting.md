# sample #

```
@ECHO OFF
ECHO Facebook Routes ON
route -p add 69.63.0.0 mask 255.255.0.0 192.168.0.1
route -p add 66.220.0.0 mask 255.255.0.0 192.168.0.1
PAUSE
route delete 69.63.0.0
route delete 66.220.0.0
```