# prepare dir #

```
//傳入要存檔的檔名，此函數自動建立必須的目錄
function _prepare_dir($save_file) {
  if (file_exists(dirname($save_file))) {
    return;
  } else {
    _prepare_dir(dirname($save_file));
    mkdir(dirname($save_file));
  }
}
```

# reading a file line by line #

```
$file = "test.txt";
if (!$fp = fopen($file, 'rb')) {
  echo "Can not read the file!\n";
  return FALSE;
}
flock($fp, LOCK_SH);

while ($line = fgets($fp, 10240)) {

}

flock($fp, LOCK_UN);
fclose($fp);
```

# load cache file #

```
<?php

load_cache('test1');
load_cache('test2');
echo 'test1: ', $test1, "\n";
echo 'test2: ', $test2, "\n";

function load_cache($cache_file) {
  $fullentry = dirname(__FILE__) .'/caches/'. $cache_file .'.php';
  $regen = TRUE;
  if (file_exists($fullentry)) {
    $mtime = filemtime($fullentry);
    if ($mtime > (time() - mt_rand(60, 90))) {
      $regen = FALSE;
    }
  }

  if ($regen) {
    echo $cache_file, " regen!\n";
    file_put_contents($fullentry,
      "<?php\n".
      "global \$cache_file;\n".
      "\$cache_file = ". var_export(time(), TRUE) .";\n".
      "?>"
    );
  }

  require $fullentry;
}

?>
```

# main template/sub view #

```
<?php
$page = array(
    'title' => 'This is default page content',
    'content' => 'Default content',
);

if ($_GET['t'] == 1) {
    $page['title'] = 'Content1';
    $page['content1'] = 'This is content1';
    $page['content'] = loadview($_GET['t'], $page);
}

function loadview($id, $page) {
    ob_start();
    require 'content'.$id.'.php';
    $buffer = ob_get_contents();
    @ob_end_clean();
    return $buffer;
}
?>
<html>
<head>
<title><?php echo $page['title']; ?></title>
</head>

<body>
<p>header</p>

<?php
echo $page['content'];
?>

<p>footer</p>
</body>
</html>
```

```
<div id="test" style="border: 1px solid red;">
<?php
echo $page['content1'];
?>
</div>
```