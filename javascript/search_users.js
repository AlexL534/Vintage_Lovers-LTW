document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.querySelector("#search");

    if (searchInput) {
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
                    for (const user of users) {
                        const userDiv = document.createElement('div');
                        userDiv.className = "user";
                        const usernameHeading = document.createElement('h2');
                        const emailParagraph = document.createElement('p');
                        usernameHeading.textContent = user.username;
                        emailParagraph.textContent = user.email;

                        userDiv.appendChild(usernameHeading);
                        userDiv.appendChild(emailParagraph);
                        userListSection.appendChild(userDiv);
                    }
                }
            }
        });
    }
});
