# GET #

```
$ch = curl_init("https://www.google.com/");
curl_setopt($ch, CURLOPT_HEADER, 1);
curl_setopt($ch, CURLOPT_POST, 0);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
//curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 1);
//curl_setopt($ch, CURLOPT_CAPATH, "D:/Tmp/certs");
//curl_setopt($ch, CURLOPT_CAINFO, "D:/Tmp/certs/google.cer");
$output = curl_exec($ch);

if (curl_error($ch)) {
    echo curl_error($ch);
}
curl_close($ch);
```

# POST #

```
$data = "Email=example@gmail.com&Passwd=YOURPASS&service=analytics&accountType=GOOGLE&source=jsg-ga-01";

$ch = curl_init("https://www.google.com/accounts/ClientLogin");
curl_setopt($ch, CURLOPT_HEADER, 0);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_COOKIEFILE, $cookie_file);
curl_setopt($ch, CURLOPT_COOKIEJAR, $cookie_file);

$output = curl_exec($ch);
curl_close($ch);
```

# SSL #

```
//針對 SSL 連線
//curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);  //不檢查 SSL 憑證是否有效
//curl_setopt($ch, CURLOPT_CAINFO, 'D:/Server/curl-7.19.4/versign_s.cer');  //直接指定 CA Cert
//curl_setopt($ch, CURLOPT_CAINFO, 'D:/Server/curl-7.19.4/curl-ca-bundle.crt'); // CA Bundle
```