# 用 Taipei time，不管主機在哪裡 #

```
date_default_timezone_set('Asia/Taipei');
```

# getdate — Get date/time information #
```
$today = getdate();
print_r($today);
/*
Array
(
    [seconds] => 40
    [minutes] => 58
    [hours]   => 21
    [mday]    => 17
    [wday]    => 2
    [mon]     => 6
    [year]    => 2003
    [yday]    => 167
    [weekday] => Tuesday
    [month]   => June
    [0]       => 1055901520
)
*/
```

# strtotime #

```
$str = 'Sun, 30 May 2010 04:07:38 GMT';
echo date("Y-m-d H:i:s", strtotime($str));
```

```
// SimplePie item class
$ts = strtotime($item->get_date(DATE_ATOM));
```

# get\_ts\_offset #

```
//傳入 timezone 和 timestamp(optional)，可回傳 timestamp_offset 值，僅做為顯示時間用
function get_ts_offset($timezone = -99, $ts = 0) {
  if ($ts == 0) $ts = time();

  //localtime info (可檢查是否有日光節約)
  $localtime_assoc = localtime(time(), TRUE);

  //目前 server 與 GMT 的差異 (這一段算是硬湊的)
  $server_ts_offset = mktime(0, 0, 0, 1, 1, 1970) - $localtime_assoc['tm_isdst'] * 60 * 60;
  $server_timezone = -($server_ts_offset/3600);

  //若未指定顯示的 timezone, 則以 server 當地時間顯示
  if ($timezone == -99) $timezone = $server_timezone;

  //offset 算法：先轉為 GMT offset，再加上 timezone offset
  return $ts + $server_ts_offset + $timezone * 3600;
}
```

# 在不同時區的主機取得台北當天零時的 ts #

```
$now = time();
$taipei_ts = get_ts_offset(8, $now); // taipei ts
echo $taipei_ts, "\n";
echo date("Y-m-d H:i:s", $taipei_ts), "\n";

$now -= 86400;           // last day
$taipei_day_ts = $now - date("H", $taipei_ts) * 3600 - date("i", $taipei_ts) * 60 - date("s", $taipei_ts);

echo $taipei_day_ts, "\n";
echo date("Y-m-d H:i:s", $taipei_day_ts), "\n";
```