class CallHandler {
  constructor() {
    this.peerConnection = null;
    this.localStream = null;
    this.remoteStream = null;
    this.isCaller = false;
    this.isCallActive = false;
    this.isMuted = false;
  }

  async startCall(userId) {
    try {
      this.isCaller = true;
      document.getElementById("call-container").style.display = "flex";

      // Get audio stream
      this.localStream = await navigator.mediaDevices.getUserMedia({
        audio: true,
        video: false,
      });

      // Initialize WebRTC connection
      this.initializePeerConnection();

      // Send call offer to server
      this.sendCallOffer(userId);

      // Play ringtone
      document.getElementById("ringtone").play();
    } catch (error) {
      console.error("Error starting call:", error);
      this.endCall();
    }
  }

  initializePeerConnection() {
    this.peerConnection = new RTCPeerConnection({
      iceServers: [{ urls: "stun:stun.l.google.com:19302" }],
    });

    // Add local stream
    this.localStream.getTracks().forEach((track) => {
      this.peerConnection.addTrack(track, this.localStream);
    });

    // Handle incoming stream
    this.peerConnection.ontrack = (event) => {
      this.remoteStream = event.streams[0];
      const remoteAudio = document.getElementById("remote-audio");
      remoteAudio.srcObject = this.remoteStream;
    };
  }

  async sendCallOffer(userId) {
    const offer = await this.peerConnection.createOffer();
    await this.peerConnection.setLocalDescription(offer);

    // Send offer to server
    $.ajax({
      url: "/app/send-call-offer",
      type: "POST",
      data: {
        userId: userId,
        offer: JSON.stringify(offer),
      },
      success: (response) => {
        if (!response.success) {
          this.endCall();
        }
      },
    });
  }

  endCall() {
    if (this.localStream) {
      this.localStream.getTracks().forEach((track) => track.stop());
    }
    if (this.peerConnection) {
      this.peerConnection.close();
    }

    document.getElementById("call-container").style.display = "none";
    document.getElementById("ringtone").pause();
    document.getElementById("ringtone").currentTime = 0;

    this.isCallActive = false;
    this.localStream = null;
    this.remoteStream = null;
    this.peerConnection = null;
  }

  toggleMute() {
    if (this.localStream) {
      this.isMuted = !this.isMuted;
      this.localStream.getAudioTracks().forEach((track) => {
        track.enabled = !this.isMuted;
      });
      const muteBtn = document.getElementById("toggle-mute-btn");
      muteBtn.classList.toggle("muted");
      muteBtn.querySelector("i").classList.toggle("bx-microphone");
      muteBtn.querySelector("i").classList.toggle("bx-microphone-off");
    }
  }
}

// Initialize call handler
window.callHandler = new CallHandler();

// Global functions
window.startCall = (userId) => window.callHandler.startCall(userId);
window.endCall = () => window.callHandler.endCall();
window.toggleMute = () => window.callHandler.toggleMute();
