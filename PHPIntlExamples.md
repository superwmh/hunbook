  * http://php.net/manual/en/book.intl.php

## Number ##

```
$fmt = numfmt_create("zh-TW", NumberFormatter::DECIMAL);
echo numfmt_format($fmt, 1234567.891234567890000);  // 1,234,567.891

$fmt = numfmt_create("de-DE", NumberFormatter::DECIMAL);
echo numfmt_format($fmt, 1234567.891234567890000);  // 1.234.567,891
```

## Date ##

```
$fmt = datefmt_create("zh-TW", IntlDateFormatter::MEDIUM, IntlDateFormatter::NONE);
echo datefmt_format($fmt, time());  // 2010/9/13

$fmt = datefmt_create("en_US", IntlDateFormatter::MEDIUM, IntlDateFormatter::NONE);
echo datefmt_format($fmt, time());  // Sep 13, 2010
```

```
$fmt = datefmt_create("zh-TW", IntlDateFormatter::MEDIUM, IntlDateFormatter::MEDIUM);
echo datefmt_format($fmt, time());  // 2010/9/13 上午 10:45:12

$fmt = datefmt_create("en_US", IntlDateFormatter::MEDIUM, IntlDateFormatter::MEDIUM);
echo datefmt_format($fmt, time());  // Sep 13, 2010 10:45:12 AM
```

```
$fmt = datefmt_create("zh-TW", IntlDateFormatter::LONG, IntlDateFormatter::LONG);
echo datefmt_format($fmt, time());  // 2010年9月13日 上午10時45分12秒

$fmt = datefmt_create("en_US", IntlDateFormatter::LONG, IntlDateFormatter::LONG);
echo datefmt_format($fmt, time());  // September 13, 2010 10:45:12 AM GMT+08:00
```