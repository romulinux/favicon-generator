# favicon-generator
Image and html generator for favicon and app icon on your site.

# requirements:
php 7.2 and php7.2-gd

# usage:
  Local php server:
```shell
php -S localhost:8888 # access this link on your browser
```
  In your project, include this code in your composer.json:
```json
"minimum-stability": "dev",
"prefer-stable": true,
"require": {
  "romulinux/favicon-generator": ">=1.0.0"
}
```

  Calling in your php project:
```php
<?php
  use Favicon\FaviconImageGenerator as FaviconImageGenerator;
  use Favicon\FaviconHtmlGenerator as FaviconHtmlGenerator;

  $applicationName = 'Teste';
  $faviconDir = 'assets/icons/';
  $msapplicationTileColor = '#FFF';
  $themeColor = '#FFF';
  $titleBarColor = '#FFF';

  echo '<head>';
    $faviconHtmlGenerator = new FaviconHtmlGenerator($applicationName, $faviconDir, $msapplicationTileColor, $themeColor, $titleBarColor);
    echo $faviconHtmlGenerator->generate();
  echo '</head>';
?>
```

  And for generate the favicon and app images in dir *'assets/icons'* write this:
```php
<?php
  $faviconImageGenerator = new FaviconImageGenerator($faviconDir, 'assets/img/favicon.png', 'assets/img/favicon.png');
  $faviconImageGenerator->generate();
?>
```
    This code will generate the images using the 'assets/img/favicon.png' image and put the output in dir 'assets/icons/'
