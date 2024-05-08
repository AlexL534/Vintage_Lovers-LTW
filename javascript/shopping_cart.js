function encodeForAjax(data) {
    return Object.keys(data).map(function(k){
      return encodeURIComponent(k) + '=' + encodeURIComponent(data[k])
    }).join('&')
  }

function removeItens(){
    const buttons = document.querySelectorAll('#shoppingCart tr button');
    console.log(buttons);
    if(buttons.length == 0){
        //the current page doesn't have this section
        return;
    }
    
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

function addOptionsToPay(){
  const selectElement = document.querySelector("#paymentMethod");

  if(selectElement == null){
    //this isn't the correct section
    return;
  }
  const paymentlabel = document.querySelector("#payment label:nth-child(2");


  //create the input exclusive of credit option
  const newLabel = document.createElement('label');
  const newP = document.createElement('p');
  const newInput = document.createElement('input');
  newInput.setAttribute("type", "text");
  newP.innerHTML = "Security Code";
  newLabel.appendChild(newP);
  newLabel.appendChild(newInput);


  selectElement.addEventListener("change", (event) => {
    if(event.target.value == "card"){
      paymentlabel.querySelector('p').innerHTML = "Card Number";
      paymentlabel.append(newLabel);
    }
    else{
      newLabel.remove();
      paymentlabel.querySelector('p').innerHTML = "Account number";
    }
  });
}

removeItens();
addOptionsToPay();