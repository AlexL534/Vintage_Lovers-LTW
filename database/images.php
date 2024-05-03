<?php
declare(strict_types=1);


function getImagesPath(PDO $db, int $productID){
    if ($productID <= 0) {
        throw new InvalidArgumentException("Product ID must be a positive integer.");
    }

    $stmt = $db->prepare('
        SELECT IMAGES.path
        FROM IMAGES
        JOIN IMAGES_OF_PRODUCT ON IMAGES.imageid = IMAGES_OF_PRODUCT.imageid
        WHERE IMAGES_OF_PRODUCT.productid = ?
    ');

    $stmt->execute([$productID]);

    $images = [];
    while ($imageDB = $stmt->fetch()) {
        $image = $imageDB['path'];
        $images[] = $image;
    }

    return $images;
}
?>