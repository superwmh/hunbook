<?php
/*
 * 日期、時間相關函式庫
 */

//傳入 timestamp 和 timezone 可顯示正確時間
function show_datetime($format, $now_ts, $timezone = -99) {
  return date($format, get_ts_offset($timezone, $now_ts));
}

//台北時間 "2010/4/17 下午 04:39:20" ==> 1271493560
//strtots($str, 8)
function strtots($str, $from_timezone) {
    $str = str_replace(array("/", " "), ":", $str);
    list($y, $m, $d, $p, $h, $i, $s) = explode(":", $str);
    $ts = gmmktime((int)$h, (int)$i, (int)$s, (int)$m, (int)$d, (int)$y) - $from_timezone * 3600;
    if ((int)$h === 12) {
        $ts -= 12*60*60;
    }
    if ($p === "下午" || $p === "PM") {
        $ts += 12*60*60;
    }
    return $ts;
}

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

//取得人性化的時間間隔描述
function get_duration_desc($duration) {
  if ($duration < 0) return '';

  if ($duration < 60) {
    return '於'. $duration .'秒前';

  } else if ($duration < 60 * 60) {
    return floor($duration / 60) .'分鐘前';

  } else if ($duration < 60 * 60 * 24) {
    return floor($duration / 60 / 60) .'小時前';

  } else if ($duration < 60 * 60 * 24 * 30) {
    return floor($duration / 60 / 60 / 24) .'天前';

  } else if ($duration < 60 * 60 * 24 * 365) {
    return floor($duration / 60 / 60 / 24 / 30) .'個月前';

  } else {
    return floor($duration / 60 / 60 / 24 / 365) .'年前';

  }
}

//取得完整的時間間隔描述
function get_full_duration_desc($duration) {
    $periods = array(
        array(60 * 60 * 24, '天'),
        array(60 * 60,      '小時'),
        array(60,           '分'),
        array(1,            '秒'),
    );
    $rtn = '';
    foreach ($periods as $period) {
        list($p, $desc) = $period;
        if ($duration > $p) {
            $units = floor($duration / $p);
            $duration -= $units * $p;
            if ($rtn !== '') {
                $rtn .= ' ';
            }
            $rtn .= $units . $desc;
        }
    }
    return $rtn;
}

//取得當天零時 ts
function get_today_ts() {
    return mktime(0, 0, 0, date('m'), date('d'), date('Y'));
}

//取得週日的 timestamp
function get_sunday_timestamp($ts = 0) {
    if ($ts == 0) $ts = time();
    $weekday = date('w', $ts);
    $sunday_ts = mktime(0, 0, 0, date('m', $ts), date('d', $ts), date('Y', $ts)) - 86400 * $weekday;
    return $sunday_ts;
}

?>