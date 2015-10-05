# Google Analytics #

```
(function() {
  var ga = document.createElement('script');
  ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
  ga.setAttribute('async', 'true');
  document.documentElement.firstChild.appendChild(ga);
})();
```


# Sprite Me #

```
(function(){
  spritemejs=document.createElement('SCRIPT');
  spritemejs.type='text/javascript';
  spritemejs.src='http://spriteme.org/spriteme.js';
  document.getElementsByTagName('head')[0].appendChild(spritemejs);
})();
```

# XRay #

```
function loadScript(scriptURL) {
  var scriptElem = document.createElement('SCRIPT'); 
  scriptElem.setAttribute('language', 'JavaScript'); 
  scriptElem.setAttribute('src', scriptURL); 
  document.body.appendChild(scriptElem);
}
loadScript('http://westciv.com/xray/thexray.js');
```

# giveMeY #

```
/*global window, document, alert, YUI
*/
(function () {
    if (typeof window.Y !== 'undefined') {
        alert('Y is already defined!');
        return false;
    }
    if (typeof YUI === 'function' && typeof YUI().version === 'string') {
        YUI().use('node', function (Y) {
            window.Y = Y;
            alert('YUI ' + YUI().version + ' is ready for you!');
        });
        return false;
    }
    var giveMeY, js = document.createElement('script');
    giveMeY = function () {
        YUI().use('node', function (Y) {
            window.Y = Y;
            alert('YUI ' + YUI().version + ' is ready for you!');
        });
    };
    js.setAttribute('type', 'text/javascript');
    js.setAttribute('src', 'http://yui.yahooapis.com/3.1.0/build/yui/yui-min.js');
    document.getElementsByTagName('head')[0].appendChild(js);
    js.onreadystatechange = function () {
        if (js.readyState === 'complete') {
            giveMeY();
        }
    };
    js.onload = function () {
        giveMeY();
    };
}());
```

# giveMe$ #

```
/*global window, alert, document, $
*/
(function () {
    if (typeof window.$ !== 'undefined') {
        if ($.fn && $.fn.jquery) {
            alert('jQuery ' + $.fn.jquery + ' is already loaded!');
        } else {
            alert('$ is already defined!');
        }
        return false;
    }
    var giveMe$, js = document.createElement('script');
    giveMe$ = function () {
        alert("jquery " + $.fn.jquery + " is ready for you.");
    };
    js.setAttribute('type', 'text/javascript');
    js.setAttribute('src', 'http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js');
    document.getElementsByTagName('head')[0].appendChild(js);
    js.onreadystatechange = function () {
        if (js.readyState === 'complete') {
            giveMe$();
        }
    };
    js.onload = function () {
        giveMe$();
    };
}());
```

# giveMeYUI2Logger #

```
/*global YAHOO, alert, document
*/
(function () {
    if (typeof YAHOO === 'undefined') {
        alert('You need to load YUI2 before using Logger!');
        return false;
    }
    if (typeof YAHOO.widget.LogReader !== 'undefined') {
        alert('Logger is aleady loaded!');
        return false;
    }
    var body, head, css, js, callback;
    callback = function () {
        var logger, loggerDiv;
        if (YAHOO.widget.LogReader) {
            loggerDiv = document.createElement('div');
            loggerDiv.id = "loggerDiv" + (parseInt(Math.random() * 900000, 10) + 100000);
            loggerDiv.style.cssFloat = "right";
            loggerDiv.style.styleFloat = "right";
            body.insertBefore(loggerDiv, body.firstChild);
            logger = new YAHOO.widget.LogReader(loggerDiv.id);
            alert("Logger is ready for you.");
        }
    };
    head = document.getElementsByTagName('head')[0];
    body = document.getElementsByTagName('body')[0];
    css = document.createElement('link');
    css.setAttribute('type', 'text/css');
    css.setAttribute('rel', 'stylesheet');
    css.setAttribute('href', 'http://yui.yahooapis.com/2.8.0r4/build/logger/assets/skins/sam/logger.css');
    head.appendChild(css);
    js = document.createElement('script');
    js.setAttribute('type', 'text/javascript');
    js.setAttribute('src', 'http://yui.yahooapis.com/2.8.0r4/build/logger/logger-min.js');
    head.appendChild(js);
    js.onreadystatechange = function () {
        if (js.readyState === 'complete') {
            callback();
        }
    };
    js.onload = function () {
        callback();
    };
}());
```