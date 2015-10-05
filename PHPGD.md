# thumb(resize) #

```
function makeThumb($src, $newSize = 100) {
    $srcSize = getimagesize($src);
    $srcRatio  = $srcSize[0] / $srcSize[1];
    $destRatio = 1;
    if ($destRatio > $srcRatio) {
        $destSize[1] = $newSize;
        $destSize[0] = round($newSize * $srcRatio);
    } else {
        $destSize[0] = $newSize;
        $destSize[1] = round($newSize / $srcRatio);
    }
    $destImage = imagecreatetruecolor($destSize[0], $destSize[1]);
    $srcImage = imagecreatefromjpeg($src);
    imagecopyresampled($destImage, $srcImage, 0, 0, 0, 0, $destSize[0], $destSize[1], $srcSize[0], $srcSize[1]);
    imagedestroy($srcImage);    //free memory, this is a MUST
    //imageJpeg($destImage, null, 85);
    return $destImage;
}
```

# combine #

```
// combine $coverImg into $thumbs
$w = imagesx($coverImg);
$h = imagesy($coverImg);
$offsetX = $offsetY = 0;
if ($w < $coverSize) {
    $offsetX = (int)(($coverSize - $w) / 2);
}
if ($h < $coverSize) {
    $offsetY = (int)(($coverSize - $h) / 2);
}
imagecopy($thumbs, $coverImg, 0 + $offsetX, $offsetY, 0, 0, $w, $h);
```