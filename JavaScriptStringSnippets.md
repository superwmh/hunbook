# break word in firefox #

```
// from awoo
function setBreak(sString) {
    return sString.replace(/([\w|\d|\.|\@]{4})/g, "\$1<wbr>");
}
```

```
// revised version from John Resig's

/**
 * NOTE: YUI compressor will cause error if we use new RegExp() to
 *       combine reg pattern here.
 */

function wbr (str, num) {
    var pattern;
    switch (num) {
    case 2 :
        pattern = /(\w{2})(\w)/g;
        break;
    case 3 :
        pattern = /(\w{3})(\w)/g;
        break;
    case 4 :
        pattern = /(\w{4})(\w)/g;
        break;
    case 5 :
        pattern = /(\w{5})(\w)/g;
        break;
    case 6 :
        pattern = /(\w{6})(\w)/g;
        break;
    default:
        return str; //all others not support!
    }
    return str.replace(pattern, function (all, text, ch) {
        return text + "<wbr>" + ch;
    });
}
```

```
// http://ejohn.org/blog/injecting-word-breaks-with-javascript/
// DO NOT USE THIS:
// 1. new RegExp()... will cause error in YUI compressor
// 2. char is reserve word in JavaScript
function wbr(str, num) {  
  return str.replace(new RegExp("(\\w{" + num + "})(\\w)", "g"), function (all, text, char){ 
    return text + "<wbr>" + char; 
  }); 
}
```

# 字串 byte 長度 #

## UTF-8 版 ##
```
encodeURIComponent("Hello, 中文").replace(/%[A-F\d]{2}/g, 'U').length;
```

## BIG5 版 ##
```
//string.Blength() 傳回字串的byte長度    
String.prototype.Blength = function() {    
    var arr = this.match(/[^\xa0-\xff]/ig);    
    return  arr == null ? this.length : this.length + arr.length;    
}
```