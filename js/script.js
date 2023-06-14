function goBack() {
    window.history.back();
}

// Load navbar + footer
window.addEventListener('DOMContentLoaded', function () {
    var navbarPlaceholder = document.getElementById('navbar-placeholder');
    var footerPlaceholder = document.getElementById('footer-placeholder');

    // Create a new XMLHttpRequest for the navbar
    var navbarXhr = new XMLHttpRequest();
    navbarXhr.onreadystatechange = function () {
        if (this.readyState === 4 && this.status === 200) {
            // Inject the navbar HTML into the placeholder div
            navbarPlaceholder.innerHTML = navbarXhr.responseText;
        }
    };

    // Load the navbar.html file
    navbarXhr.open('GET', 'navbar.php', true);
    navbarXhr.send();

    // Create a new XMLHttpRequest for the footer
    var footerXhr = new XMLHttpRequest();
    footerXhr.onreadystatechange = function () {
        if (this.readyState === 4 && this.status === 200) {
            // Inject the footer HTML into the placeholder div
            footerPlaceholder.innerHTML = footerXhr.responseText;
        }
    };

    // Load the footer.html file
    footerXhr.open('GET', 'footer.html', true);
    footerXhr.send();
});
