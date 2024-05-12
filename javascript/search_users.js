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
                
                    const userLabelUsername = document.createElement('div');
                    userLabelUsername.className = "user-label username-light";
                    userLabelUsername.textContent = "Username";
                    const userDetailsUsername = document.createElement('div');
                    userDetailsUsername.className = "user-details";
                    userDetailsUsername.innerHTML = `<span>${user.username}</span>`;
                    userItem.appendChild(userLabelUsername);
                    userItem.appendChild(userDetailsUsername);

                    const userLabelEmail = document.createElement('div');
                    userLabelEmail.className = "user-label email-light";
                    userLabelEmail.textContent = "Email";
                    const userDetailsEmail = document.createElement('div');
                    userDetailsEmail.className = "user-details";
                    userDetailsEmail.innerHTML = `<span>${user.email}</span>`;
                    userItem.appendChild(userLabelEmail);
                    userItem.appendChild(userDetailsEmail);

                    const userLabelUserType = document.createElement('div');
                    userLabelUserType.className = "user-label";
                    userLabelUserType.textContent = "User Type";
                    const userDetailsUserType = document.createElement('div');
                    userDetailsUserType.className = "user-details";
                    userDetailsUserType.innerHTML = `<span>${user.isAdmin ? 'Admin' : 'Normal User'}</span>`;
                    userItem.appendChild(userLabelUserType);
                    userItem.appendChild(userDetailsUserType);
                
                    const optionsMenu = document.createElement('div');
                    optionsMenu.className = "options-menu";
                    const deleteButton = document.createElement('button');
                    deleteButton.textContent = "Delete Account";
                    deleteButton.onclick = function() {
                    };
                    const elevateButton = document.createElement('button');
                    elevateButton.textContent = "Elevate to Admin";
                    elevateButton.onclick = function() {
                    };
                    optionsMenu.appendChild(deleteButton);
                    optionsMenu.appendChild(elevateButton);
                    userItem.appendChild(optionsMenu);
                
                    userList.appendChild(userItem);
                });

                userListSection.appendChild(userList);
            }

        }
    });
}

document.addEventListener('DOMContentLoaded', function() {
    searchUsers();
});
