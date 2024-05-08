function encodeForAjax(data) {
    return Object.keys(data).map(function(k){
      return encodeURIComponent(k) + '=' + encodeURIComponent(data[k])
    }).join('&')
  }

function removeItens(){
    const buttons = document.querySelectorAll('tr button');


    for (const button of buttons) button.addEventListener('click', async function () {
        let row = button.parentElement.parentElement;
        let product = row.getAttribute("id"); //tr (the product row) 
        const request = new XMLHttpRequest();
        request.open("get", "../js_actions/api_remove_shopping_cart.php?" + encodeForAjax({productID: product}), true);
        request.send();
        row.remove();
      });
    
}

removeItens();