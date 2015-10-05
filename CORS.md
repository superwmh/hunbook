## Implements ##

  * jQuery
```
xhrFields: {
     withCredentials: true
},
```
  * YUI
```
xdr: {
    credentials: true
},
```
  * PHP
```
header("Access-Control-Allow-Origin: " . $_SERVER["HTTP_ORIGIN"]); //不能用 *
header("Access-Control-Allow-Credentials: true");
```


## Refs ##

  * http://dvcs.w3.org/hg/cors/raw-file/tip/Overview.html