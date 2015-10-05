# 印出 1~100 不能使用迴圈 #

```
echo join(' ', range(1, 100));
```


# reverse words in a given string #

```
$string = 'abcd efghi jklmno pqrstuvw xyz';
reverse(&$string, 0, strlen($string) - 1);

$lastPos = 0;
for ($i = 0; $i < strlen($string); ++$i) {
  if ($string[$i] == ' ') {
    reverse(&$string, $lastPos, $i - 1);
    $lastPos = $i + 1;
  }
}
reverse(&$string, $lastPos, $i - 1);

function reverse($str, $from, $till) {
  $tmp = '';
  for ($i = $from; $i < ($till - ($till - $from) / 2); ++$i) {
    $tmp = $str[$i];
    $str[$i] = $str[$till - ($i - $from)];
    $str[$till - ($i - $from)] = $tmp;
  }
}

echo '"', $string, '"', "\n";
```