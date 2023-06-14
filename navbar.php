<?php
session_start();
?>

<!-- Navbar -->
<nav class="navbar navbar-expand-lg bg-light fixed-top">
    <div class="container">
        <a class="navbar-brand" href="index.php" aria-label="To the homepage">
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
                <!-- Lidmaatschap -->
                <a class="nav-link" href="lidmaatschap.php">
                    <p class="text-secondary text-nav">Lidmaatschap</p>
                </a>

                <!-- Opleidingen -->
                <li class="nav-item dropdown nav-link">
                    <a href="#" class="nav-link dropdown-toggle text-secondary text-nav navbar-dropdown"
                        data-bs-toggle="dropdown">Opleidingen</a>
                    <div class="dropdown-menu">
                        <a href="activiteiten.php" class="dropdown-item text-secondary text-nav">
                            <p>Activiteiten</p>
                        </a>
                    </div>
                </li>

                <!-- Wie zijn wij -->
                <a class="nav-link" href="wie-zijn-wij.php">
                    <p class="text-secondary text-nav">Wie zijn wij</p>
                </a>

                <!-- Hulpverlening -->
                <a class="nav-link" href="hulpverlening.php">
                    <p class="text-secondary text-nav">Hulpverlening</p>
                </a>

                <!-- Contact -->
                <a class="nav-link" href="contact.php">
                    <p class="text-secondary text-nav">Contact</p>
                </a>

                <!-- Overig -->
                <?php if (isset($_SESSION['loggedin']) && $_SESSION['loggedin']) : ?>
                    <?php if ($_SESSION['role'] != 'admin') : ?>
                        <!-- Dropdown menu voor leden -->
                        <li class="nav-item dropdown nav-link">
                            <a href="#" class="nav-link dropdown-toggle text-secondary text-nav navbar-dropdown"
                                data-bs-toggle="dropdown">Overig</a>
                            <div class="dropdown-menu">
                                <a href="cursussen.php" class="dropdown-item text-secondary text-nav">
                                    <p>Cursussen</p>
                                </a>
                            </div>
                        </li>
                    <?php else : ?>
                        <!-- Dropdown menu voor admin -->
                        <li class="nav-item dropdown nav-link">
                            <a href="#" class="nav-link dropdown-toggle text-secondary text-nav navbar-dropdown"
                                data-bs-toggle="dropdown">Overig</a>
                            <div class="dropdown-menu">
                                <a href="cursussen.php" class="dropdown-item text-secondary text-nav">
                                    <p>Cursussen</p>
                                </a>
                                <a href="beheer.php" class="dropdown-item text-secondary text-nav">
                                    <p>Beheer</p>
                                </a>
                            </div>
                        </li>
                    <?php endif; ?>

                    <!-- Uitloggen -->
                    <div class="pt-2">
                        <a class="btn btn-secondary btn-lg" href="uitloggen.php" role="button">Uitloggen</a>
                    </div>
                <?php else : ?>
                    <!-- Dropdown menu voor niet ingelogde gebruikers -->
                    <li class="nav-item dropdown nav-link">
                        <a href="#" class="nav-link dropdown-toggle text-secondary text-nav navbar-dropdown"
                            data-bs-toggle="dropdown">Overig</a>
                        <div class="dropdown-menu">
                            <a href="#" class="dropdown-item text-secondary text-nav">
                                <p>Item 1</p>
                            </a>
                        </div>
                    </li>

                    <!-- Inloggen -->
                    <div class="pt-2">
                        <a class="btn btn-secondary btn-lg" href="inloggen.php" role="button">Inloggen</a>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</nav>
