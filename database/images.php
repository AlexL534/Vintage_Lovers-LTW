<?php
declare(strict_types=1);


function getImagesPath(PDO $db, int $productID){
    $stmt = $db->prepare('
    SELECT IMAGES.path
    FROM IMAGES JOIN IMAGES_OF_PRODUCT on IMAGES.imageid = IMAGES_OF_PRODUCT.imageid
    WHERE   IMAGES_OF_PRODUCT.productid = ?
    ');
    $stmt->execute(array($productID));

    $images = array();
    while($imageDB = $stmt->fetch()){
        $image = $imageDB['path'];
        $images[] = $image;
    }

    return $images;
}

?>