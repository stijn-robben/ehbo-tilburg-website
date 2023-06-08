function goBack() {
    window.history.back();
}

window.addEventListener('DOMContentLoaded', function () {
    var navbarPlaceholder = document.getElementById('navbar-placeholder');

    // Create a new XMLHttpRequest
    var xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function () {
        if (this.readyState === 4 && this.status === 200) {
            // Inject the navbar HTML into the placeholder div
            navbarPlaceholder.innerHTML = xhr.responseText;
        }
    };

    // Load the navbar.html file
    xhr.open('GET', 'navbar.html', true);
    xhr.send();
});
