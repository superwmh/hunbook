# my\_json\_encode #

```
//my JSON_UNESCAPED_UNICODE implementation of json_encode
function my_json_encode($var) {
    if (!is_array($var)) {
        //return '"'. str_replace(array('"', '\\', '/'), array('\"', '\\\\', '\\/'), $var) . '"';   // PHP compatible
        return '"'. str_replace(array('"', '\\'), array('\"', '\\\\'), $var) . '"';                 // YUI compatible
    }
    if (is_assoc($var)) {
        $rtn = "";
        foreach ($var as $k => $v) {
            if ($rtn !== "") {
                $rtn .= ",";
            }
            $rtn .= '"' . $k . '":' . my_json_encode($v);
        }
        return '{' . $rtn . '}';
    } else {
        $rtn = "";
        foreach ($var as $v) {
            if ($rtn !== "") {
                $rtn .= ",";
            }
            $rtn .= my_json_encode($v);
        }
        return '[' . $rtn . ']';
    }
}
function is_assoc($arr) {
    return (is_array($arr) && count(array_filter(array_keys($arr),'is_string')) == count($arr));
}
```

# utf-8 to big5 entity #

```
mb_substitute_character("long");
//mb_regex_encoding('BIG-5');
echo '&#'.hexdec(str_replace('U+', '', mb_convert_encoding("雫", 'BIG-5', 'UTF-8'))) .';<br />';
```


# safe\_utf8\_big5 #

```
/*
 * UTF8->BIG5, 把 big5 不存在的字轉為 entity
 */
function safe_utf8_big5($str) {
  if ($str == '') return '';
  $big5 = iconv('UTF-8', 'BIG5', $str);
  $big5_len = mb_strlen($big5, 'BIG5');
  $utf8_len = mb_strlen($str, 'UTF-8');
  if ($big5_len == $utf8_len) {
    return $big5;
  }
  mb_substitute_character("long");
  $problem_char = mb_substr($str, $big5_len, 1, 'UTF-8');
  $entity = '&#'.hexdec(str_replace('U+', '', mb_convert_encoding($problem_char, 'BIG-5', 'UTF-8')));

  return $big5 . $entity . safe_utf8_big5(mb_substr($str, $big5_len + 1, $utf8_len - $big5_len - 1, 'UTF-8'));
}
```


# urlsafe\_b64encode #

```
function urlsafe_b64encode($string) {
    $data = base64_encode($string);
    $data = str_replace(array('+', '/', '='), array('-', '_', '.'), $data);
    return $data;
}
function urlsafe_b64decode($string) {
    $data = str_replace(array('-', '_', '.'), array('+', '/', '='), $string);
    $mod4 = strlen($data) % 4;
    if ($mod4) {
        $data .= substr('====', $mod4);
    }
    return base64_decode($data);
}
```


# num2entities #

```
// 把數字(電話號碼)改為html實體，避免被搜尋引擎收錄
// 前端依然可以正常顯示，但原始碼會變成HTML實體（如：&#48;）
// @string $str：電話號碼
function num2entities($str) {
  $to = array(
    '0'   =>  '&#48;', 
    '1'   =>  '&#49;',
    '2'   =>  '&#50;', 
    '3'   =>  '&#51;',
    '4'   =>  '&#52;', 
    '5'   =>  '&#53;', 
    '6'   =>  '&#54;',
    '7'   =>  '&#55;', 
    '8'   =>  '&#56;', 
    '9'   =>  '&#57;', 
    '-'   =>  '&#45;', 
    '#'   =>  '&#35;',
    '*'   =>  '&#42;',
  );
  return strtr($str, $to);
}
```

# Check UTF8 BOM #

```
  function check_utf8_bom($mute = 1) {
    $dir = APPPATH;
    $this->check_utf8_bom_dir($dir, $mute);
    echo "\n";
  }
  function check_utf8_bom_dir($dir, $mute) {
    $d = dir($dir);
    $cnt = 0;
    while (false !== ($entry = $d->read()) && $cnt < 10000) { //最多處理 1 萬筆
      if ($entry == '.' || $entry == '..') continue;
      $fullpath = $dir.$entry;
      if (is_dir($fullpath)) {
        $this->check_utf8_bom_dir($fullpath.'/', $mute);

      } else if ($fp = fopen($fullpath, 'r')) {
        $line = fgets($fp, 20);
        if (strpos($line, "\xef\xbb\xbf") === 0) {
          echo "\n", $fullpath;
        } else if ($mute == 0) {
          echo '.';
        }
      }
      ++$cnt;
    }
    if ($mute == 0)
      echo "\n";
  }
```

# get\_utf8\_basename #

```
// 若路徑有中文，不能直接用 basename() 去取
function get_utf8_basename($str) {
    $last_slash = mb_strrpos($str, "/", "utf-8");
    return mb_substr($str, ++$last_slash, mb_strlen($str, "utf-8"), "utf-8");
}
```