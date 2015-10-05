# 產生靜態地圖 URL #

```
//產生靜態地圖 URL
function get_gmap_url($lat, $lng, $zoom, $width, $height) {
    $google_api_keys = array(
        'default'        => 'ABQIAAAAdkza4eLcoyFpe-8mIi_8phT2yXp_ZAY8_ufC3CFXhHIE1NvwkxTXoP98Y8CGGDPKpXMEeFqP9etLug',
        'localhost'      => 'ABQIAAAAdkza4eLcoyFpe-8mIi_8phT2yXp_ZAY8_ufC3CFXhHIE1NvwkxTXoP98Y8CGGDPKpXMEeFqP9etLug',
        'localhost:8000' => 'ABQIAAAAdkza4eLcoyFpe-8mIi_8phQCULP4XOMyhPd8d_NrQQEO8sT8XBTHijih-LUfQe2_eFbj-MqHbDPMcw',
    );
    $key = isset($google_api_keys[$_SERVER['SERVER_NAME']]) ? $google_api_keys[$_SERVER['SERVER_NAME']] : $google_api_keys['default'];

    return 'http://maps.google.com/staticmap?center='. $lat .','. $lng .
        '&zoom='. $zoom .
        '&size='. $width .'x'. $height .
        '&key='. $key .
        '&markers='. $lat .','. $lng .
        '&sensor=false';
}
```