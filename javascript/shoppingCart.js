function encodeForAjax(data) {
    return Object.keys(data).map(function(k){
      return encodeURIComponent(k) + '=' + encodeURIComponent(data[k])
    }).join('&')
  }

function removeItens(){
    const buttons = document.querySelectorAll('tr button');
    const totalPriceElem = document.getElementById("totalPrice");
    let totalPrice = parseFloat(totalPriceElem.innerHTML);

    for (const button of buttons) button.addEventListener('click', async function () {
        
        let row = button.parentElement.parentElement;

        //calculate the new price to display
        const priceElem = row.querySelector(".price");
        const productPrice = parseFloat(priceElem.innerHTML);
        totalPrice = parseFloat(totalPrice - productPrice).toFixed(2);
        totalPriceElem.textContent = totalPrice.toString();


        let product = row.getAttribute("id"); //tr (the product row)

        //sends a request to delete the product from the cart in the db
        const request = new XMLHttpRequest();
        request.open("get", "../js_actions/api_remove_shopping_cart.php?" + encodeForAjax({productID: product}), true);
        request.send();

        row.remove();
      });
    
}

removeItens();