var config = {
    openSocket: function(config) {

        //var channel = config.channel || location.href.replace( /\/|:|#|%|\.|\[|\]/g , '');
        var channel = 'http19216818socketsAdministradorvideo';
        var socket = new Firebase('https://webrtc.firebaseIO.com/' + channel);
        socket.channel = channel;
        socket.on("child_added", function(data) {
            config.onmessage && config.onmessage(data.val());
        });
        socket.send = function(data) {
            this.push(data);
        };
        config.onopen && setTimeout(config.onopen, 1);
        socket.onDisconnect().remove();
        return socket;
    },
    onRemoteStream: function(htmlElement) {
        htmlElement.setAttribute('controls', true);
        videosContainer.insertBefore(htmlElement, videosContainer.firstChild);
        htmlElement.play();
        rotateInCircle(htmlElement);
    },
    onRoomFound: function(room) {
        var alreadyExist = document.querySelector('button[data-broadcaster="' + room.broadcaster + '"]');
        if (alreadyExist) return;

    },
    onNewParticipant: function(numberOfViewers) {
        document.title = 'Viewers: ' + numberOfViewers;
    }
};


function captureUserMedia(callback) {
    var constraints = {audio:true,video:true};
   
    if ( DetectRTC.hasWebcam !== true) {
        alert('DetectRTC library is unable to find webcam; maybe you denied webcam access once and it is still denied or maybe webcam device is not attached to your system or another app is using same webcam.');
    }

    var htmlElement = document.createElement('video');
    htmlElement.setAttribute('autoplay', true);
    htmlElement.setAttribute('controls', true);
    videosContainer.insertBefore(htmlElement, videosContainer.firstChild);

    var mediaConfig = {
        video: htmlElement,
        onsuccess: function(stream) {
            config.attachStream = stream;
            callback && callback();

            htmlElement.setAttribute('muted', true);
            rotateInCircle(htmlElement);
        },
        onerror: function() {
            alert('unable to get access to your webcam');
        }
    };
    if (constraints) mediaConfig.constraints = constraints;
    getUserMedia(mediaConfig);
}

var broadcastUI = broadcast(config);

/* UI specific */
var videosContainer = document.getElementById('videos-container') || document.body;
$(document).ready(function(){

    setTimeout(function(){
        captureUserMedia(function() {
            broadcastUI.createRoom({
                roomName: 'Teleoperacion',
                isAudio:true
            });
        });
    },1000);
});



function rotateInCircle(video) {
    video.style[navigator.mozGetUserMedia ? 'transform' : '-webkit-transform'] = 'rotate(0deg)';
    setTimeout(function() {
        video.style[navigator.mozGetUserMedia ? 'transform' : '-webkit-transform'] = 'rotate(360deg)';
    }, 1000);
}