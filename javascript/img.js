
async function changeImages(){
    //changes the images in the product page
    const image = document.querySelector("#productImages img");

    if(image == null){
        //this page doesn't have this section
        return;
    }
    const productID = image.getAttribute('id');
    const nextButton = document.querySelector("#productImages button");

    const response = await fetch("/../js_actions/api_images.php/?id=" + productID);
    const imagesPath = await response.json();
    
    let i = 0;
    nextButton.onclick = function(event){
        (i < imagesPath.length - 1) ? i++ : i = 0;
        image.setAttribute("src", "/../" + imagesPath[i]);
    }

}

changeImages();
