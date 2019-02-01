<?php
require 'vendor/autoload.php';

use Favicon\FaviconImageGenerator as FaviconImageGenerator;
use Favicon\FaviconHtmlGenerator as FaviconHtmlGenerator;

$applicationName = 'Test';
$faviconDir = 'assets/icons/';
$msapplicationTileColor = '#FFF';
$themeColor = '#FFF';
$titleBarColor = '#FFF';
$imageForAndroid = 'assets/img/favicon.png';
$imageForApple = 'assets/img/favicon.png';
$appleStartupImageProportion = 80.0;

$faviconImageGenerator = new FaviconImageGenerator($applicationName, $faviconDir, $imageForAndroid, $imageForApple, $appleStartupImageProportion);
$faviconImageGenerator->generate();
$v = '?v='.date('dmYhms');
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">

  <?php
  $faviconHtmlGenerator = new FaviconHtmlGenerator($applicationName, $faviconDir, $msapplicationTileColor, $themeColor, $titleBarColor);
  echo $faviconHtmlGenerator->generate();
  ?>

  <title><?= $applicationName ?></title>
</head>
<body>
</body>
</html>