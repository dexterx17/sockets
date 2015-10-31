captureDesktop();
function captureDesktop() {
    if (connection && connection.attachStreams[0]) {
        //connection.attachStreams[0].onended = function() {};
        connection.attachStreams[0].stop();
        // setDefaults();
    }

    constraints = {
        audio: false,
        video: {
            mandatory: {
                chromeMediaSource: 'desktop',
               // chromeMediaSourceId: chromeMediaSourceId,
                maxWidth: 1280,
                maxHeight: 720,
                minFrameRate: 30,
                maxFrameRate: 64,
                minAspectRatio: 1.77,
                googLeakyBucket: true,
                googTemporalLayeredScreencast: true
            },
            optional: []
        }
    };

    navigator.webkitGetUserMedia(constraints, gotStream, getUserMediaError);


    function gotStream(stream) {
        if (!stream) {
            setDefaults();
            console.log("data:text/html,<h1>Internal error occurred while capturing the screen.</h1>");
            return;
        }

        console.log('Connecting to WebSockets server.');

        chrome.browserAction.disable();

        stream.onended = function() {
            setDefaults();
        };


        setupRTCMultiConnection(stream);

    }

    function getUserMediaError(e) {
        setDefaults();
        console.log("data:text/html,<h1>getUserMediaError: " + JSON.stringify(e, null, '<br>') + "</h1><br>Constraints used:<br><pre>" + JSON.stringify(constraints, null, '<br>') + '</pre>');
    }
  
}

var constraints;
var min_bandwidth = 512;
var max_bandwidth = 1048;
var room_password = '';
var room_id = '';


// RTCMultiConnection - www.RTCMultiConnection.org
var connection;

var background_page_id;
var popup_id;

function setBadgeText(text) {
    /*
    chrome.browserAction.setBadgeBackgroundColor({
        color: [255, 0, 0, 255]
    });
    */
    console.log(text);
}

function setupRTCMultiConnection(stream) {
    // www.RTCMultiConnection.org/docs/
    connection = new RTCMultiConnection();

    connection.optionalArgument = {
        optional: [{
            DtlsSrtpKeyAgreement: true
        }, {
            googImprovedWifiBwe: true
        }, {
            googScreencastMinBitrate: 300
        }, {
            googIPv6: true
        }, {
            googDscp: true
        }, {
            googCpuUnderuseThreshold: 55
        }, {
            googCpuOveruseThreshold: 85
        }, {
            googSuspendBelowMinBitrate: true
        }, {
            googCpuOveruseDetection: true
        }],
        mandatory: {}
    };

    connection.channel = connection.sessionid = connection.userid;

    if (room_id && room_id.length) {
        connection.channel = connection.sessionid = connection.userid = room_id;
    }

    connection.autoReDialOnFailure = true;
    connection.getExternalIceServers = false;

    setBandwidth(connection);

    // www.RTCMultiConnection.org/docs/session/
    connection.session = {
        video: true,
        oneway: true
    };

    // www.rtcmulticonnection.org/docs/sdpConstraints/
    connection.sdpConstraints.mandatory = {
        OfferToReceiveAudio: false,
        OfferToReceiveVideo: false
    };

    // www.RTCMultiConnection.org/docs/dontCaptureUserMedia/
    connection.dontCaptureUserMedia = true;

    // www.RTCMultiConnection.org/docs/attachStreams/
    connection.attachStreams.push(stream);

    if (room_password && room_password.length) {
        connection.onRequest = function(request) {
            if (request.extra.password !== room_password) {
                connection.reject(request);
                console.log("data:text/html,<h1>A user tried to join your room with invalid password. His request is rejected. He tried password: " + request.extra.password + " </h2>");
                return;
            }

            connection.accept(request);
        };
    }

    // www.RTCMultiConnection.org/docs/openSignalingChannel/
    var onMessageCallbacks = {};
    var pub = 'pub-c-3c0fc243-9892-4858-aa38-1445e58b4ecb';
    var sub = 'sub-c-d0c386c6-7263-11e2-8b02-12313f022c90';

    WebSocket = PUBNUB.ws;
    var websocket = new WebSocket('wss://pubsub.pubnub.com/' + pub + '/' + sub + '/' + connection.channel);

    var connectedUsers = 0;
    connection.ondisconnected = function() {
        connectedUsers--;
        setBadgeText(connectedUsers);
    };

    websocket.onmessage = function(e) {
        data = JSON.parse(e.data);

        if (data === 'received-your-screen') {
            connectedUsers++;
            setBadgeText(connectedUsers);
        }

        if (data.sender == connection.userid) return;

        if (onMessageCallbacks[data.channel]) {
            onMessageCallbacks[data.channel](data.message);
        };
    };

    websocket.push = websocket.send;
    websocket.send = function(data) {
        data.sender = connection.userid;
        websocket.push(JSON.stringify(data));
    };

    // overriding "openSignalingChannel" method
    connection.openSignalingChannel = function(config) {
        var channel = config.channel || this.channel;
        onMessageCallbacks[channel] = config.onmessage;

        if (config.onopen) setTimeout(config.onopen, 1000);

        // directly returning socket object using "return" statement
        return {
            send: function(message) {
                websocket.send({
                    sender: connection.userid,
                    channel: channel,
                    message: message
                });
            },
            channel: channel
        };
    };

    websocket.onerror = function() {
        console.log("data:text/html,<h1>Failed connecting the WebSockets server. Please click screen icon to try again.</h1>");

        setDefaults();
        chrome.runtime.reload();
    };

    websocket.onclose = function() {
        console.log("data:text/html,<p style='font-size:25px;'>WebSocket connection seems closed. It is not possible to share your screen without using a medium like WebSockets. Please click screen icon to share again.</p>");

        setDefaults();
    };

    websocket.onopen = function() {
      
        setBadgeText(0);

        console.info('WebSockets connection is opened.');

        // www.RTCMultiConnection.org/docs/open/
        var sessionDescription = connection.open({
            dontTransmit: true
        });

        var resultingURL = 'https://www.webrtc-experiment.com/!/?s=' + connection.sessionid;

        if (room_password && room_password.length) {
            resultingURL += '&p=' + room_password;
        }

        console.log("data:text/html,<h1>Copy following private URL:</h1><input type='text' value='" + resultingURL + "' style='width:100%;font-size:1.2em;'><br>You can share this private-session URI with fellows using email or social networks.");
    };
}

