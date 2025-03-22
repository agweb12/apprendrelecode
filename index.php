<?php
require_once('includes/config.php');
require_once('includes/classes/Entity.class.php');
require_once('includes/classes/Video.class.php');

$metaTitle = "Accueil";
$metaDescription = "Apprendre Le code est une plateforme de formation en ligne qui propose des cours de qualité sur le développement web et mobile.";
$metaKeywords = "Apprendre le code, formation en ligne, développement web, développement mobile, HTML, CSS, JavaScript, PHP, MySQL, React, Node.js, Express.js, MongoDB, Python, Django, Flask, Java, Spring, Kotlin, Swift, Flutter, Dart, Android, iOS, Git, GitHub, GitLab, Bitbucket, Visual Studio Code, Sublime Text, Atom, WebStorm, PyCharm, IntelliJ IDEA, Eclipse, Xcode, Android Studio, Bootstrap, Tailwind CSS, Materialize CSS, Bulma, Foundation, Semantic UI, Ant Design, Material-UI, React Bootstrap, React Native, Ionic, Cordova, PhoneGap, NativeScript, Electron, NW.js, Angular, Vue.js, Svelte, Ember.js, Backbone.js, Meteor, Aurelia, Knockout.js, Polymer, Stencil, Preact, Alpine.js, LitElement, Lit, Redux, MobX, Vuex, Apollo Client, Relay, GraphQL, REST, WebSocket, WebRTC, WebSockets, Socket.IO, SignalR, MQTT, XMPP, STOMP, MQTT.js, Paho, Mosquitto, RabbitMQ, Kafka, NATS, ZeroMQ, ActiveMQ, Redis, RabbitMQ, Kafka, NATS, ZeroMQ, ActiveMQ, Redis, Memcached, SQLite, PostgreSQL, MySQL, MariaDB, Oracle, SQL Server, MongoDB, CouchDB, Cassandra, Firebase, Firestore, Realm, Realm Database, Realm Sync, Realm Studio, Realm Cloud, Realm Platform, Realm Mobile Database, Realm Mobile Platform";
$metaIndex = "index";
$metaFollow = "follow";
$metaImageSrc = "metmati-maamar.jpg";
$CssStyle = "assets/style/style.css";
$canonical = "acceuil";
$script2 = "";
$script = "";
$content = ob_get_clean();
require_once("includes/header.php");

$preview = new PreviewProvider($connection, $userLoggedIn);
echo $preview->createPreviewVideo(null);
echo "<h1 class='accueilMetmati'>Accueil</h1>";
echo "<p class='metaDescriptif'>Toutes les vidéos de Metmati Maamar sous format de séries et d'interventions sur l'Islam</p>";
echo "<p class='alertImportante'>Inscrivez-vous GRATUITEMENT pour accéder à toutes les fonctionnalités vidéos : Vidéos déjà visualisées, en cours de visionnage ou encore, reprendre les vidéos là où vous vous êtes arrêtés.</p>";
$containers = new CategoryContainers($connection, $userLoggedIn);
echo $containers->showAllCategories();
require_once("includes/footer.php");
