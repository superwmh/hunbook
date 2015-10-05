# XInclude #

```
# http://coding.derkeiler.com/Archive/PHP/php.general/2007-02/msg01568.html
# LIBMLXML_XINLCUDE currently only works with XMLReader.
# You would need to import your doc to DOM and then processes the xinclude:

$xml_file = './master.xml';

$xml = new SimpleXMLElement($xml_file, 0, true);
$dom = dom_import_simplexml($xml);
$dom->ownerDocument->xinclude();

print_r($xml);
```