<?php
require_once('includes/config.php');
$metaTitle = "Recherche des vidéos";
$metaDescription = "Recherchez facilement les interventions, séries ou débats réalisées par Metmati Maamar";
$metaIndex = "noindex";
$metaFollow = "nofollow";
$metaImageSrc = "metmati-maamar.jpg";
$CssStyle = "assets/style/style.css";
$canonical = 'recherche';
$script2 = "";
$script = "";
$content = ob_get_clean();
include_once("includes/header.php")
?>
<div class="textBoxContainer">
    <input type="text" class="searchInput" placeholder="Rechercher une intervention ou une série">
    <button class="barre" onclick="toggleNotaBene()">En savoir plus sur le fonctionnement de la barre de recherche</button>
    <div id="notaBene">
        <p><i>Nota Bene 1</i> : La barre de recherche fonctionne suivant l'occurrence que vous avez rentrée (les minuscules ou majuscules sont omises)</p>
        <p><i>Nota Bene 2</i> : Plus vous rentrez de mots, moins vous avez de chance de trouver votre série ou intervention</p>
        <p><i>Nota Bene 3</i> : La barre de recherche ne peut pas rechercher des vidéos à l'intérieur d'une série. Elle prend en compte les séries ET les interventions</p>
        <p>Prenons l'exemple d'un mot existant : <i>Tariq Ramadan</i></p>
        <p style="color:#999999"><i style="color:#999999">Ex 1</i> : "Tariq", "tariq", "tariq ramadan", "Tariq ramadan"</p><p>-Cela vous ressortira toutes les séries ou interventions uniques dont les occurrences existent (Ex : "Série Décryptage <i>Tariq Ramadan</i>", "Précision sur la lettre ouverte à <i>Tariq</i> Ramadan")</p>
        <p style="color:#999999"><i style="color:#999999">Ex 2</i> : "Ta"</p><p>- Cela vous ressortira toutes les séries ou interventions dont les occurrences entrées existent (exemples : "Omar ibn al-khat<i>ta</i>b","le <i>ta</i>bligh", "série : réfu<i>ta</i>tions de Zakaria Ababoua","série spécial <i>ta</i>rawih", "Lettre ouverte à<i>Ta</i>riq Ramadan")</p>
        <p style="color:#999999"><i style="color:#999999">Ex 3</i> : "Tar"</p><p>- Cela vous ressortira toutes les séries ou interventions dont les occurrences entrées existent (exemples : "série spécial <i>tar</i>awih", "Lettre ouverte à<i>Tar</i>iq Ramadan", "série spécial <i>tar</i>awih")</p>
        <p style="color:#999999"><i style="color:#999999">Ex 4</i> : "Tari"</p><p>- Cela vous ressortira toutes les séries ou interventions dont les occurrences entrées existent (exemple : "Lettre ouverte à<i>Tari</i>q Ramadan")</p>
        <p style="color:#999999"><i style="color:#999999">Ex 5</i> : "série tariq ramadan"</p><p style="color:red">-Rien n'apparaîtra car l'occurrence exacte n'existe pas</p>
        <p style="color:#999999"><i style="color:#999999">Ex 6</i> : "série <i>:</i> tariq ramadan"</p><p>-Cela vous ressortira les séries ou interventions qui contiennent exactement cette occurrence (exemple : "<i>Série : Tariq Ramadan</i> - études de sa politique et de ses livres")</p>
    </div>
    
</div>
<div class="results"></div>
<script>
    $(function(){
        var pseudo = '<?php echo $userLoggedIn ?>';
        var timer;

        $(".searchInput").keyup(function(){
            clearTimeout(timer);

            timer = setTimeout(function(){
                var val = $(".searchInput").val();
                if(val != ""){
                    $.post("ajax/getSearchResults.php", {term: val, pseudo: pseudo }, function(data){
                        $(".results").html(data);
                    })
                }
                else{
                    $(".results").html("");
                }

            }, 500);
        })
    })

    function toggleNotaBene(){
        var notabene = document.querySelector('#notaBene');
        notabene.classList.toggle("visibility");
    }
</script>
<?php
include_once("includes/footer.php");
?>