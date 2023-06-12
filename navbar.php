<!-- Navbar -->
<nav class="navbar navbar-expand-lg bg-light fixed-top">
    <div class="container">
        <a class="navbar-brand" href="index.html" aria-label="To the homepage">
            <img src="./img/logo.png" width="70" height="auto" alt="Logo van EHBO Tilburg" />
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup"
            aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-list"
                viewBox="0 0 16 16">
                <path fill-rule="evenodd"
                    d="M2.5 12a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5zm0-4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5zm0-4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5z" />
            </svg>
        </button>
        <div class="collapse navbar-collapse justify-content-center" id="navbarNavAltMarkup">
            <div class="navbar-nav">
                <a class="nav-link" href="lidmaatschap.html">
                    <p class="text-secondary text-nav">Lidmaatschap</p>
                </a>
                <li class="nav-item dropdown nav-link">
                    <a href="#" class="nav-link dropdown-toggle text-secondary text-nav navbar-dropdown"
                        data-bs-toggle="dropdown">Opleidingen</a>
                    <div class="dropdown-menu">
                        <a href="activiteiten.html" class="dropdown-item text-secondary text-nav">
                            <p>Activiteiten</p>
                        </a>
                        <!-- <a href="#" class="dropdown-item text-secondary text-nav"><p>Item 2</p></a> -->
                    </div>
                </li>
                <a class="nav-link" href="wie-zijn-wij.html">
                    <p class="text-secondary text-nav">Wie zijn wij</p>
                </a>
                <a class="nav-link" href="hulpverlening.html">
                    <p class="text-secondary text-nav">Hulpverlening</p>
                </a>
                <?php if ($_SESSION['loggedin'] == true && $_SESSION['role'] != 'admin') : ?>
                <li class="nav-item dropdown nav-link">
                    <a href="#" class="nav-link dropdown-toggle text-secondary text-nav navbar-dropdown"
                        data-bs-toggle="dropdown">Overig</a>
                    <div class="dropdown-menu">
                        <a href="cursussen.php" class="dropdown-item text-secondary text-nav">
                            <p>Cursussen</p>
                        </a>
                    </div>
                </li>
                <?php else: ?>
                <li class="nav-item dropdown nav-link">
                    <a href="#" class="nav-link dropdown-toggle text-secondary text-nav navbar-dropdown"
                        data-bs-toggle="dropdown">Overig</a>
                    <div class="dropdown-menu">
                        <a href="#" class="dropdown-item text-secondary text-nav">
                            <p>Item 1</p>
                        </a>
                    </div>
                </li>
                <?php endif; ?>
                <a class="nav-link" href="contact.html">
                    <p class="text-secondary text-nav">Contact</p>
                </a>
                <div class="pt-2">
                    <a class="btn btn-secondary btn-lg" href="login.html" role="button">Inloggen</a>
                </div>
            </div>
        </div>
    </div>
</nav>
