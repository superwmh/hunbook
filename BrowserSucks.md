# Firefox sucks #

  * Change of overflow causes flash repaint!
  * Change of position causes flash repaint!!
  * Change of overflow causes offset properties reset

# IE8 sucks #

  * set link's `href` attribute when content is `!@#`
Before:
```
<a id="link1">!@#</a>
<script>
  $("#link1").attr("href", "http://insanity.go/");
</script>
```
After:
```
<a id=link1 href="http://insanity.go/">http://insanity.go/</a>
```