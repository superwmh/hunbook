# Examples #

## Some patterns ##

```
Require : /.+/,
Email : /^\w+([-+.]\w+)*@\w+([-.]\w+)*\.\w+([-.]\w+)*$/,
//tel : /^((\(\d{2,3}\))|(\d{3}\-))?(\(0\d{2,3}\)|0\d{2,3}-)?[1-9]\d{6,7}(\-\d{1,4})?$/,
Mobile : /^[0-9]*$/,
Url : /^http:\/\/[A-Za-z0-9]+\.[A-Za-z0-9]+[\/=\?%\-&_~`@[\]\':+!]*([^<>\"\"])*$/,
IdCard : "this.IsIdCard(value)",
Currency : /^\d+(\.\d+)?$/,
Number : /^\d+$/,
Zip : /^[1-9]\d{5}$/,
QQ : /^[1-9]\d{4,8}$/,
Integer : /^[-\+]?\d+$/,
Double : /^[-\+]?\d+(\.\d+)?$/,
English : /^[A-Za-z]+$/,
Chinese :  /^[\u0391-\uFFE5]+$/,
Username : /^[a-z]\w{3,}$/i,
UnSafe : /^(([A-Z]*|[a-z]*|\d*|[-_\~!@#\$%\^&\*\.\(\)\[\]\{\}<>\?\\\/\'\"]*)|.{0,5})$|\s/,
```

```
中文字符：[\u4e00-\u9fa5]
雙字節字符：[^\x00-\xff]
單字節字符：[\x00-xff]
```

## Simple match ##

```
//Find Spider-Man, Spiderman, SPIDER-MAN, etc.
var dailybugle = "Spider-Man Menaces City!";
 
//regex must match entire string
var regex = /spider[- ]?man/i;
 
if (dailybugle.search(regex)) {
  //do something
}
```

## Match and capture group ##

```
//Match dates formatted like MM/DD/YYYY, MM-DD-YY,...
var date = "12/30/1969";
var p = new RegExp("^(\\d\\d)[-/](\\d\\d)[-/](\\d\\d(?:\\d\\d)?)$");
 
var result = p.exec(date);
if (result != null) {
  var month = result[1];
  var day = result[2];
  var year = result[3];
}
```

## Simple substitution ##

```
//Convert <br> to <br /> for XHTML compliance
String text = "Hello world. <br>";
var pattern = /<br>/ig;
test.replace(pattern, "<br />");
```

## Harder substitution ##

```
//urlify - turn URLs into HTML links
var text = "Check the web site, http://www.oreilly.com/catalog/regexppr.";
var regex =
    "\\b"                                    // start at word boundary
  + "("                                      // capture to $1
  + "(https?|telnet|gopher|file|wais|ftp) :" // resource and colon
  + "[\\w/\\#~:.?+=&%@!\\-]+?"               // one or more valid chars 
                                             // take little as possible
  + ")"
  + "(?="                                    // lookahead
  + "[.:?\\-]*"                              // for possible punct
  + "(?:[^\\w/\\#~:.?+=&%@!\\-]"             // invalid character
  + "|$)"                                    // or end of string
  + ")";
text.replace(regex, "<a href=\"$1\">$1</a>");
```

# JavaScript character representations #

```
\0 Null character, \x00.
\b Backspace, \x08; supported only in character class.
\n Newline, \x0A.
\r Carriage return, \x0D.
\f Form feed, \x0C.
\t Horizontal tab, \x09.
\t Vertical tab, \x0B.
\xhh Character specified by a two-digit hexadecimal code.
\uhhhh Character specified by a four-digit hexadecimal code.
\cchar Named control character.
```

# JavaScript character classes and class-like constructs #

```
[...] A single character listed, or contained within a listed range.
[^...] A single character not listed, and not contained within a listed range.
. Any character except a line terminator, [^\x0A\x0D\u2028\u2029].
\w Word character, [a-zA-Z0-9_].
\W Nonword character, [^a-zA-Z0-9_].
\d Digit character, [0-9].
\D Nondigit character, [^0-9].
\s Whitespace character.
\S Nonwhitespace character.
```

# JavaScript anchors and other zero-width tests #

```
^ Start of string, or the point after any newline if in multiline match mode, /m.
$ End of search string, or the point before a string-ending
newline, or before any newline if in multiline match mode, /m.
\b Word boundary.
\B Not-word-boundary.
(?=...) Positive lookahead.
(?!...) Negative lookahead.
```

# JavaScript mode modifiers #

```
m ^ and $ match next to embedded line terminators.
i Case-insensitive match.
```

# JavaScript grouping, capturing, conditional, and control #

```
(...) Group subpattern, and capture submatch, into \1,\2,... and
$1, $2,....
\n In a regular expression, contains text matched by the nth
capture group.
$n In a replacement string, contains text matched by the nth
capture group.
(?:...) Group subpattern, but do not capture submatch.
...|... Try subpatterns in alternation.
* Match 0 or more times.
+ Match 1 or more times.
? Match 1 or 0 times.
{n} Match exactly n times.
{n,} Match at least n times.
{x,y} Match at least x times, but no more than y times.
*? Match 0 or more times, but as few times as possible.
+? Match 1 or more times, but as few times as possible.
?? Match 0 or 1 time, but as few times as possible.
{n}? Match at least n times, but as few times as possible.
{x,y}? Match at least x times, no more than y times, and as few times
as possible.
```