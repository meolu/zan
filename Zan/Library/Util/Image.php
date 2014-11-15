<?php
/* *************************************************************************
 * File Name: Image.php
 * Author: wushuiyong
 * mail: wushuiyong@huamanshu.com
 * Created Time: Sun 09 Nov 2014 02:12:10 PM
 * ************************************************************************/
namespace Zan\Library\Util;

class Image {

	/**
	 * Create a JPEG thumbnail for the given png/gif/jpeg image and return the path to the new image .
	 *
	 * @param string $file the file path to the image
	 * @param int $width the width
	 * @param int $height the height
	 * @param int $quality of image thumbnail
	 * @return string
	 */
	public static function thumbnail($file, $width = 80, $height = 80, $quality = 80) {
		if (!is_file($file)) {
            return;
		}

		$dir  = "Thumbnails/";
		$name = basename($file).'.jpg';

		// If the thumbnail already exists, we can't write to the directory, or the image file is invalid
		if (is_file(ROOT.$dir.$name)) {
			return $dir.$name;
		}

		if (!directory_is_writable(ROOT.$dir) OR !($image = self::open($file))) {
            return;
		}

		// Resize the image and save it as a compressed JPEG
		if (imagejpeg(self::resize($image, $width, $height), ROOT.$dir.$name, $quality)) {
			return $dir.$name;
		}

	}

	/**
	 * Open a resource handle to a (png/gif/jpeg) image file for processing .
	 *
	 * @param string $file the file path to the image
	 * @return resource
	 */
	public static function open($file) {
		if (!is_file($file)) {
            return;
		}

		$ext = pathinfo($file, PATHINFO_EXTENSION);

		// Invalid file type?
		if (!in_array($ext, array('jpg', 'jpeg', 'png', 'gif'))) {
            return;
		}

		// Open the file using the correct function
		$function = 'imagecreatefrom'.($ext == 'jpg'?'jpeg':$ext);

		if ($image = @$function($file)) {
			return $image;
		}
	}

	/**
	 * Resize and crop the image to fix proportinally in the given dimensions .
	 *
	 * @param resource $image the image resource handle
	 * @param int $width the width
	 * @param int $height the height
	 * @param bool $center to crop from image center
	 * @return resource
	 */
	public static function resize($image, $width, $height, $center = true) {
		$x     = imagesx($image);
		$y     = imagesy($image);
		$small = min($x/$width, $y/$height);

		// Default CROP from top left
		$sx = $sy = 0;

		// Crop from image center?
		if ($center) {
			if ($y/$height > $x/$width) {
				$sy = $y/4-($height/4);
			} else {
				$sx = $x/2-($width/2);
			}
		}

		$new = imagecreatetruecolor($width, $height);
		self::alpha($new);

		// Crop and resize image
		imagecopyresampled($new, $image, 0, 0, $sx, $sy, $width, $height, $x-($x-($small*$width)), $y-($y-($small*$height)));

		return $new;
	}

	/**
	 * Preserve the alpha channel transparency in PNG images
	 *
	 * @param resource $image the image resource handle
	 */
	public static function alpha($image) {
		imagecolortransparent($image, imagecolorallocate($image, 0, 0, 0));
		imagealphablending($image, false);
		imagesavealpha($image, true);
	}
