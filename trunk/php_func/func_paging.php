<?
/*
 * Paging 分頁函式庫
 */

$CONST_ITEMS_PER_PAGE = 10;   //items per page
$CONST_SHOW_PAGES     = 20;   //一次顯示 20 個分頁

//取得開頭的筆數
function paging_row_start($p, $show_records) {
  return ($p - 1) * $show_records;
}

//取得前一次查詢的所有筆數
function paging_get_rows($db_link) {
  $rows_result = mysql_fetch_row(mysql_query('SELECT FOUND_ROWS()', $db_link));
  return $rows_result[0];
}

//取得分頁連結的區塊
//$rows         總筆數
//$p            目前頁面
//$show_records 一頁顯示筆數
//$query_string 未包含分頁的連結
function paging_get_block($rows, $p, $show_records, $query_string_template)
{
  global $CONST_SHOW_PAGES;

  $total_pages = intval(($rows - 1) / $show_records) + 1;
  if ($p == "" || $p < 1 || $p > $total_pages) $p = 1;
	$show_page_from = $p - ($CONST_SHOW_PAGES / 2);
	if ($show_page_from < 1) $show_page_from = 1;
	$show_page_to = $show_page_from + ($CONST_SHOW_PAGES - 1);
	if ($show_page_to > $total_pages) $show_page_to = $total_pages;
	$show_page_from = $show_page_to - ($CONST_SHOW_PAGES - 1);
	if ($show_page_from < 1) $show_page_from = 1;

	$pages = "";
	for ($i = $show_page_from; $i <= $show_page_to; $i++)	{
	  $query_string = str_replace('{PAGE}', $i, $query_string_template);
		if ($i == $p)
			$pages .= ("<span>$i</span>");
		else
			$pages .= ("<span><a href=\"{$query_string}\">$i</a></span>");
	}
	if ($p > 1) {
	  $first_page = str_replace('{PAGE}', 1, $query_string_template);
	  $previous_page = str_replace('{PAGE}', $p - 1, $query_string_template);
		$pages = "<span><a href=\"{$first_page}\" class=\"page_controller\">&lt;&lt;</a></span>".
				 "<span><a href=\"{$previous_page}\" class=\"page_controller\">&lt;</a></span>".$pages;
	}
	if ($p < $total_pages) {
	  $next_page = str_replace('{PAGE}', $p + 1, $query_string_template);
		$last_page = str_replace('{PAGE}', $total_pages, $query_string_template);
		$pages = $pages."<span><a href=\"{$next_page}\" class=\"page_controller\">&gt;</a></span>";
		$pages = $pages."<span><a href=\"{$last_page}\" class=\"page_controller\">&gt;&gt;</a></span>";
	}
  return $pages;
}


?>