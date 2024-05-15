async function verifyCheckbox(){
    const checkboxes = document.querySelectorAll("#filterMenu input[type=checkbox]");
    const orderSelect = document.querySelector("#priceOrder select");

    if(orderSelect == null){
        return;
    }

    let searchQuery = null;

    if(document.querySelector("#filterPage > header span") != null){
        console.log("here");
        searchQuery = document.querySelector("#filterPage > header span").innerHTML;

    }
    let products = [];

    //gets the products according to the search content
    if(searchQuery !== null){
        products = await getSearchProducts(searchQuery);
        
    }
    else{
        products = await getAllProducts();
    }

    //adds a listener to the order select element
    orderSelect.addEventListener("change", function(){
        products = sortProducts(products);
        drawProducts(products);
    });

    //adds a listener to every checkbox
    checkboxes.forEach(function(checkbox){
        checkbox.addEventListener('change', async function(){
            products = await getAllProducts();
            products = sortProducts(products);
            
            //if a change occurs and every checkbox is disabled, insert all products
            if(isEveryBoxUnchecked()){
                //products = await getAllProducts();
            }
            else{
            //query the products depending on the boxes checked
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

           
            }
            products = sortProducts(products);
            
            await drawProducts(products);
        });
    });

}

 async function verifyBrands(){
    //Checks which brand checkboxes are active
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
        console.log("here");
    }
    return products;
}

async function verifyCategories(){
    //Checks which category checkboxes are active
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
    //Checks which color checkboxes are active
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
    //Checks which condition checkboxes are active
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
        console.log(productsRes);
    }
    return products;
}

async function verifySizes(){
    //Checks which size checkboxes are active
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
    return products;
}



async function drawProducts(products){
    //draw the filtered products

    const filterPage = document.querySelector("#filterPage");
    const productsSection = document.querySelector("#filterPage .products");
    productsSection.remove();

    const newProductSection = document.createElement("section");
    newProductSection.setAttribute("class", "products");

    for(let i = 0; i < products.length; i++){
        //creates the elements that are used to represent the product
        const link = document.createElement("a");
        const article = document.createElement("article");
        const pName = document.createElement("p");
        const pPrice = document.createElement("p");
        const img = document.createElement("img");

        //fetches the product image
        const response = await fetch("/../js_actions/api_images.php/?id=" + products[i].id);
        const imagesPath = await response.json();
        img.setAttribute("src", "/../" + imagesPath[0]);
        img.setAttribute("class", "productImage");
        img.setAttribute("alt", "productImage");

        //alter the link atributes
        link.setAttribute("href", "/../pages/products.php?id=" + products[i].id);
        link.setAttribute("class", "product");

        //alter the name paragraph atributes
        pName.setAttribute("class", "product_name");
        pName.innerHTML = products[i].name;
        
        //alter the price paragraph atributes
        pPrice.setAttribute("class", "product_price");
        pPrice.innerHTML = products[i].price;

        //appends everyting to the product article
        article.appendChild(img);
        article.appendChild(pName);
        article.appendChild(pPrice);

        //appends the article to the link to the product page
        link.appendChild(article);

        //inserts the link to the product section
        newProductSection.appendChild(link);

    }

    filterPage.appendChild(newProductSection);

}

async function getAllProducts(){
    //gets all the products from the db
    let products = [];
    const response = await fetch("/../js_actions/api_get_all_products.php");
    const productsRes = await response.json();
    productsRes.forEach( element => products.push(element));
    return products;
}

async function getSearchProducts(search){
    //gets the products that correspond to the search
    let products = [];
    const response = await fetch("/../js_actions/api_get_products_search.php/?search=" + search);
    const productsRes = await response.json();
    productsRes.forEach( element => products.push(element));
    return products;
}

function sortProducts(products){
    //sorts the products depending on the option selected
    const orderSelect = document.querySelector("#priceOrder select");

    if(orderSelect.value === "Asc"){
        products.sort(function(a,b){
            return a.price - b.price;
        });
    }
    else{
        products.sort(function(a,b){
            return b.price - a.price;
        });
    }

    return products;
}

function filterProducts(array1,array2){
    //filters the products
    let res = [];
    for(let i = 0; i < array1.length; i++){
        if(checkIfIsInArray(array2, array1[i])){
            res.push(array1[i]);
        }
    }
    return res;
}
function checkIfIsInArray(array, product){
    //check if a product is in a array
    let isInArray = false;
    
    array.forEach(function(element){
        if(product['id'] == element['id']){
            isInArray = true;
        }
    });
    return isInArray;
}

function isEveryBoxUnchecked(){
    //check if every checkbox is checked
    const checkboxes = document.querySelectorAll("#filterMenu input[type=checkbox]");

    for(let checkbox of checkboxes){
        if(checkbox.checked){
            return false;
        }
    }

    return true;
    
}

verifyCheckbox();