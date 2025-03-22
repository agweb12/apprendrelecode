/// VIDEO
$(document).scroll(function () {
    var isScrolled = $(this).scrollTop() > $(".topBar").height();
    $(".topBar").toggleClass("scrolled", isScrolled);
})

function volumeToggle(button){
    var muted = $(".previewVideo").prop("muted");
    $(".previewVideo").prop("muted",!muted);

    $(button).find("i").toggleClass("fa-volume-xmark");
    $(button).find("i").toggleClass("fa-volume-up");
}

function previewEnded(){
    $(".previewVideo").toggle();
    $(".previewImage").toggle();

}

function goBack(){
    window.history.back();
}

function initVideo(videoId, pseudo){
    startHideTimer();
    setStartTime(videoId, pseudo);
    updateProgressTimer(videoId, pseudo);
}

function startHideTimer(){
    var timeout = null;

    $(document).on("mousemove", function(){
        clearTimeout(timeout);
        $(".watchNav").fadeIn();

        timeout = setTimeout(function(){
            $(".watchNav").fadeOut();
        }, 2000);
    });
}

function setStartTime(videoId, pseudo){
    $.post("ajax/getProgress.php",{ videoId: videoId, pseudo: pseudo }, function(data){
        if(isNaN(data)){
            alert(data);
            return;
        }

        $("video").on("canplay",function(){
            this.currentTime = data;
            $("video").off("canplay");
        })
    })
}

function updateProgressTimer(videoId, pseudo){
    addDuration(videoId, pseudo);

    var timer;
    $("video").on("playing", function(event) {
        window.clearInterval(timer);
        timer = window.setInterval(function(){
            updateProgress(videoId, pseudo, event.target.currentTime)
        }, 3000);
    })
    .on("ended", function(){
        setfinished(videoId, pseudo);
        window.clearInterval(timer);
    });
}

function addDuration(videoId, pseudo){
    $.post("ajax/addDuration.php", { videoId: videoId, pseudo: pseudo }, function(data){
        if(data !== null && data !== ""){
            alert(data);
        }
    });
}

function updateProgress(videoId, pseudo, progress){
    $.post("ajax/updateDuration.php", { videoId: videoId, pseudo: pseudo, progress: progress }, function(data){
        if(data !== null && data !== ""){
            alert(data);
        }
    })
}

function setfinished(videoId, pseudo){
    $.post("ajax/setFinished.php", { videoId: videoId, pseudo: pseudo }, function(data){
        if(data !== null && data !== ""){
            alert(data);
        }
    })
}

function restartVideo(){
    $("video")[0].currentTime = 0;
    $("video")[0].play();
    $(".upNext").fadeOut();
}

function watchVideo(videoId){
    window.location.href = "watch.php?id=" + videoId;
}

function showUpNext(){
    $(".upNext").fadeIn();

}