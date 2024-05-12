function encodeForAjax(data) {
    return Object.keys(data).map(function(k){
      return encodeURIComponent(k) + '=' + encodeURIComponent(data[k])
    }).join('&')
}

function searchUsers() {
    const searchInput = document.querySelector("#search");

    if (!searchInput) {
        return;
    }

    searchInput.addEventListener('input', async function(event) {
        event.preventDefault();

        const query = '../js_actions/api_search_users.php?search=' + encodeURIComponent(searchInput.value);
        const response = await fetch(query);
        const users = await response.json();
        const userListSection = document.querySelector('#userList');

        if (userListSection) {
            userListSection.innerHTML = '';
            if (!users.length) {
                const error = document.createElement('h3');
                error.textContent = "No users found";
                error.className = "error";
                userListSection.appendChild(error);
            } else {
                const userList = document.createElement('ul'); 
                userList.className = "user-list";

                users.forEach(user => {
                    const userItem = document.createElement('li'); 
                    userItem.className = "user-item";

                    const usernameHeading = document.createElement('h2');
                    const emailParagraph = document.createElement('p');
                    usernameHeading.textContent = user.username;
                    emailParagraph.textContent = user.email;
            
                    userItem.appendChild(usernameHeading);
                    userItem.appendChild(emailParagraph);
                    userList.appendChild(userItem); 
                });

                userListSection.appendChild(userList); 
            }

        }
    });
}

document.addEventListener('DOMContentLoaded', searchUsers);
