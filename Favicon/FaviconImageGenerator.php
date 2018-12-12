<?php
namespace Favicon;

class FaviconImageGenerator extends FaviconGenerator
{
  private $faviconFilePath;
  private $appleFilePath;

  public function __construct($faviconDir, $faviconFilePath, $appleFilePath)
  {
    parent::__construct($faviconDir);
    $this->faviconFilePath = $faviconFilePath;
    $this->appleFilePath = $appleFilePath;
  }

  public function generate()
  {
    self::generateAppleFiles();
    self::generateAppleStartupFiles();
    self::generateMsFiles();
    self::generateAndroidFiles();
  }

  private function hex2RGB($hex)
  {
    $hex = str_replace("#", "", strtolower($hex));
    if (strlen($hex) == 3) {
      $r = hexdec(substr($hex, 0, 1).substr($hex, 0, 1));
      $g = hexdec(substr($hex, 1, 1).substr($hex, 1, 1));
      $b = hexdec(substr($hex, 2, 1).substr($hex, 2, 1));
    } else {
      $r = hexdec(substr($hex, 0, 2));
      $g = hexdec(substr($hex, 2, 2));
      $b = hexdec(substr($hex, 4, 2));
    }
    $rgb = array($r, $g, $b);
    return $rgb;
  }

  private function desiredSize($o_w, $o_h, $n_w, $n_h)
  {
    $n_r = $n_w / $n_h;
    $o_r = $o_w / $o_h;
    if ($n_r >= 1) { // horizontal dest
      if ($o_r >= 1) { // horizontal source
        if ($n_r >= $o_r) { // wider source
          $w = $o_w / ($o_h / $n_h);
          $h = $n_h;
        } else { // taller source
          $w = $n_w;
          $h = $o_h / ($o_w / $n_w);
        }
      } else { // vertical source
        $w = $o_w / ($o_h / $n_h);
        $h = $n_h;
      }
    } else { // vertical dest
      if ($o_r >= 1) { // horizontal source
        $w = $n_w;
        $h = $o_h / ($o_w / $n_w);
      } else { // vertical source
        if ($n_r >= $o_r) { // wider source
          $w = $o_w / ($o_h / $n_h);
          $h = $n_h;
        } else { // taller source
          $w = $n_w;
          $h = $o_h / ($o_w / $n_w);
        }
      }
    }
    return ['width' => $w, 'height' => $h];
  }

  public function resizeImage($source, $target, $newWidth, $newheight, $background = 'transparent', $proportion = 100.0)
  {
    if (preg_match('/#([a-f0-9]{3}){1,2}\b/i', $background)) {
      $background = self::hex2RGB($background);
    }

    if ($proportion >= 10.0 && $proportion <= 100.0) {
      $proportion /= 100.0;
    } else {
      $proportion = 1.0;
    }

    $info = getimagesize($source);
    $mime = $info['mime'];
    switch ($mime) {
      case 'image/jpeg':
        $imageCreateFunction = 'imagecreatefromjpeg';
        $imageSaveFunction = 'imagejpeg';
        $newImageExt = 'jpg';
      break;

      case 'image/png':
        $imageCreateFunction = 'imagecreatefrompng';
        $imageSaveFunction = 'imagepng';
        $newImageExt = 'png';
      break;

      case 'image/gif':
        $imageCreateFunction = 'imagecreatefromgif';
        $imageSaveFunction = 'imagegif';
        $newImageExt = 'gif';
      break;

      default:
        throw new Exception('Unknown image type.');
      }

    list($widthOrig, $heightOrig) = getimagesize($source);

    $size = self::desiredSize($widthOrig, $heightOrig, $newWidth, $newheight);

    $new_width = ceil($size['width'] * $proportion);
    $new_height = ceil($size['height'] * $proportion);

    $x_mid = $new_width / 2;
    $y_mid = $new_height / 2;

    $myImage = $imageCreateFunction($source);
    $newImage = imagecreatetruecolor($newWidth, $newheight);

    if ($background === 'transparent') {
      imagesavealpha($newImage, true);
      $black = imagecolorallocatealpha($newImage, 0, 0, 0, 127);
      imagefill($newImage, 0, 0, $black);
    } elseif (is_array($background) && count($background) === 3) {
      $rgb = $background;
      $color = imagecolorallocate($newImage, $rgb[0], $rgb[1], $rgb[2]);
      imagefill($newImage, 0, 0, $color);
      imagealphablending($myImage, false);
      imagesavealpha($myImage, true);
    }

    imagecopyresampled($newImage, $myImage, (($newWidth / 2)- ($x_mid)), (($newheight / 2) - $y_mid), 0, 0, $new_width, $new_height, $widthOrig, $heightOrig);

    imagedestroy($myImage);

    $imageSaveFunction($newImage, "$target.$newImageExt");

    return $newImage;
  }

  public function generateAppleFiles()
  {
    foreach ($this->apple as $ap) {
      $width = $ap['width'];
      $height = $ap['height'];
      $extensao = $ap['ext'];
      $fileName = $ap['name'].'-'.$width.'x'.$height;
      $background = $ap['background'];
      self::resizeImage($this->faviconFilePath, $this->faviconDir.$fileName, $width, $height, $background);
    }
    self::resizeImage($this->faviconFilePath, $this->faviconDir.'apple-icon', 192, 192, $background);
    self::resizeImage($this->faviconFilePath, $this->faviconDir.'apple-icon-precomposed', 192, 192, $background);
  }
  
  public function generateAppleStartupFiles($proportion = 20.0)
  {
    foreach ($this->appleStartupScreens as $ap) {
      $width = $ap['width'];
      $height = $ap['height'];
      $extensao = $ap['ext'];
      $fileName = $ap['name'].'-'.$width.'x'.$height;
      $background = $ap['background'];
      $proportion = $ap['proportion'];
      self::resizeImage($this->appleFilePath, $this->faviconDir.$fileName, $width, $height, $background, $proportion);
    }
  }
  
  public function generateMsFiles()
  {
    foreach ($this->ms as $m) {
      $width = $m['width'];
      $height = $m['height'];
      $extensao = $m['ext'];
      $fileName = $m['content'].'-'.$width.'x'.$height;
      $background = $m['background'];
      self::resizeImage($this->faviconFilePath, $this->faviconDir.$fileName, $width, $height, $background);
    }
  }
  
  public function generateAndroidFiles()
  {
    foreach ($this->android as $a) {
      $width = $a['width'];
      $height = $a['height'];
      $extensao = $a['ext'];
      $fileName = $a['name'].'-'.$width.'x'.$height;
      $background = $a['background'];
      self::resizeImage($this->faviconFilePath, $this->faviconDir.$fileName, $width, $height, $background);
    }
  }

}
