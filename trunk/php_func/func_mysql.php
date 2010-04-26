<?
/*
 * MySQL 函式庫
 */

//db 設定
$db_info = array(
  'MAIN' => array(
    'host'          => 'localhost',
    'user'          => '!!root_or_something!!',
    'pass'          => '!!password_for_user!!',
    'db_name'       => '!!db_name_here!!',
    'encoding'      => 'utf8'
  ),
);

function connsql($db_service_name, $config = '') {
  global $db_info;
  if (trim($db_service_name) == '') return FALSE;
  if (!isset($db_info[$db_service_name])) return FALSE;

  //initial config
  $db_name = (is_array($config) && isset($config['db_name'])) ? $config['db_name'] : (isset($db_info[$db_service_name]['db_name']) ? $db_info[$db_service_name]['db_name'] : '');
  $encoding = (is_array($config) && isset($config['encoding'])) ? $config['encoding'] : (isset($db_info[$db_service_name]['encoding']) ? $db_info[$db_service_name]['encoding'] : '');
  $new_link = (is_array($config) && isset($config['new_link'])) ? $config['new_link'] : TRUE;
  $flags = (is_array($config) && isset($config['flags'])) ? $config['flags'] : 0;

  $db = mysql_connect($db_info[$db_service_name]['host'], $db_info[$db_service_name]['user'], $db_info[$db_service_name]['pass'], $new_link, $flags);
  if (!$db) {
    return FALSE;
  }
  if (version_compare(mysql_get_server_info(), '4.1.0', '>=')) {
    if ($encoding != '') {
      mysql_query('SET NAMES '. $encoding, $db);
    }
  }
  if ($db_name != '') {
    mysql_select_db($db_name, $db);
  }
  return $db;
}

function closesql($db_resource) {
  mysql_close($db_resource);
}

/**
 * Indicates the place holders that should be replaced in _db_query_callback().
 */
define('DB_QUERY_REGEXP', '/(%d|%s|%%|%f|%b|%l)/'); //the last one '%l' stands for 'long' or 'large number'

/**
 * Runs a basic query in the active database.
 *
 * User-supplied arguments to the query should be passed in as separate
 * parameters so that they can be properly escaped to avoid SQL injection
 * attacks.
 *
 * @param $query
 *   A string containing an SQL query.
 * @param ...
 *   A variable number of arguments which are substituted into the query
 *   using printf() syntax. Instead of a variable number of query arguments,
 *   you may also pass a single array containing the query arguments.
 *
 *   Valid %-modifiers are: %s, %d, %f, %b (binary data, do not enclose
 *   in '') and %%.
 *
 *   NOTE: using this syntax will cast NULL and FALSE values to decimal 0,
 *   and TRUE values to decimal 1.
 *
 * @return
 *   A database query result resource, or FALSE if the query was not
 *   executed correctly.
 */
function db_query($db, $query) {
  $args = array_slice(func_get_args(), 2);
  if (isset($args[0]) and is_array($args[0])) { // 'All arguments in one array' syntax
    $args = $args[0];
  }
  _db_query_callback($args, TRUE);
  $query = preg_replace_callback(DB_QUERY_REGEXP, '_db_query_callback', $query);
  $result = mysql_query($query, $db);
  if (!mysql_errno($db)) {
    return $result;
  }
  else {
    return FALSE;
  }
}

/**
 * 單純要組 SQL String 用
 */
function db_query_string($db, $query) {
  $args = array_slice(func_get_args(), 2);
  if (isset($args[0]) and is_array($args[0])) { // 'All arguments in one array' syntax
    $args = $args[0];
  }
  _db_query_callback($args, TRUE);
  return preg_replace_callback(DB_QUERY_REGEXP, '_db_query_callback', $query);
}

/**
 * Helper function for db_query().
 */
function _db_query_callback($match, $init = FALSE) {
  static $args = NULL;
  if ($init) {
    $args = $match;
    return;
  }

  switch ($match[1]) {
  case '%d': // We must use type casting to int to convert FALSE/NULL/(TRUE?)
    return (int) array_shift($args); // We don't need db_escape_string as numbers are db-safe
  case '%s':
    return db_escape_string(array_shift($args));
  case '%%':
    return '%';
  case '%f':
    return (float) array_shift($args);
  case '%b': // binary data
    return db_encode_blob(array_shift($args));
  case '%l': // large number
    return db_large_number(array_shift($args));
  }
}

/**
 * Prepare user input for use in a database query, preventing SQL injection attacks.
 */
function db_escape_string($text) {
  //return mysql_real_escape_string($text); //不要改斜線，遇到字串以斜線結尾的狀況會有問題！
  //return str_replace("'", "''", $text);
  return addslashes($text); //UTF-8 版本可以這樣用
}

/**
 * Returns a properly formatted Binary Large OBject value.
 *
 * @param $data
 *   Data to encode.
 * @return
 *  Encoded data.
 */
function db_encode_blob($data) {
  return "'". mysql_real_escape_string($data) ."'";
}

/**
 * Returns text from a Binary Large Object value.
 *
 * @param $data
 *   Data to decode.
 * @return
 *  Decoded data.
 */
function db_decode_blob($data) {
  return $data;
}

/**
 * 取字串前段有含數字的整數部份回傳
 */
function db_large_number($data) {
  $n = '';
  $len = strlen($data);
  for ($i = 0; $i < $len; $i++) {
    $ch = substr($data, $i, 1);
    if (is_numeric($ch))
      $n .= $ch;
    else
      break;
  }
  if ($n == '') return 0;
  return $n;
}

?>