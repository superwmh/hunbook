# Examples #

## Quick Examples ##

```
$data = "11<b>22</b>33<b>44</b>55";
 
$p = "/<b>(.+)<\/b>/";        //greedy:22</b>33<b>44
$p = "/<b>(.+?)<\/b>/";       //lazy  :22
 
$p = "/<b>(.+?)<\/b>/";       //44
$p = "/<b>(.+?)<\/b>/s";      //2\n2
```

## Simple match ##

```
//Find Spider-Man, Spiderman, SPIDER-MAN, etc.
$dailybugle = "Spider-Man Menaces City!";
 
$regex = "/spider[- ]?man/i";
 
if (preg_match($regex, $dailybugle)) {
  //do something
}
```

## Match and capture group ##

```
//Match dates formatted like MM/DD/YYYY, MM-DD-YY,...
$date = "12/30/1969";
$p = "!^(\\d\\d)[-/](\\d\\d)[-/](\\d\\d(?:\\d\\d)?)$!";
 
if (preg_match($p, $date, $matches)) {
  $month = $matches[1];
  $day = $matches[2];
  $year = $matches[3];
}
```

## Simple substitution ##

```
//Convert <br> to <br /> for XHTML compliance
$text = "Hello world. <br>";
 
$pattern = "{<br>}i";
 
echo preg_replace($pattern, "<br />", $text);
```

## Harder substitution ##

```
$text = "Check the web site, http://www.oreilly.com/catalog/regexppr.";
$regex =
    "{ \\b                      # start at word\n"
  . "                           # boundary\n"
  . "(                          # capture to $1\n"
  . "(https?|telnet|gopher|file|wais|ftp) : \n"
  . "                           # resource and colon\n"
  . "[\\w/\\#~:.?+=&%@!\\-]+?   # one or more valid\n"
  . "                           # characters\n"
  . "                           # but take as little as\n"
  . "                           # possible\n"
  . ")\n"
  . "(?=                        # lookahead\n"
  . "[.:?\\-]*                  # for possible punct\n"
  . "(?:[^\\w/\\#~:.?+=&%@!\\-] # invalid character\n"
  . "|$)                        # or end of string\n"
  . ") }x";
 
echo preg_replace($regex, "<a href=\"$1\">$1</a>", $text);
```

# PHP character representations #

```
\a Alert (bell), \x07.
\b Backspace, \x08, supported only in character class.
\e Esc character, \x1B.
\n Newline, \x0A.
\r Carriage return, \x0D.
\f Form feed, \x0C.
\t Horizontal tab, \x09.
\octal Character specified by a three-digit octal code.
\xhex Character specified by a one- or two-digit hexadecimal code.
\x{hex} Character specified by any hexadecimal code.
\cchar Named control character.
```

# PHP character classes and class-like constructs #

```
[...] A single character listed or contained within a listed range.
[^...] A single character not listed and not contained within a listed range.
[:class:] POSIX-style character class (valid only within a regex character class).
. Any character except newline (unless single-line mode, /s).
\C One byte (this might corrupt a Unicode character stream, however).
\w Word character, [a-zA-z0-9_].
\W Nonword character, [^a-zA-z0-9_].
\d Digit character, [0-9].
\D Nondigit character, [^0-9].
\s Whitespace character, [\n\r\f\t ].
\S Nonwhitespace character, [^\n\r\f\t ].
```

# PHP anchors and zero-width tests #

```
^ Start of string, or the point after any newline if in multiline match mode, /m.
\A Start of search string, in all match modes.
$ End of search string, or the point before a string-ending newline, or before any newline if in multiline match mode, /m.
\Z End of string, or the point before a string-ending newline, in any match mode.
\z End of string, in any match mode.
\G Beginning of current search.
\b Word boundary; position between a word character (\w), and a nonword character (\W), the start of the string, or the end of the
string.
\B Not-word-boundary.
(?=...) Positive lookahead.
(?!...) Negative lookahead.
(?<=...) Positive lookbehind.
(?<!...) Negative lookbehind.
```

# PHP comments and mode modifiers #

```
i Case-insensitive matching.
m ^ and $ match next to embedded \n.
s Dot (.) matches newline.
x Ignore whitespace, and allow comments (#) in pattern.
U Inverts greediness of all quantifiers: * becomes lazy, and *? greedy.
A Force match to start at beginning of subject string.
D Force $ to match end of string instead of before the stringending newline. Overridden by multiline mode.
u Treat regular expression and subject strings as strings of multibyte UTF-8 characters.
(?mode) Turn listed modes (one or more of imsxU) on for the rest of the subexpression.
(?-mode) Turn listed modes (one or more of imsxU) off for the rest of the subexpression.
(?mode:...) Turn mode (xsmi) on within parentheses.
(?-mode:...) Turn mode (xsmi) off within parentheses.
(?#...) Treat substring as a comment.
#... Rest of line is treated as a comment in x mode.
\Q Quotes all following regex metacharacters.
\E Ends a span started with \Q.
```

# PHP grouping, capturing, conditional, and control #

```
(...) Group subpattern and capture submatch into \1, \2,....
(?P<name>...) Group subpattern, and capture submatch into named capture group, name.
\n Contains the results of the nth earlier submatch from a parentheses capture group, or a named capture group.
(?:...) Groups subpattern, but does not capture submatch.
(?>...) Atomic grouping.
...|... Try subpatterns in alternation.
* Match 0 or more times.
+ Match 1 or more times.
? Match 1 or 0 times.
{n} Match exactly n times.
{n,} Match at least n times.
{x,y} Match at least x times, but no more than y times.
*? Match 0 or more times, but as few times as possible.
+? Match 1 or more times, but as few times as possible.
?? Match 0 or 1 times, but as few times as possible.
{n,}? Match at least n times, but as few times as possible.
{x,y}? Match at least x times, no more than y times, and as few times as possible.
*+ Match 0 or more times, and never backtrack.
++ Match 1 or more times, and never backtrack.
?+ Match 0 or 1 times, and never backtrack.
{n,}+ Match at least n times, and never backtrack.
{x,y}+ Match at least x times, no more than y times, and never backtrack.
(?(condition)...|...) Match with if-then-else pattern. The condition can be the number of a capture group, or a lookahead or lookbehind construct.
(?(condition)...) Match with if-then pattern. The condition can be the number of a capture group, or a lookahead or lookbehind construct.
```