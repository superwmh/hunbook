<?
/*
 * SQLite 函式庫
 */

//db 設定
$db_info = array(
  'MAIN' => './sqlite_db/main.db',
  'MAIN2' => './sqlite_db/main2.db',
);

function connsql($db_service_name) {
  global $db_info;
  if (trim($db_service_name) == '') return FALSE;
  if (!isset($db_info[$db_service_name])) return FALSE;

  $db = sqlite_open($db_info[$db_service_name], 0666);
  if (!$db) {
    return FALSE;
  }
  return $db;
}

function closesql($db_resource) {
  sqlite_close($db_resource);
}

function db_query($db, $query) {
  return sqlite_query($db, $query);
}

?>