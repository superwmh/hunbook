# 403 Forbidden #

```
function http403() {
    header('HTTP/1.1 403 Forbidden');
    echo '<!DOCTYPE html><html><head><title>403 Forbidden</title></head><body><p>too fast</p></body></html>';
}
```