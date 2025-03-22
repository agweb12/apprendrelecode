<?php
$user = new User($connection, $userLoggedIn);
?>
<footer>
    <?php
    if (!empty($userLoggedIn)) {
        echo "<div class='connexion'><i class='fa-solid fa-circle connecte'></i><p class='footer'>Salam Aleykoum <span>" . $user->getPrenom() . '<span> Bon Visionnage</p></div>';
    }
    ?>
    <div class="section5">
        <div itemscope itemtype="https://schema.org/Organization" id="contact" class="col">
            <span itemprop="url" content="https://apprendrelecode.com"><a href=""><img class="logo" itemprop="logo" src="assets/images/" class="logo" alt=""></a></span>
            <p><strong><span itemprop="name">Alexandre Graziani</span></strong> | <span itemprop="alternateName">Alexandre Graziani Web</span></p>

            <h4>Contactez-Nous</h4>
            <div itemprop="address" itemscope itemtype="https://schema.org/PostalAddress">
                <p><strong><span itemprop="addresseLocality"></span>Adresse : </strong>Paris</p>
            </div>
            <p><strong>Téléphone : </strong><span itemprop="telephone">(+33) 7 79 13 44 95</span></p>
            <p><strong>Mail : </strong><span itemprop="email">contact@apprendrelecode.com</span></p>
            <p><strong>Horaires : </strong>9h00 - 18h00 du Lundi au Vendredi</p>
        </div>
        <div class="follow">
            <h4>Suivez-nous, c'est par ici !</h4>
            <div itemscope itemtype="https://schema.org/Organization" class="icon">
                <a itemprop="sameAs" href="https://www.facebook.com/MaamarMetmatiOfficiel" target="_blank"><i class="fab fa-facebook"></i></a>
                <a itemprop="sameAs" href="https://www.youtube.com/c/MaamarMetmatiOfficiel12" target="_blank"><i class="fa-brands fa-youtube fa-beat-fade"></i></a>
                <a itemprop="sameAs" href="https://www.instagram.com/maamarmetmati/?hl=fr" target="_blank"><i class="fa-brands fa-instagram fa-bounce"></i></a>
                <a itemprop="sameAs" href="https://twitter.com/OfficielMaamar" target="_blank"><i class="fa-brands fa-twitter fa-spin fa-spin-reverse"></i></a>
                <a itemprop="sameAs" href="https://t.me/maamarmetmati" target="_blank"><i class="fa-brands fa-telegram fa-bounce"></i></a>
                <a itemprop="sameAs" href="https://www.tiktok.com/@maamarmetmati" target="_blank"><i class="fa-brands fa-tiktok fa-bounce"></i></a>
            </div>
        </div>
        <div class="col">
            <h4>À mon propos</h4>
            <a href="https://">À propos de l'éditeur : Maamar Metmati</a>
        </div>
        <div class="col">
            <a href="https://maamarmetmati.fr/livres">Tout savoir sur mes compétences</a>
            <h4>Mes Formations en Livre</h4>
            <a href="https://maamarmetmati.fr/articles" target="_blank">Pour lire mes livres</a>
            <a href="https://www.youtube.com/c/" target="_blank">Sur Youtube</a>
            <a href="https://www.facebook.com/" target="_blank">Sur Facebook</a>
            <a href="https://t.me/" target="_blank">Sur Telegram</a>
        </div>
        <div class="siteInternet">
            <a class="p21" href="https://github.com/agweb12">AG WEB 12</a>
            <a class="p21" href="https://agwebcreation.fr">agwebcreation.fr</a>
        </div>
    </div>
    <div class="copyright">
        <p>Copyright @2025 <i id="common" class="fab fa-creative-commons"></i> - apprendrelecode.com - Créé par عبد الرحمن</p>
        <i class="fab fa-fab fa-html5"></i>
        <i class="fab fa-fab fa-css3-alt"></i>
        <i class="fab fa-fab fa-js"></i>
        <i class="fab fa-fab fa-php"></i>
    </div>
</footer>
</body>

</html>