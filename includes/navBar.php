<nav class="topBar">
    <div class="logoContainer">
        <a href="accueil">
            <img src="assets/images/logo.png" alt="Logo">
        </a>
    </div>
    <ul class="navLinks">
        <li><a class="ecriture" href="accueil">Accueil</a></li>
        <li><a class="ecriture" href="series">Séries</a></li>
        <li><a class="ecriture" href="intervention">Intervention</a></li>
        <?php
        if (empty($userLoggedIn)) {
            echo '<li><a class="ecriture connexion" href="connexion">Connexion</a></li>';
        }
        ?>
        <li><a class="iconbar" href="accueil"><i class="fa-solid fa-house"><span class="tooltiptext" id="bottom">Accueil</span></i></a></li>
        <li><a class="iconbar" href="series" t><i class="fa-solid fa-film fa-beat"><span class="tooltiptext" id="bottom">Séries</span></i></a></li>
        <li><a class="iconbar" href="intervention"><i class="fa-solid fa-video fa-shake"><span class="tooltiptext" id="bottom">Interventions</span></i></a></li>
        <?php
        if (empty($userLoggedIn)) {
            echo '<li><a class="iconbar" href="connexion" ><i class="fa-solid fa-user"><span class="tooltiptext" id="bottom">Connexion</span></i></a></li>';
        }
        ?>
    </ul>
    <div class="rightItems">
        <a href="recherche">
            <i class="fa-brands fa-searchengin recherche"></i>
        </a>
        <?php
        if (!empty($userLoggedIn)) {
            echo '<a href="profil"><i class="fa-sharp fa-solid fa-user profil"></i></a>';
            echo '<a href="deconnexion"><i class="fa-solid fa-power-off logout"></i></a>';
        }
        ?>
    </div>
</nav>