function encodeForAjax(data) {
    return Object.keys(data).map(function(k){
      return encodeURIComponent(k) + '=' + encodeURIComponent(data[k])
    }).join('&')
}

function sendMessage(){
    const button = document.querySelector('#messageForm button');
    messagesDiv = document.getElementById("messages");
    const form = button.parentElement;
    console.log(button);
    console.log(messagesDiv);
    console.log(form.elements['senderID'].value);
    if(button == null){
        return;
    }

    button.addEventListener('click',async function(){
        
        const form = button.parentElement;
        const newMessage = document.createElement('p');
        newMessage.innerHTML = form['messageText'];
        messagesDiv.appendChild(newMessage);

        const request = new XMLHttpRequest();
        request.open('post','../action_send_message.php',true);
        request.setRequestHeader('Content-Type', 
        'application/x-www-form-urlencoded')
        request.send(encodeForAjax({senderID : form.elements['senderID'].value,
            receiverID : form.elements['receiverID'].value,
            productID : form.elements['productID'].value,
            messageText : form.elements['messageText'].value}
            )
        );

    })
}

sendMessage();