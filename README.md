# favicon-generator
Image and html generator for favicon and app icon on your site.

# usage:
  Include this code in your composer.json:
    "minimum-stability": "dev",
    "prefer-stable": true,
    "require": {
      "romulinux/favicon-generator": ">=1.0.0"
    }

  Calling in your php project:
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

  And for generate the favicon and app imagens in dir 'assets/icons' write this:
  <?php
    $faviconImageGenerator = new FaviconImageGenerator($faviconDir, 'assets/img/favicon.png', 'assets/img/favicon.png');
    $faviconImageGenerator->generate();
  ?>
    This code will generate the images using the 'assets/img/favicon.png' image and put the output in dir 'assets/icons/'
