function removeItensList(){
    const buttons = document.querySelectorAll('#whislist tr button');
    console.log(buttons);
    if(buttons.length == 0){
        //the current page doesn't have this section
        return;
    }
    

    for (const button of buttons) button.addEventListener('click', async function () {
        
        let row = button.parentElement.parentElement;


        let product = row.getAttribute("id"); //tr (the product row)

        //sends a request to delete the product from the cart in the db
        const request = new XMLHttpRequest();
        request.open("get", "../js_actions/api_remove_whislist.php?" + encodeForAjax({productID: product}), true);
        request.send();

        row.remove();
      });
    
}

removeItensList();