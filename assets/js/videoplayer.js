// CONSTANTES

const playPause = document.querySelector(".play-pause-btn");
const theaterBtn = document.querySelector(".theater-player-btn");
const fullScreenBtn = document.querySelector(".fullscreen-player-btn");
const miniPlayerBtn = document.querySelector(".mini-player-btn");
const muteBtn = document.querySelector(".mute-btn");
// const captionsBtn = document.querySelector(".captions-btn");
const speedBtn = document.querySelector(".speed-btn");
const currentTimeELement = document.querySelector(".current-time");
const totalTimeElement = document.querySelector(".total-time");
const previewImg = document.querySelector(".preview-img");
const thumbnailImg = document.querySelector(".thumbnail-img");
const volumeSlider = document.querySelector(".volume-slider");
const watchContainer = document.querySelector(".watchContainer");
const timelineContainer = document.querySelector(".timeline-container");
const video = document.querySelector("video");


// je ne sais pas quoi

document.addEventListener("keydown", e => {
    const tagName = document.activeElement.tagName.toLowerCase();

    if(tagName === "input") return;
    switch(e.key.toLowerCase()){
        case " ":
            if(tagName === "button") return;
        case "k":
            togglePlay();
        break;
        case "f":
            toggleFullScreenMode();
        break;
        case "t":
            toggleTheaterMode();
        break;
        case "i":
            toggleMiniPlayerMode();
        break;
        case "m":
            toggleMute();
        break;
        case "arrowleft":
        case "j":
            skip(-5);
        break;
        case "arrowright":
        case "l":
            skip(5);
        break;
        // case "c":
        //     toggleCaptions();
        // break;
    }
});

// TIMELINE SECTION
timelineContainer.addEventListener("mousemove", handleTimelineUpdate);
timelineContainer.addEventListener("mousedown", toggleScrubbing);
document.addEventListener("mouseup", e => {
    if (isScrubbing) toggleScrubbing(e);
});
document.addEventListener("mousemove", e => {
    if (isScrubbing) handleTimelineUpdate(e);
});

let isScrubbing = false;
function toggleScrubbing(e){
    const rect = timelineContainer.getBoundingClientRect();
    const percent = Math.min(Math.max(0, e.x - rect.x), rect.width) / rect.width;
    isScrubbing = (e.buttons & 1) === 1;
    watchContainer.classList.toggle("scrubbing", isScrubbing);
    if (isScrubbing){
        wasPaused = video.paused;
        video.pause();
    } else {
        video.currentTime = percent * video.duration;
        if(!wasPaused) video.play();
    }

    handleTimelineUpdate(e);
}

function handleTimelineUpdate(e){
    const rect = timelineContainer.getBoundingClientRect();
    const percent = Math.min(Math.max(0, e.x - rect.x), rect.width) / rect.width;
    const previewImgNumber = Math.max(1, Math.floor((percent * video.duration)/ 10));
    // const previewImgSrc = `entities/videos/previewImages/preview${previewImgNumber}.jpg`;
    // previewImg.src = previewImgSrc;

    timelineContainer.style.setProperty("--preview-position", percent);

    if(isScrubbing){
        e.preventDefault();
        // thumbnailImg.src = previewImgSrc;
        timelineContainer.style.setProperty("--progress-position", percent);
    }
}

// SPEED
speedBtn.addEventListener("click",changeSpeed);

function changeSpeed(){
    let newSpeedRate = video.playbackRate + .25;
    if(newSpeedRate > 2) newSpeedRate = .25;
    video.playbackRate = newSpeedRate;
    speedBtn.textContent = `${newSpeedRate}x`;
}

// CAPTIONS SUBTITLES
// const captions = video.textTracks[0];
// captions.mode = "hidden";

// captionsBtn.addEventListener("click", toggleCaptions);

// function toggleCaptions(){
//     const isHidden = captions.mode === "hidden";
//     captions.mode = isHidden ? "showing" : "hidden";
//     watchContainer.classList.toggle("captions", isHidden);
// }
// DURATION
video.addEventListener("loadeddata", () => {
    totalTimeElement.textContent = formatDuration(video.duration);
});

video.addEventListener("timeupdate", () => {
    currentTimeELement.textContent = formatDuration(video.currentTime);
    const percent = video.currentTime / video.duration;
    timelineContainer.style.setProperty("--progress-position", percent);
});

const leadingZeroFormatter = new Intl.NumberFormat(undefined, {
    minimumIntegerDigits: 2
});

function formatDuration(time){
    const seconds = Math.floor(time % 60);
    const minutes = Math.floor(time / 60) % 60;
    const hours = Math.floor(time / 3600);
    if(hours === 0){
        return `${minutes}:${leadingZeroFormatter.format(seconds)}`;
    } else {
        return `${hours}:${leadingZeroFormatter.format(minutes)}:${leadingZeroFormatter.format(seconds)}`;
    }

}

function skip(duration){
    video.currentTime += duration;
}


// VOLUME
muteBtn.addEventListener("click", toggleMute);
volumeSlider.addEventListener("input", e => {
    video.volume = e.target.value;
    video.muted = e.target.value === 0;
})

function toggleMute(){
    video.muted = !video.muted;
}

video.addEventListener("volumechange", () => {
    volumeSlider.value = video.volume;
    let volumeLevel;
    if(video.muted || video.volume === 0){
        volumeSlider.value = 0;
        volumeLevel = "muted";
    } else if(video.volume >= .5){
        volumeLevel = "high";
    } else {
        volumeLevel = "low";
    }

    watchContainer.dataset.volumeLevel = volumeLevel;
})

//VIEW MODES

theaterBtn.addEventListener("click", toggleTheaterMode);
fullScreenBtn.addEventListener("click", toggleFullScreenMode);
miniPlayerBtn.addEventListener("click", toggleMiniPlayerMode);

function toggleTheaterMode(){
    watchContainer.classList.toggle("theater");
}

function toggleFullScreenMode(){
    if(document.fullscreenElement == null){
        watchContainer.requestFullscreen();
    } else {
        document.exitFullscreen();
    }
}

function toggleMiniPlayerMode(){
    if(watchContainer.classList.contains("mini-player")){
        document.exitPictureInPicture();
    } else {
        video.requestPictureInPicture();
    }
}

document.addEventListener("fullscreenchange", () => {
    watchContainer.classList.toggle("full-screen", document.fullscreenElement);
});

video.addEventListener("enterpictureinpicture", () => {
    watchContainer.classList.add("mini-player");
});

video.addEventListener("leavepictureinpicture", () => {
    watchContainer.classList.remove("mini-player");
});

// PLAY / PAUSE
playPause.addEventListener("click", togglePlay);
video.addEventListener("click", togglePlay);

function togglePlay(){
    video.paused ? video.play() : video.pause();
}

video.addEventListener("play", () => {
    watchContainer.classList.remove("paused");
})

video.addEventListener("pause", () => {
    watchContainer.classList.add("paused");
})
