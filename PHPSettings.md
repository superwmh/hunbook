  * date.timezone 沒有設定時，可能造成 date() 算錯，可 check 以下兩個值：
```
echo date('Y-m-d H:i:s', 653410800), "\n"; //1990-09-15 23:00:00
echo date('Y-m-d H:i:s', 653410799), "\n"; //1990-09-15 22:59:59
```
設定範例
```
[Date]
; Defines the default timezone used by the date functions
date.timezone = Asia/Taipei
```

  * Production errors
```
display_errors = Off
error_reporting  =  E_ALL & ~E_NOTICE
error_log = /path/to/log_file
; ignore_repeated_errors = On
```

  * 虛擬主機的時區設定不符合需求，可用以下取代：
```
date_default_timezone_set('Asia/Taipei');
```

  * extensions 順序，php\_mbstring.dll 應該要在 php\_exif.dll 前面：

```
extension=php_mbstring.dll
extension=php_exif.dll
```

  * 可直接取得 POST RAW DATA

```
; Always populate the $HTTP_RAW_POST_DATA variable.
always_populate_raw_post_data = On
```
```
// 這樣也可以
file_get_contents("php://input");
```