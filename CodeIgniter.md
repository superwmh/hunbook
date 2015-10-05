# Sytem Fixes #

## DB\_driver.php ##

```
var $save_queries        = FALSE;  //預設值改為 FALSE，避免大量 query 時浪費記憶體
```

## query string ##

```
// 這樣設置就不會限制 query 一定要兩個參數
$config['uri_protocol']	= "PATH_INFO";
```

# Snippets #


## database ##

```
$query = $this->db->query($sql);

//取得筆數
$query->num_rows();

//取得一筆
$row = $query->row_array();

//result loop
foreach ($query->result_array() as $row) {

}

//取出其他設定檔
$this->dbForum = $this->load->database('forum', TRUE);

//大量 query 時不要存 sql 語法
$this->db->save_queries = FALSE;

//http://codeigniter.com/user_guide/database/helpers.html
$this->db->insert_id();      //新增的 id
$this->db->affected_rows();
$this->db->last_query();     //save_queries = TRUE 才有用

//runtime 改設定
$this->db = $this->load->database('default', TRUE); // load 進來
$this->db->database = "production_db";  // 改設定
$this->db->conn_id = NULL;              // 清掉 connect id
$this->db->initialize();                // 重新 connect
```

## config ##
```
//primary config
echo $this->config->item('base_url'), "<hr />";

//load custom config file
$this->config->load('test1');
echo $this->config->item('test_desc'), "<hr />";

//to avoid collisions
$this->config->load('test2', TRUE);
echo $this->config->item('test_desc'), "<hr />";            //from test1
echo $this->config->item('test_desc', 'test2'), "<hr />";   //from test2
```


## Form Validation ##

```
$this->load->library('form_validation');
$this->form_validation->set_rules('name', '姓名', 'required|trim|strip_tags|min_length[1]|max_length[20]|xss_clean');
$this->form_validation->set_rules('tel2', '行動電話', 'required|trim|strip_tags|min_length[10]|max_length[10]|xss_clean|numeric');
$this->form_validation->set_rules('tel1', '市內電話', 'required|trim|strip_tags|min_length[8]|max_length[17]|xss_clean');
$this->form_validation->set_rules('email', 'Email', 'required|trim|strip_tags|min_length[1]|max_length[100]|xss_clean|valid_email');
if ($this->form_validation->run()) {
  $contact['user_id'] = $this->member_data['uid'];
  $contact['status']  = 1;
  $contact['cid']      = $this->input->post('cid', TRUE);
  $contact['name']    = $this->input->post('name', TRUE);
  $contact['tel2']    = $this->input->post('tel2', TRUE);
  $contact['tel1']    = $this->input->post('tel1', TRUE);
  $contact['email']   = $this->input->post('email', TRUE);
  $cid = $this->mod_member_contact->save_contact($contact);

  if ($cid > 0) {
    echo json_encode(array('cid' => $cid));
  }elseif($cid == -1) {
    echo json_encode(array('err' => '此連絡人已存在，不可重覆新增.'));
  }else{
    echo json_encode(array('err' => '不明的錯誤，請稍後再試.'));
  }
} else {
  echo json_encode(array('err' => validation_errors('* ', ' *')));
}
```

## CLI ##

```
<?php

if (isset($_SERVER['SERVER_ADDR']) || isset($_SERVER['REMOTE_ADDR'])) {
    echo 'no web access';
    exit;
}

ini_set('max_execution_time','0');
set_time_limit(0);
ini_set('memory_limit', '256M');

$_SERVER['PATH_INFO']    = $argv[1];
$_SERVER['QUERY_STRING'] = $argv[1];

require dirname(__FILE__).'/index.php';

/**
* Usage: $ php cli.php controller/action[/parameters]
*/

?>
```

# rewrite rule #

```
RewriteEngine On
RewriteCond $1 !^(index\.php|robots\.txt|swf|images|css|js)
RewriteRule ^(.*)$ index.php/$1 [L]
Options All -Indexes
```

# Patches #

## SQL\_CALC\_FOUND\_ROWS ##

  * DB\_active\_rec.php
```
//Line 31:
var $ar_sql_calc_found_rows	= FALSE;

//Line 1781:
if ($this->ar_sql_calc_found_rows) {
    $sql .= "SQL_CALC_FOUND_ROWS ";
}

//Line 2114:
'ar_sql_calc_found_rows' => FALSE,

//Line 2145:
function sql_calc_found_rows($val = TRUE)
{
    $this->ar_sql_calc_found_rows = (is_bool($val)) ? $val : TRUE;
    return $this;
}
```


# 缺點 #
  * DB Library 設計不良，取出大量 result set 時速度慢且浪費記憶體
  * Controller 和 Model 命名不可相同，否則會相衝！
  * Active Record 的用法有危險的陷阱
  * Library 用法已遠離原始的 OO
  * default Log Level 不符合一般習慣