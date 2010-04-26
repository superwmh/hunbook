<?
/*
 * Google News 函式庫
 */

//把 Google 轉址的部份去掉
function gnews_get_link($str) {
  $data = split('&amp;', $str);
  foreach ($data as $d) {
    if (strpos($d, 'url=') === 0) {
      return urldecode(substr($d, 4));
    }
  }
  return '';
}

//把 html tag 濾掉
function gnews_get_content($str) {
  return strip_tags(substr($str, strrpos($str, '<br>')));
}

//判斷是否有需要過濾的新聞
function gnews_has_filter_string($str) {
  $filter_strings = array('則相關新聞',
      '特偵組', '扁密帳', '扁家', '扁辦', '陳水扁', '陳前總統', '吳淑珍', '陳幸妤',
      '屍', '製毒', '妓女', '命案');
  foreach ($filter_strings as $filter) {
    if (strpos($str, $filter) !== FALSE) return TRUE;
  }
  return FALSE;
}

//(DEPRECIATED, 改用分數判斷) 判斷內容是否有特定的關鍵字，在存入 DB 前判斷用
function gnews_has_relative_string($str, $array_relative_str) {
  foreach ($array_relative_str as $relative_str) {
    if (strpos($str, $relative_str) !== FALSE) return TRUE;
  }
  return FALSE;
}

//用分數判斷新聞的分數
function gnews_check_keyword_score($title, $content) {
  global $fetch_keywords_all, $other_keywords;

  $score = 0;

  //主旨給 3 分、內容給 1 分
  foreach ($fetch_keywords_all as $keyword) {
    if (strpos($title, $keyword) !== FALSE) $score += 3;
    if (strpos($content, $keyword) !== FALSE) $score += 1;
  }
  //其他關鍵字僅針對內容給分
  foreach ($other_keywords as $keyword) {
    if (strpos($title, $keyword) !== FALSE) $score += 1;
    if (strpos($content, $keyword) !== FALSE) $score += 1;
  }

  return $score;
}

function _gnews_prepare_emphasis_keyword($keyword) {
  return '<em>'.$keyword.'</em>';
}

//把關鍵字加強顯示
function gnews_emphasis_keywords($str) {
  global $fetch_keywords_all;
  $emphasis_keywords = array_map('_gnews_prepare_emphasis_keyword', $fetch_keywords_all);
  return str_replace($fetch_keywords_all, $emphasis_keywords, $str);
}



?>