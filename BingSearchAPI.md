
```
// Replace this value with your account key
$accountKey = 'AAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA=';

$ServiceRootURL =  ‘https://api.datamarket.azure.com/Bing/Search/';

$WebSearchURL = $ServiceRootURL . 'Image?$format=json&Query=';

$context = stream_context_create(array(
    'http' => array(
        'proxy' => 'tcp://127.0.0.1:8888',
        'request_fulluri' => true,
        'header'  => "Authorization: Basic " . base64_encode($accountKey . ":" . $accountKey)
    )
));

$request = $WebSearchURL . urlencode( '\'' . $_POST["searchText"] . '\'');

echo($request);

$response = file_get_contents($request, 0, $context);

$jsonobj = json_decode($response);

```