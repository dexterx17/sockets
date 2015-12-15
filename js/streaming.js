  // Muaz Khan     - https://github.com/muaz-khan
                // MIT License   - https://www.webrtc-experiment.com/licence/
                // Documentation - https://github.com/muaz-khan/WebRTC-Experiment/tree/master/webrtc-broadcasting

                var config = {
                    openSocket: function(config) {
                        // https://github.com/muaz-khan/WebRTC-Experiment/blob/master/Signaling.md
                        // This method "openSocket" can be defined in HTML page
                        // to use any signaling gateway either XHR-Long-Polling or SIP/XMPP or WebSockets/Socket.io
                        // or WebSync/SignalR or existing implementations like signalmaster/peerserver or sockjs etc.
        
                       // var channel = config.channel || location.href.replace( /\/|:|#|%|\.|\[|\]/g , '');
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
                          setTimeout(function(){
                           joinRoom(room);0
                          },2000);
                    },
                    onNewParticipant: function(numberOfViewers) {
                        document.title = 'Viewers: ' + numberOfViewers;
                    }
                };

                var broadcastUI = broadcast(config);

                /* UI specific */
                var videosContainer = document.getElementById('videos-container') || document.body;

                function joinRoom(room){
                	console.log('joiningRoom'+room.broadcaster);
                	 broadcastUI.joinRoom({
                                roomToken: room.broadcaster,
                                joinUser: room.broadcaster
                            });

                }


                function rotateInCircle(video) {
                    video.style[navigator.mozGetUserMedia ? 'transform' : '-webkit-transform'] = 'rotate(0deg)';
                    setTimeout(function() {
                        video.style[navigator.mozGetUserMedia ? 'transform' : '-webkit-transform'] = 'rotate(360deg)';
                    }, 1000);
                }