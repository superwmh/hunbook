# AJAX Request Header #

```
[HTTP_X_REQUESTED_WITH] => XMLHttpRequest
```

```
$AJAX = (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] === 'XMLHttpRequest');
```


# IE XSS Filter #

```
// disable it
header("X-XSS-Protection: 0");

// block page
header("X-XSS-Protection: 1; mode=block");
```