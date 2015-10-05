# 雙語版 NodeJS + Rhino #
```
/*jslint evil: true */
if (typeof require !== "undefined" && toString.call(require) === "[object Function]") {
    //  Rhino shim for node.js
    var jslint_content = '',
        fs = require('fs'),
        sys = require('sys'),
        readFile = function (name) {
            return fs.readFileSync(name).toString();
        },
        print = function (message) {
            sys.puts(message);
        },
        quit = function (code) {
            process.exit(code);
        };
    //print("[DEBUG] using nodejs");
    eval(readFile(__dirname + '/jslint/jslint.js'));
    run(process.argv.slice(2));

} else {
    //print("[DEBUG] using rhino");
    load('/PATH/TO/YOUR/jslint/jslint.js');
    run(arguments);
}

// This is the Rhino companion to fulljslint.js.
function run(a) {
    var e, i, input;
    if (!a[0]) {
        print("Usage: jslint.js file.js");
        quit(1);
    }
    input = readFile(a[0]);
    if (!input) {
        print("jslint: Couldn't open file '" + a[0] + "'.");
        quit(1);
    }
    if (!JSLINT(input, {'continue': true, eqeq: false, node: true, nomen: true,
            vars: false, plusplus: true, regexp: true, rhino: true,
            sloppy: true, undef: false, white: true})) {
        for (i = 0; i < JSLINT.errors.length; i += 1) {
            e = JSLINT.errors[i];
            if (e) {
                print('Lint at line ' + e.line + ' character ' +
                        e.character + ': ' + e.reason);
                print((e.evidence || '').
                        replace(/^\s*(\S*(\s+\S+)*)\s*$/, "$1"));
                print('');
            }
        }
        quit(2);
    } else {
        if (!(a[1] && a[1] === '-q')) {
            print("jslint: No problems found in " + a[0]);
        }
        quit();
    }
}
```

# Installation on windows #

## jslint.bat ##
```
@java -jar D:\java\rhino1_7R2\js.jar D:\bat\jslint-rhino.js %1
```

```
// usage
jslint myfile.js
```

# Problems #

## Problem at line xx character xx: Read only. ##

  * **問題：**因為想在 closure 內共用 global 的變數，又不確定該 global 變數是否已存在，所以使用以下寫法：
```
/*global CONST
*/
(function () {
    CONST = CONST || {};
}());
```

  * **解法：**改用內部變數先接 global 變數，最後再丟回給 window
```
/*global window
*/
(function () {
    var CONST = window.CONST || {};
    //...
    window.CONST = CONST;
}());
```

## array loop ##

  * **問題：** jslint 不准在 loop 語法內直接取 array 長度、各變數又要先定義，所以為了 array loop 得定義多個變數，loop 有兩層就囉唆了
```
function array_sum (arr) {
    var i, len = arr.length;
    for (i = 0; i < len; i += 1) {
        // do something
    }
}
```

  * **解法：**改用 js framework 的 each() 可解決
```
function array_sum (arr) {
    // jQuery 版
    $.each(arr, function (val) {
        // do something
    });

    //YUI 版
    Y.each(arr, function (val) {
        // do something
    });
}
```

  * **缺點**：
    * 多了很多的 function call，效能會變差
    * 不適合在 loop 一半會有跳出的情況使用 (應該是吧，因為是 framework 在 loop...)