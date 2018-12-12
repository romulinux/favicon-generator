<?php
require 'vendor/autoload.php';

use Favicon\FaviconImageGenerator as FaviconImageGenerator;
use Favicon\FaviconHtmlGenerator as FaviconHtmlGenerator;
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">

  <?php
  $applicationName = 'Site Name';
  $faviconDir = 'assets/icons/';
  $msapplicationTileColor = '#FFF';
  $themeColor = '#FFF';
  $titleBarColor = '#FFF';
  $faviconHtmlGenerator = new FaviconHtmlGenerator($applicationName, $faviconDir, $msapplicationTileColor, $themeColor, $titleBarColor);
  echo $faviconHtmlGenerator->generate();
  ?>

  <title>Site Name</title>
</head>
<body>
<?php
  $faviconImageGenerator = new FaviconImageGenerator($faviconDir, 'assets/img/favicon.png', 'assets/img/favicon.png');
  $faviconImageGenerator->generate();
?>
</body>
</html>