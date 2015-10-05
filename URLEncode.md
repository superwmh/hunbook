# 筆記 #

## 名詞定義 ##

```
http://www.example1.com/abc/def?q1=abc&q2=def
                                ^^^^^^^^^^^^^ QUERY_STRING
                        ^^^^^^^ PATH_INFO
```

## encode ##

### 一般情況 ###

不論是在 `PATH_INFO` 或 `QUERY_STRING`，要正確傳入特定字元，只需針對各個值進行 encode 一次即可
```
http://www.example1.com/abc/def?q1=abc&q2=def
                        ^^^ ^^^    ^^^    ^^^ 需 encode 的部份
```

範例：
```
http://10.10.1.1/da/HD_98ST001/Photos/travel/#01?tok=abcdefg
                 ^^ ^^^^^^^^^^ ^^^^^^ ^^^^^^ ^^^     ^^^^^^^ 需 encode 的部份

http://10.10.1.1/da/HD_98ST001/Photos/travel/%2301?tok=abcdefg
                                             ^^^^^
                                             有差異的部份
```

### 在 CodeIgniter 的情況 ###

理論上也是針對 `PATH_INFO` 及 `QUERY_STRING` 必要得部份進行 encode 一次即可

```
http://api.example1.com/index.php/service/device/da/HD_98ST001/Photos/travel/#01?tok=abcdefg
                                                                             ^^^

http://api.example1.com/index.php/service/device/da/HD_98ST001/Photos/travel/%2301?tok=abcdefg
                                                                             ^^^^^
```

但以上是未使用 url rewrite 的情況，使用了 url rewrite，則 `#` 字號在 `PATH_INFO` 的地方，會被還原一次，
因此針對 `PATH_INFO` 必須 encode 兩次 (也可以只針對 `PATH_INFO` 內的 `#` 和 %` 兩個符號 encode 兩次，其他字元似乎沒有影響)

```
http://api.example1.com/service/device/da/HD_98ST001/Photos/travel/#01?tok=abcdefg
                                                                   ^^^

http://api.example1.com/service/device/da/HD_98ST001/Photos/travel/%252301?tok=abcdefg
                                                                   ^^^^^^^
```

## PHP encode 的 function ##

`urlencode()` 和 `rawurlencode()` 不太一樣：

```
urlencode(" ")      -> +
rawurlencode(" ")   -> %20
```

  * 在 **`PATH_INFO`** 內的空白必須要用 **`%20`**，不可以用 `+`
  * 在 **`QUERY_STRING`** 內的空白可用 **`%20`** 或 **`+`**

所以：

  * 處理 **`PATH_INFO`** 時，必須要用 **`rawurlencode()`**

## CodeIgniter 例外 ##

CodeIgniter 會把 **`PATH_INFO`** 內的三個字元轉掉(如下)，如果需要取得正確的值，必須自行轉回來
```
$ ---> &#36;
( ---> &#40;
) ---> &#41;
```

例如：
```
http://api.example1.com/service/device/da/HD_98ST001/Photos/travel/Hello(1).jpg
```


這時的 `$this->uri->segment(7)` 是：
```
Hello&#40;1&#41;.jpg
```

也就是說，如果要把這串 url 直接去問 router 時，就必需把上面這三個轉回來：
```
&#36;  ==>  $
&#40;  ==>  (
&#41;  ==>  )
```

進 router 的 request 才會是原來的
```
http://api.example1.com/service/device/da/HD_98ST001/Photos/travel/Hello(1).jpg
```