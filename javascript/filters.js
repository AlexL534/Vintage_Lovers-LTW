function verifyCheckbox(){

    const productsSection = document.querySelectorAll("#filterPage .products");
    const checkboxes = document.querySelectorAll("#filterMenu input[type=checkbox]");

    //adds a listen to every checkbox
    checkboxes.forEach(function(checkbox){
        checkbox.addEventListener('change', async function(){

            //if a change occurs and every checkbos is disable, insert all products
            if(isEveryBoxUnchecked()){
                drawAllProducts();
            }
            else{
            //query the products depending on the boxes checked
            
            let products = await getAllProducts();
            const productsBrands = await verifyBrands();
            const productsCategories = await verifyCategories();
            const productsColors = await verifyColors();
            const productsCondition = await  verifyConditions();
            const productsSizes = await verifySizes();

            if(productsBrands.length != 0){
                products = filterProducts(products, productsBrands);
            }
            if(productsCategories.length != 0){
                products = filterProducts(products, productsCategories);
            }
            if(productsColors.length != 0){
                products = filterProducts(products, productsColors);
            }
            if(productsCondition.length != 0){
                products = filterProducts(products, productsCondition);
            }
            if(productsSizes.length != 0){
                products = filterProducts(products, productsSizes);
            }
            console.log(productsSizes.length);
            console.log(products);
            drawSelectedProducts(products);
            }
        });
    });

    if(isEveryBoxUnchecked()){

    }

}

 async function verifyBrands(){
    const brandsCheckBoxes = document.querySelectorAll("#filterPage #brands input[type=checkbox]");
    let brandsIDs = [];
    let products = [];
    brandsCheckBoxes.forEach(function(checkbox){
        if(checkbox.checked){
            brandsIDs.push(checkbox.name);
        }
    });
    for(let i = 0; i < brandsIDs.length; i++){
        const response = await fetch("/../js_actions/api_get_products_from_filters.php/?brandID=" + brandsIDs[i]);
        const productsRes = await response.json();
        productsRes.forEach( element => products.push(element));
    }
    return products;
}

async function verifyCategories(){
    const categoriesCheckBoxes = document.querySelectorAll("#filterPage #categories input[type=checkbox]");
    let categoriesIDs = [];
    let products = [];
    categoriesCheckBoxes.forEach(function(checkbox){
        if(checkbox.checked){
            categoriesIDs.push(checkbox.name);
        }
    });
    for(let i = 0; i < categoriesIDs.length; i++){
        const response = await fetch("/../js_actions/api_get_products_from_filters.php/?categoryID=" + categoriesIDs[i]);
        const productsRes = await response.json();
        productsRes.forEach( element => products.push(element));
    }
    return products;
}



async function verifyColors(){
    const colorsCheckBoxes = document.querySelectorAll("#filterPage #colors input[type=checkbox]");
    let colorsIDs = [];
    let products = [];
    colorsCheckBoxes.forEach(function(checkbox){
        if(checkbox.checked){
            colorsIDs.push(checkbox.name);
        }
    });
    for(let i = 0; i < colorsIDs.length; i++){
        const response = await fetch("/../js_actions/api_get_products_from_filters.php/?colorID=" + colorsIDs[i]);
        const productsRes = await response.json();
        productsRes.forEach( element => products.push(element));
    }
    return products;
}

async function verifyConditions(){
    const conditionsCheckBoxes = document.querySelectorAll("#filterPage #conditions input[type=checkbox]");
    let conditionsIDs = [];
    let products = [];
    conditionsCheckBoxes.forEach(function(checkbox){
        if(checkbox.checked){
            conditionsIDs.push(checkbox.name);
        }
    });
    for(let i = 0; i < conditionsIDs.length; i++){
        const response = await fetch("/../js_actions/api_get_products_from_filters.php/?conditionID=" + conditionsIDs[i]);
        const productsRes = await response.json();
        productsRes.forEach( element => products.push(element));
    }
    return products;
}

async function verifySizes(){
    const sizesCheckBoxes = document.querySelectorAll("#filterPage #sizes input[type=checkbox]");
    let sizesIDs = [];
    let products = [];
    sizesCheckBoxes.forEach(function(checkbox){
        if(checkbox.checked){
            sizesIDs.push(checkbox.name);
        }
    });
    for(let i = 0; i < sizesIDs.length; i++){
        const response = await fetch("/../js_actions/api_get_products_from_filters.php/?sizesID=" + sizesIDs[i]);
        const productsRes = await response.json();
        productsRes.forEach( element => products.push(element));
        
    }
    console.log(products);
    return products;
}


function drawAllProducts(){

}

function drawSelectedProducts(products){

}

async function getAllProducts(){
    let products = [];
    const response = await fetch("/../js_actions/api_get_all_products.php");
    const productsRes = await response.json();
    productsRes.forEach( element => products.push(element));
    return products;
}

function filterProducts(array1,array2){
    let res = [];
    for(let i = 0; i < array1.length; i++){
        if(checkIfIsInArray(array2, array1[i])){
            res.push(array1[i]);
        }
    }
    return res;
}
function checkIfIsInArray(array, product){
    let isInArray = false;
    
    array.forEach(function(element){
        if(product['id'] == element['id']){
            isInArray = true;
        }
    });
    return isInArray;
}

function isEveryBoxUnchecked(){
    const checkboxes = document.querySelectorAll("#filterMenu input[type=checkbox]");

    for(let checkbox of checkboxes){
        if(checkbox.checked){
            return false;
        }
    }

    return true;
    
}

verifyCheckbox();