/* User Dropdown*/

let profileDropdownList = document.querySelector(".profile-dropdown-list");
let btn = document.querySelector(".profile-dropdown-btn");

/**this function display or hide profile dropdown list */
const toggle = () => profileDropdownList.classList.toggle("active");

window.addEventListener("click", function (e) {
    //hide dropdown list if user click outside dropdown button
    if (!btn.contains(e.target)) profileDropdownList.classList.remove("active")
})

