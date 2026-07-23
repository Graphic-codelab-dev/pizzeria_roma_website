<?php
/**
 * Sube y procesa la foto de un producto: valida el MIME real (no el que
 * envía el cliente), limita tamaño, redimensiona y renombra con un
 * nombre aleatorio antes de guardar en uploads/products/.
 *
 * @param array $file Un elemento de $_FILES (ej. $_FILES['image'])
 * @return string|null Ruta relativa guardada, o null si no se subió nada.
 * @throws RuntimeException Si el archivo no pasa validación.
 */
function handle_product_image_upload(array $file): ?string
{
    if (!isset($file['error']) || $file['error'] === UPLOAD_ERR_NO_FILE) {
        return null;
    }

    if ($file['error'] !== UPLOAD_ERR_OK) {
        throw new RuntimeException('The image upload failed. Please try again.');
    }

    $maxBytes = 5 * 1024 * 1024;
    if ($file['size'] > $maxBytes) {
        throw new RuntimeException('The image is too large (max 5MB).');
    }

    $finfo = new finfo(FILEINFO_MIME_TYPE);
    $mime  = $finfo->file($file['tmp_name']);

    $allowed = [
        'image/jpeg' => 'jpg',
        'image/png'  => 'png',
        'image/webp' => 'webp',
    ];

    if (!isset($allowed[$mime])) {
        throw new RuntimeException('Unsupported image type. Please use JPG, PNG or WEBP.');
    }

    $imageInfo = getimagesize($file['tmp_name']);
    if (!$imageInfo) {
        throw new RuntimeException('The uploaded file is not a valid image.');
    }
    [$width, $height] = $imageInfo;

    $image = match ($mime) {
        'image/jpeg' => imagecreatefromjpeg($file['tmp_name']),
        'image/png'  => imagecreatefrompng($file['tmp_name']),
        'image/webp' => imagecreatefromwebp($file['tmp_name']),
    };

    if (!$image) {
        throw new RuntimeException('Could not process the image.');
    }

    $maxDimension = 1600;
    if ($width > $maxDimension || $height > $maxDimension) {
        $ratio     = min($maxDimension / $width, $maxDimension / $height);
        $newWidth  = (int) round($width * $ratio);
        $newHeight = (int) round($height * $ratio);

        $resized = imagecreatetruecolor($newWidth, $newHeight);
        if ($mime === 'image/png') {
            imagealphablending($resized, false);
            imagesavealpha($resized, true);
        }
        imagecopyresampled($resized, $image, 0, 0, 0, 0, $newWidth, $newHeight, $width, $height);
        imagedestroy($image);
        $image = $resized;
    }

    $filename = bin2hex(random_bytes(16)) . '.' . $allowed[$mime];
    $destPath = ROOT_PATH . '/uploads/products/' . $filename;

    match ($mime) {
        'image/jpeg' => imagejpeg($image, $destPath, 85),
        'image/png'  => imagepng($image, $destPath, 6),
        'image/webp' => imagewebp($image, $destPath, 85),
    };

    imagedestroy($image);

    return 'uploads/products/' . $filename;
}
