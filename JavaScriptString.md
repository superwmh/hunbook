# 以 byte 計算字串的長度 #

```
//string.Blength()
String.prototype.Blength = function() {
    var arr = this.match(/[^\xa0-\xff]/ig);
    return  arr == null ? this.length : this.length + arr.length;
}
```