function searchUsers() {
    const searchInput = document.querySelector("#search");
    const userTypeSelect = document.querySelector("#userType");
    const userListSection = document.querySelector('#userList');

    if (!searchInput || !userTypeSelect) {
        return;
    }

    const deleteAccount = async (userId, token) => {
        const confirmDelete = confirm('Are you sure you want to delete this account?');
        if (confirmDelete) {
            const response = await fetch(`/../actions/action_delete_account.php`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded'
                },
                body: `user_id=${userId}&csrf=${token}`
            });
            location.reload();
        }
    };
    
    const elevateToAdmin = async (userId, token) => {
        const confirmElevate = confirm('Are you sure you want to elevate this user to admin?');
        if (confirmElevate) {
            const response = await fetch(`/../actions/action_elevate_admin.php`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded'
                },
                body: `user_id=${userId}&csrf=${token}`
            });
            location.reload();
        }
    };
    

    async function performSearch() {
        const userType = encodeURIComponent(userTypeSelect.value);
        const searchQuery = encodeURIComponent(searchInput.value);
        const query = `/../js_actions/api_search_users.php?search=${searchQuery}&userType=${userType}`;
        const response = await fetch(query);
        const users = await response.json();

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
                    userItem.dataset.userId = user.id; 

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
                    deleteButton.classList.add('delete-btn'); 
                    optionsMenu.appendChild(deleteButton);

                    const elevateButton = document.createElement('button');
                    elevateButton.textContent = "Elevate to Admin";
                    elevateButton.classList.add('elevate-btn'); 
                    optionsMenu.appendChild(elevateButton);

                    userItem.appendChild(optionsMenu);

                    userList.appendChild(userItem);
                });

                userListSection.appendChild(userList);
            }
        }
    }

    userListSection.addEventListener('click', function(event) {
        const target = event.target;
        const tokenEle = document.querySelector(".token");
        const token = tokenEle.value;
        if (target && target.tagName === 'BUTTON') {
            if (target.classList.contains('delete-btn')) {
                const userId = target.closest('.user-item').dataset.userId;
                
                deleteAccount(userId, token);
            } else if (target.classList.contains('elevate-btn')) {
                const userId = target.closest('.user-item').dataset.userId;
                elevateToAdmin(userId, token);
            }
        }
    });

    performSearch();

    searchInput.addEventListener('input', performSearch);
    userTypeSelect.addEventListener('change', performSearch);
}

document.addEventListener('DOMContentLoaded', function() {
    searchUsers();
});
