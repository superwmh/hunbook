# Examples #

**這裡的 domain 是指 swf 所在 host，非網頁的 host**

```
<?xml version="1.0"?>
<cross-domain-policy>
  <allow-access-from domain="jsgears.com" />
  <allow-access-from domain="*.jsgears.com" />
  <allow-access-from domain="8.8.4.4" />
</cross-domain-policy>
```

```
<?xml version="1.0"?>
<cross-domain-policy>
  <allow-access-from domain="*" />
</cross-domain-policy>
```