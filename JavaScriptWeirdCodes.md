
```
//http://topic.csdn.net/u/20100716/15/256302a7-f906-467b-882d-94e8e8c3a1fd.html?45654
p= /[*]/g;
s= "*";
console.log(p.test(s));
console.log(p.test(s));
console.log(p.test(s));
console.log(p.test(s));
```
> 这个正则设置了g标志，会影响lastIndex属性，第二个test是从`*`后面开始，所以会是false,然后lastIndex设置为0,下一个就是true,然后false....

> RegExpObject.lastIndex 该属性存放一个整数，它存储的是上一次匹配文本之后的第一个字符的位置。

> 上次匹配的结果是由方法RegExp.exec()和RegExp.test()（注，IE上的String对象的match()方法也会影响，但Firefox上不会影响该正则式对象属性）找到的，它们都以lastIndex属性所指的位置作为下次检索的起始点。这样，就可以通过反复调 用这两个方法来遍历一个字符串中的所有匹配文本。

> 该属性是可读可写的。只要目标字符串的下一次搜索开始，就可以对它进行设置。当方法exec()或test()再也找不到可以匹配的文本时，它们会自动把lastIndex属性重置为0。