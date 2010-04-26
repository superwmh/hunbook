<?php
/*
//Sample code
$host = 'www.plurk.com';
$port = 80;
$timeout = 10;
$path = '/TimeLine/addPlurk';
$cookies = "Referer: http://www.plurk.com/a00000\r\nCookie: __utma=220262489.619868788.1215437764.1237376267.1237647434.55; __utmz=220262489.1225240130.37.11.utmccn=(referral)|utmcsr=js.wretch.yahoo.net|utmcct=/iframe.php|utmcmd=referral; __utmb=220262489; plurkcookie=S6im+lDJVx0SdgZofBvydmB5UXs=?banner=STIKLg==&chk=SS0zMDQwMTUyMzcKLg==&user_id=TDM0MzY3NTlMCi4=; __utmc=220262489; plurkcookie1=VtqkLyO8UeFqfjrBgZhB3LvVdBw=?banner=STEKLg==&chk=SS0zMDQwMTUyMzcKLg==&user_id=TDM0MzY3NTlMCi4=";
$data = 'posted="'.date(DATE_ATOM, $ts).'"&qualifier=says&content='.$content.'&lang=tr_ch&no_comments=0&uid=3436759';

$fp = fConnect($host, $port, $timeout);
fPost($fp, $host, $path, $data, $cookies);
file_put_contents('plurk.html', fContentAllTill($fp, '</html>')."\n", FILE_APPEND);
*/

function fConnect($host, $port, $timeout = 10) {
	if ($port == 443) $host = "ssl://$host";
	$fp = fsockopen($host, $port, $errno, $errstr, $timeout);
	if (!$fp) {
		echo "$errstr ($errno)<br />\n";
		exit();
	} else {
		return $fp;
	}
}

function fGet($fp, $host, $path, $extra = '') {
	$getContent = "GET $path HTTP/1.0\r\n";
	$getContent .= "Host: $host\r\n";
	$getContent .= "Accept: */*\r\n";
	$getContent .= "Accept-Language: zh-tw\r\n";
	$getContent .= "User-Agent: ". fRandomUserAgent() ."\r\n";
	$getContent .= "Connection: close";
	if ($extra != "") $getContent .= "\r\n$extra";
	fputs($fp, $getContent."\r\n\r\n");
}

function fPost($fp, $host, $path, $data, $extra = '') {
	$dataLength = strlen($data);
	$postContent = "POST $path HTTP/1.0\r\n";
	$postContent .= "Host: $host\r\n";
	$postContent .= "Content-Type: application/x-www-form-urlencoded\r\n";
	$postContent .= "Content-Length: $dataLength\r\n";
	$postContent .= "User-Agent: ". fRandomUserAgent() ."\r\n";
	$postContent .= "Connection: close";
	if ($extra != "") $postContent .= "\r\n$extra";
	$postContent .= "\r\n\r\n";
	$postContent .= $data;
	fputs($fp, $postContent);
}

function fPostBlogger($fp, $host, $path, $data, $extra = '') {
	$dataLength = strlen($data);
	$postContent = "POST $path HTTP/1.0\r\n";
	$postContent .= "Host: $host\r\n";
	$postContent .= "Content-Type: application/atom+xml\r\n";
	$postContent .= "Content-Length: $dataLength\r\n";
	$postContent .= "User-Agent: ". fRandomUserAgent() ."\r\n";
	$postContent .= "Connection: close";
	if ($extra != "") $postContent .= "\r\n$extra";
	$postContent .= "\r\n\r\n";
	$postContent .= $data;
	fputs($fp, $postContent);
}

function fContent($fp) {
  return fContentAllTill($fp);
}

function fContentAllTill($fp, $till = '') {
	$content = "";
	while ($fp && !feof($fp)) {
		$tmp = fread($fp, 4096);
		if (!$tmp) break;
		$content .= $tmp;
		if ($till != '' && strstr($tmp, $till)) break;
	}
	return $content;
}

function fRandomUserAgent() {
  $user_agents = array('Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.0)',
                       'Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; SV1; .NET CLR 1.1.4322)',
                       'Mozilla/4.0 (compatible; MSIE 7.0; Windows NT 6.0; Trident/4.0; GTB5; Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; SV1) ; SLCC1; .NET CLR 2.0.50727; Media Center PC 5.0; InfoPath.1; .NET CLR 3.0.04506; .NET CLR 3.5.21022)',
                       'Mozilla/5.0 (Windows; U; Windows NT 6.0; en-US) AppleWebKit/525.19 (KHTML, like Gecko) Chrome/1.0.154.53 Safari/525.19',
                       );
  return $user_agents[rand(0, count($user_agents) - 1)];
}

?>