function setDefaults() {
    if (connection) {
        connection.close();
        connection.attachStreams = [];
    }

}

function setBandwidth(connection) {
    // www.RTCMultiConnection.org/docs/bandwidth/
    connection.bandwidth = {
        screen: min_bandwidth // 300kbps
    };

    connection.processSdp = function(sdp) {
        sdp = setSendBandwidth(sdp);
        return sdp;
    };

    function setSendBandwidth(sdp) {
        var sdpLines = sdp.split('\r\n');

        // VP8
        var vp8Index = findLine(sdpLines, 'a=rtpmap', 'VP8/90000');
        var vp8Payload;
        if (vp8Index) {
            vp8Payload = getCodecPayloadType(sdpLines[vp8Index]);
        }

        var rtxIndex = findLine(sdpLines, 'a=rtpmap', 'rtx/90000');

        var rtxPayload;
        if (rtxIndex) {
            rtxPayload = getCodecPayloadType(sdpLines[rtxIndex]);
        }

        if (!rtxPayload) {
            return sdp;
        }

        if (!vp8Payload) {
            return sdp;
        }

        var rtxFmtpLineIndex = findLine(sdpLines, 'a=fmtp:' + rtxPayload.toString());
        if (rtxFmtpLineIndex !== null) {
            var appendrtxNext = '\r\n';
            
            if(max_bandwidth < min_bandwidth) {
                max_bandwidth = min_bandwidth;
            }
            
            appendrtxNext += 'a=fmtp:' + vp8Payload + ' x-google-min-bitrate=' + min_bandwidth + '; x-google-max-bitrate=' + max_bandwidth;
            sdpLines[rtxFmtpLineIndex] = sdpLines[rtxFmtpLineIndex].concat(appendrtxNext);
            sdp = sdpLines.join('\r\n');
        }
        return sdp;
    }

    function findLine(sdpLines, prefix, substr) {
        return findLineInRange(sdpLines, 0, -1, prefix, substr);
    }

    function findLineInRange(sdpLines, startLine, endLine, prefix, substr) {
        var realEndLine = endLine !== -1 ? endLine : sdpLines.length;
        for (var i = startLine; i < realEndLine; ++i) {
            if (sdpLines[i].indexOf(prefix) === 0) {
                if (!substr ||
                    sdpLines[i].toLowerCase().indexOf(substr.toLowerCase()) !== -1) {
                    return i;
                }
            }
        }
        return null;
    }

    function getCodecPayloadType(sdpLine) {
        var pattern = new RegExp('a=rtpmap:(\\d+) \\w+\\/\\d+');
        var result = sdpLine.match(pattern);
        return (result && result.length === 2) ? result[1] : null;
    }
}
