<?php

include_once '../thrive/Autoloader.php';

new Thrive_Autoloader();

 function convertJPGto8bitPNG($sourcePath) {
    $srcimage = imagecreatefromjpeg($sourcePath);
    list($width, $height) = getimagesize($sourcePath);
    $img = imagecreatetruecolor($width, $height);
    $bga = imagecolorallocatealpha($img, 0, 0, 0, 127);
    imagecolortransparent($img, $bga);
    imagefill($img, 0, 0, $bga);
    imagecopy($img, $srcimage, 0, 0, 0, 0, $width, $height);
    imagetruecolortopalette($img, false, 255);
    imagesavealpha($img, true);

	header('Content-Type: image/png');
    imagepng($img, '/tmp/test.png');
    imagedestroy($img);
}

if (empty($_GET['url'])) {
    echo "ERROR: No image url supplied.";
    exit;
}

// Get the requested image URL.
$url = filter_var($_GET['url'], FILTER_SANITIZE_URL);

// Confirm it's a JPEG.
if (strpos($url, '.jpg') === false)
{
    echo "ERROR: Only JPEG images are supported at this time.";
    exit;
}

// Use Thrive_URL_Downloader to fetch remote images.
$downloader = new Thrive_URL_Downloader();

// Ensure the URL Is valid.
try
{
    $downloader->ensureValidURL($url);
}
catch (Exception $e)
{
    echo "ERROR: Invalid URL supplied.";
    exit;
}

try
{
    $urlContent = $downloader->fetch($url);
}
catch (Exception $e)
{
    echo "ERROR: " . $e->getMessage();
    exit;
}

// sys_get_temp_dir() gets the system temp directory.
// tempnam() creates a temporary file that only PHP can
// write to, and returns the file name.

// Create temp file and get its filename.
$imageFile = tempnam(sys_get_temp_dir(), 'img-to-8bit-');

// Save the downloaded image to the temp file.
file_put_contents($imageFile, $urlContent->content);

// Convert to 8bit.and output to the browser.
convertJPGto8bitPNG($imageFile);

