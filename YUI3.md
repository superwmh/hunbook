
# Snippets #

## jQuery in YUI ##
```
YUI({
    modules: {
       jquery: {
           fullpath: 'http://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js'
       }
    }

}).use('jquery', function(Y) {

  $(function() {
    $('#demo').append('<div class="jq">jQuery !!!</div>');
  });

});
```

## widget ##
```
/*global YUI */

/**
 * <p>Makes a container scrollable using either mouse wheel or up/down button.</p>
 *
 * @module scroller
 * @class Scroller
 * @requires dom, node, event
 */
YUI.add("scroller", function (Y) {

    var A,
        B,
        CONST,
        getClassName = Y.ClassNameManager.getClassName;

    /**
     * Constant used to refer something
     *
     * @property CONST
     * @static
     * @type String
     */
    CONST = {
        A   : "aaa",
        B   : "bbb"
    };

    /**
     * <p>Makes a container scrollable using either mouse wheel or up/down button.</p>
     *
     * @constructor
     * @class Scroller
     * @param {Object} attrs Object liternal containing configuration parameters.
     */
    function Scroller(config) {
        Scroller.superclass.constructor.apply(this, arguments);
    }

    Scroller.NAME = "scroller";
    Scroller.NS   = "scroller";

    /**
     * Static property used to define the default attribute
     * configuration for the Scroller.
     *
     * @property Scroller.ATTRS
     * @type Object
     * @static
     */
    Scroller.ATTRS = {

        /**
        * Indicating the current mode of the scroller.
        *
        * @attribute mode
        * @type String
        */
        mode : {
            value : CONST.A
        }

    };

    Y.extend(Scroller, Y.Widget, {

        initializer: function (config) {
        },
        destructor : function () {
        },

        /**
         * Rendering mini unit to the layout.
         *
         * This method is called by framework.
         *
         * @method renderUI
         * @protected
         */
        renderUI : function () {
        },
        /**
         * Binding event handlers to the layout elements.
         *
         * This method is called by framework.
         *
         * @method bindUI
         * @protected
         */
        bindUI : function () {
        },
        syncUI : function () {
        }

    });

    Y.Scroller = Scroller;

}, "1.0.0", {requires: ["dom", "node", "event"], optional: ["anim"]});
```

# mistakes #

## new object instance ##
```
// Chrome:
Uncaught TypeError: Cannot call method 'apply' of undefined

// FireFox:
this.init is undefined
```

以上問題可能是因為在產生物件時，少打了 `new`

```
// 錯
var router = Y.RouterAPI();

// 正確
var router = new Y.RouterAPI();
```

# tips #

## Async get script ##

```
Y.Get.script(url, {
  attributes : {
    async: "true"
  }
});
```

# 地雷 #

  * `Y.each` 在 YUI 3.0.0 的版本不會忽略 `null`
  * 在 iframe 內用 `onreadystatechange` 模擬 `DOMReady`，但是 crossdomain 的情況可能產生問題，導致 event 未被 trigger
  * 若 include `widget-base-ie.js` 且用 `YUI.use` 用 `*` 載入，則反而會造成其他瀏覽器的錯誤
  * YUI 3.3.0 新增的 `show()`/`hide()` 只會針對 inline display style 去判斷，不實用！
  * YUI 3.2 grids
    * 用百分比算格子寬度的方式，在不同瀏覽器會有不同結果（進位方式不同）
    * 在 IE7，resize layout 寬度時，裡面 float 物件的 margin 可能會消失

# Fixes #
## YUI 3.2.0 ##
### `YUI.use("*")` + `getComputedStyle` issue in IE ###
```
    /**
     * Returns the computed style for the given node.
     * @method getComputedStyle
     * @param {HTMLElement} An HTMLElement to get the style from.
     * @param {String} att The style property to get.
     * @return {String} The computed value of the style property.
     */
    getComputedStyle: function(node, att) {
        var val = '',
            doc = node[OWNER_DOCUMENT];

        if (node[STYLE] && doc[DEFAULT_VIEW] && doc[DEFAULT_VIEW][GET_COMPUTED_STYLE]) {
            val = doc[DEFAULT_VIEW][GET_COMPUTED_STYLE](node, null)[att];
        } else if (Y.DOM[GET_COMPUTED_STYLE]) {
            val = Y.DOM[GET_COMPUTED_STYLE](node, att);
        }
        return val;
    }
```


# 十個不要用 YUI 的理由 #
  * 用 YUI 沒有比較快
  * 用 YUI 都在幫 YUI 解 bug
  * YUI 沒什麼人在用
  * 4
  * 5
  * 6
  * 7
  * 8
  * 9
  * 10