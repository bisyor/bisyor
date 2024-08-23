<template>
    <div>
        <div class="container">
            <div class="">
                <div class="">
                    <div class="" role="group">
                        <button
                            type="button"
                            class="user-video-call-button btn btn-primary mr-2 disable-video"
                            v-for="user in allusers"
                            :key="user.id"
                            @click="placeVideoCall(user.id,  user.phone ? user.phone : user.login)"
                        >
                        Видеозвонок <img src="/images/video-camera.svg" alt="" width="25">
                        </button>
                    </div>
                </div>
            </div>
            <!--Placing Video Call-->
            <div class="row" id="video-row">
                <div class="col-12 video-container" v-if="callPlaced">
                    <video
                        ref="userVideo"
                        muted
                        playsinline
                        autoplay
                        class="cursor-pointer"
                        :class="isFocusMyself === true ? 'user-video' : 'partner-video'"
                        @click="toggleCameraArea"
                    />
                    <video
                        ref="partnerVideo"
                        playsinline
                        autoplay
                        class="cursor-pointer"
                        :class="isFocusMyself === true ? 'partner-video' : 'user-video'"
                        @click="toggleCameraArea"
                        v-if="videoCallParams.callAccepted"
                    />
                    <div class="partner-video" v-else>
                        <div v-if="callPartner" class="column items-center q-pt-xl">
                            <div class="col q-gutter-y-md text-center">
                                <p class="q-pt-md">
                                    <strong>{{ callPartner }}</strong>
                                </p>
                                <p>calling...</p>
                            </div>
                        </div>
                    </div>
                    <div class="action-btns">
                        <button type="button" class="btn btn-info" @click="toggleMuteAudio">
                            <img src="/images/mute.svg" alt="" width="25" v-if="isHiddenAudio">
                            <img src="/images/microphone.svg" alt="" width="25" v-if="!isHiddenAudio">
                        </button>
                        <button
                            type="button"
                            class="btn btn-primary mx-4"
                            @click="toggleMuteVideo"
                        >
                            <img src="/images/mute-video.svg" alt="" width="25" v-if="isHiddenVideo">
                            <img src="/images/video-camera.svg" alt="" width="25" v-if="!isHiddenVideo">
                        </button>
                        <button type="button" class="btn btn-danger" @click="endCall">
                            <img src="/images/phone-call.svg" alt="" width="25">
                        </button>
                    </div>
                </div>
            </div>
            <!-- End of Placing Video Call  -->

            <!-- Incoming Call  -->
            <div class="row incoming-video-window" v-if="incomingCallDialog">
                <div class="col incoming-video-wrap">
                    <p>
                        Incoming Call From <strong>{{ callerDetails.name }}</strong>
                    </p>
                    <div class="btn-group" role="group">

                        <button
                            type="button"
                            class="btn btn-danger"
                            data-dismiss="modal"
                            @click="declineCall"
                        >
                            <img src="/images/decline-call.svg" alt="" width="25">
                        </button>
                        <button
                            type="button"
                            class="btn btn-success ml-5"
                            @click="acceptCall"
                        >
                            <img src="/images/video-camera.svg" alt="" width="25">
                        </button>
                    </div>
                </div>
            </div>
            <!-- End of Incoming Call  -->
        </div>
    </div>

    
</template>

<script>
import Peer from "simple-peer";
import { getPermissions } from "../helpers";

const servers = {
    iceServers: [
        {
            urls: "turn:54.160.108.83:3478?transport=udp",
            username: "mupati",
            credential: "mupati101",
        },
    ],
    iceCandidatePoolSize: 10,
};

const pc = new RTCPeerConnection(servers);
const waiting = new Audio('/media/waiting.mp3'); // calling await
const busy = new Audio('/media/busy.mp3'); // abonent busy
const ringtone = new Audio('/media/ringtone.mp3'); // calling ring ring
const endcall_ring = new Audio('/media/endcall.mp3'); // end calling ring ring
const acceptcall = new Audio('/media/acceptcall.mp3'); // end calling ring ring

export default {
    props: [
        "allusers",
        "authuserid",
        "turn_url",
        "turn_username",
        "turn_credential",
        "userDatas",
        "item_owner",
    ],
    data() {
        return {
            isFocusMyself: true,
            callPlaced: false,
            callPartner: null,
            mutedAudio: false,
            mutedVideo: false,
            isHiddenAudio: false,
            isHiddenVideo: false,
            is_calling_user: null,
            videoCallParams: {
                users: [],
                stream: null,
                receivingCall: false,
                caller: null,
                userToCall: null,
                callerSignal: null,
                callAccepted: false,
                channel: null,
                peer1: null,
                peer2: null,
            },
        };
    },

    mounted() {
        this.initializeChannel(); // this initializes laravel echo
        this.initializeCallListeners(); // subscribes to video presence channel and listens to video events
    },
    computed: {
        incomingCallDialog() {
            
            if (
                this.videoCallParams.receivingCall &&
                this.videoCallParams.userToCall === this.authuserid
            ) {
                ringtone.play();
                ringtone.loop = true;
                return true;
            }
            return false;
        },


        callerDetails() {

            if (
                this.videoCallParams.caller &&
                this.videoCallParams.caller !== this.authuserid
            ) {
                const incomingCaller = this.allusers.filter(
                    (user) => user.id === this.videoCallParams.caller
                );

                return {
                    id: this.videoCallParams.caller,
                    name: this.getUserDatas(),
                };
            }
            return null;
        },
    },
    methods: {

        initializeChannel() {
            var chanell_name_user = "hkLmhdsywbisyorewqoc21sq2sswcnjes8sw." + this.item_owner;
            this.videoCallParams.channel = window.Echo.join(chanell_name_user);
        },

        getUserDatas()
        {
            var self = this;

            //axios.get("https://api.bisyor.uz/api/v1/profile/users-value?id="+this.videoCallParams.caller).
            axios.get("https://bisyor.uz/video-chat-user/"+this.videoCallParams.caller).
            then(function(response){
                self.userDatas = response.data.name;

            });

            return self.userDatas;
        },

        getMediaPermission() {
            return getPermissions()
                .then((stream) => {
                    this.videoCallParams.stream = stream;
                    if (this.$refs.userVideo) {
                        this.$refs.userVideo.srcObject = stream;
                    }
                })
                .catch((error) => {
                    console.log(error);
                });
        },

        initializeCallListeners() {
            this.videoCallParams.channel.here((users) => {
                this.videoCallParams.users = users;
            });

            this.videoCallParams.channel.joining((user) => {
                // check user availability
                const joiningUserIndex = this.videoCallParams.users.findIndex(
                    (data) => data.id === user.id
                );
                if (joiningUserIndex < 0) {
                    this.videoCallParams.users.push(user);
                }
            });

            this.videoCallParams.channel.leaving((user) => {
                const leavingUserIndex = this.videoCallParams.users.findIndex(
                    (data) => data.id === user.id
                );
                this.videoCallParams.users.splice(leavingUserIndex, 1);
            });
            
            // listen to incomming call
            this.videoCallParams.channel.listen("StartVideoChat", ({ data }) => {
                // console.log(data);
                if (data.type === "incomingCall") {
                    // add a new line to the sdp to take care of error
                    const updatedSignal = {
                        ...data.signalData,
                        sdp: `${data.signalData.sdp}\n`,
                    };

                    this.videoCallParams.receivingCall = true;
                    this.videoCallParams.caller = data.from;
                    this.videoCallParams.callerSignal = updatedSignal;
                    this.videoCallParams.userToCall = data.userToCall;
                }
                
                if (data.type === "declineCall" && data.item_owner === this.authuserid) {
                    
                    this.declineCallForIncoming();
                }

            });
        },
        async placeVideoCall(id, name) {
            this.item_owner = id;
            this.is_calling_user = id;
            this.newSignal();
            this.callPlaced = true;
            this.callPartner = name;
            await this.getMediaPermission();
            this.videoCallParams.peer1 = new Peer({
                initiator: true,
                trickle: false,
                stream: this.videoCallParams.stream,
                config: pc,
            });

            this.videoCallParams.peer1.on("signal", (data) => {
               
                if(this.countMembers())
                { 
                    this.myChannelDisconnect();
                    axios
                    .post("/video/call-user", {
                        user_to_call: id,
                        signal_data: data,
                        from: this.authuserid,
                        item_owner: this.item_owner,
                    })
                    .then(() => {})
                    .catch((error) => {
                        console.log(error);
                    });
                    
                    waiting.play();
                    waiting.loop = true;
                } else {
                    busy.play();
                    setTimeout(() => window.location.reload(), 2000);
                    this.endCall();
                }
                
                
            });
            
            this.videoCallParams.caller = this.authuserid;  // yangi qoshildi
            this.videoCallParams.peer1.on("stream", (stream) => {
                // console.log("call streaming");
                if (this.$refs.partnerVideo) {
                    this.$refs.partnerVideo.srcObject = stream;
                }
            });

            this.videoCallParams.peer1.on("connect", () => {
                this.myChannelDisconnect();
                waiting.pause();
                acceptcall.play();
                //console.log("peer connected");
            });

            this.videoCallParams.peer1.on("error", (err) => {
                console.log(err);
            });

            this.videoCallParams.peer1.on("close", () => {
                endcall_ring.play();
                setTimeout(() => window.location.reload(), 2500);
                this.endCall2();
            });

            this.videoCallParams.channel.listen("StartVideoChat", ({ data }) => {
                
                if (data.type === "callAccepted") {
                   
                    if (data.signal.renegotiate) {
                        //console.log("renegotating");
                    }
                    if (data.signal.sdp) {
                        this.videoCallParams.callAccepted = true;
                        const updatedSignal = {
                            ...data.signal,
                            sdp: `${data.signal.sdp}\n`,
                        };
                        this.videoCallParams.peer1.signal(updatedSignal);
                    }
                }
                
                if (data.type === "declineCall" && data.user == this.authuserid) {
                  //console.log("decline");
                    waiting.pause();
                    busy.play();
                    this.endCall();
                    //$('#gudok-pause').trigger('click');
                }
                
            });
        },

        async acceptCall() {
            ringtone.pause();
            this.callPlaced = true;
            this.videoCallParams.callAccepted = true;
            await this.getMediaPermission();
            this.videoCallParams.peer2 = new Peer({
                initiator: false,
                trickle: false,
                stream: this.videoCallParams.stream,
                config: pc,
            });
            this.videoCallParams.receivingCall = false;
            this.videoCallParams.peer2.on("signal", (data) => {
                axios
                    .post("/video/accept-call", {
                        signal: data,
                        to: this.videoCallParams.caller,
                        item_owner: this.item_owner,
                    })
                    .then(() => {})
                    .catch((error) => {
                        console.log(error);
                    });
            });

            this.videoCallParams.peer2.on("stream", (stream) => {
                this.videoCallParams.callAccepted = true;
                this.$refs.partnerVideo.srcObject = stream;
            });

            this.videoCallParams.peer2.on("connect", () => {
                //console.log("peer connected");
                acceptcall.play();
                this.videoCallParams.callAccepted = true;
            });

            this.videoCallParams.peer2.on("error", (err) => {
                console.log(err);
            });

            this.videoCallParams.peer2.on("close", () => {
                endcall_ring.play();
                this.endCall2();
                //console.log("call closed accepter");
            });
            
            //console.log(this.videoCallParams.callerSignal);
            this.videoCallParams.peer2.signal(this.videoCallParams.callerSignal);
        },
        toggleCameraArea() {
            if (this.videoCallParams.callAccepted) {
                this.isFocusMyself = !this.isFocusMyself;
            }
        },
        getUserOnlineStatus(id) {
            const onlineUserIndex = this.videoCallParams.users.findIndex(
                (data) => data.id === id
            );
            if (onlineUserIndex < 0) {
                return "Offline";
            }
            return "Online";
        },
        
        countMembers()
        {   
            var countMembers = this.videoCallParams.channel.subscription.members.count;
            console.log(countMembers);
            return this.getStatusMyChannel() && countMembers === 2;
        },
        
        getMyId()
        {
            return this.videoCallParams.channel.subscription.members.myID; 
        },
        
        getStatusMyChannel()
        {
            return "presence-hkLmhdsywbisyorewqoc21sq2sswcnjes8sw." + this.getMyId() !== this.videoCallParams.channel.name;
        },
        
        myChannelDisconnect()
        {   
            var name = "presence-hkLmhdsywbisyorewqoc21sq2sswcnjes8sw." + this.authuserid;
            window.Echo.leaveChannel(name);
        },
        
        declineCall() {
            ringtone.pause();
            
            this.videoCallParams.peer2 = new Peer({ 
                initiator: true,
                config: pc,
            }); 
         
            this.videoCallParams.peer2.on("signal", (data) => {
                axios
                    .post("/video/decline-call", {
                        signal: data,
                        user: this.videoCallParams.caller,
                        item_owner: this.item_owner,
                    })
                    .then(() => {})
                    .catch((error) => {
                        console.log(error);
                    });
            });
            
            this.videoCallParams.receivingCall = false;
        },
            
            
            // foor end  calling  telfon qilishdagi ochirish
        declineCallForEndCall() {
            ringtone.pause();
            
            this.videoCallParams.peer2 = new Peer({ 
                initiator: true,
                config: pc,
            }); 
         
            this.videoCallParams.peer2.on("signal", (data) => {
                axios
                    .post("/video/decline-call", {
                        signal: data,
                        user: this.videoCallParams.caller,
                        item_owner: this.is_calling_user,
                    })
                    .then(() => {})
                    .catch((error) => {
                        console.log(error);
                    });
            });
            
            this.videoCallParams.receivingCall = false;
        },
        
        
        declineCallForIncoming() {
            ringtone.pause();
            this.videoCallParams.receivingCall = false;
        },

        toggleMuteAudio() {
            if (this.mutedAudio) {
                this.$refs.userVideo.srcObject.getAudioTracks()[0].enabled = true;
                this.mutedAudio = false;
                this.isHiddenAudio = false;
            } else {
                this.$refs.userVideo.srcObject.getAudioTracks()[0].enabled = false;
                this.mutedAudio = true;
                this.isHiddenAudio = true;
            }
        },

        toggleMuteVideo() {
            // console.log(this.mutedVideo);

            if (this.mutedVideo) {
                this.$refs.userVideo.srcObject.getVideoTracks()[0].enabled = true;
                this.mutedVideo = false;
                this.isHiddenVideo = false;
            } else {
                this.$refs.userVideo.srcObject.getVideoTracks()[0].enabled = false;
                this.mutedVideo = true;
                this.isHiddenVideo = true;
            }
        },

        stopStreamedVideo(videoElem) {
            const stream = videoElem.srcObject;
            const tracks = stream.getTracks();
            tracks.forEach((track) => {
                track.stop();
            });
            videoElem.srcObject = null;
        },
        
        
        endCall() {
           
            if (this.authuserid === this.videoCallParams.caller) {
                this.declineCallForEndCall();
                //console.log('caller-in', this.videoCallParams.caller, 'auth', this.authuserid);
                //console.log('cla-1')
                this.videoCallParams.peer1.destroy();
            } else {
                //console.log('cla-2')
                this.videoCallParams.peer2.destroy();
            }
            
            this.item_owner = this.authuserid;
            this.newSignal();
                
            //console.log( this.videoCallParams.channel.pusher.channels);
            this.videoCallParams.channel.pusher.channels.channels[`presence-hkLmhdsywbisyorewqoc21sq2sswcnjes8sw.${this.item_owner}`].disconnect();

            setTimeout(() => {
                this.callPlaced = false;
            }, 1000);
        },
        
        endCall2() {
            if (!this.mutedVideo) this.toggleMuteVideo();
            if (!this.mutedAudio) this.toggleMuteAudio();
            this.stopStreamedVideo(this.$refs.userVideo);
            if (this.authuserid !== this.videoCallParams.caller) {
                this.videoCallParams.peer2.destroy();
            }else{
                this.videoCallParams.peer1.destroy();
            }
            
            this.item_owner = this.authuserid;
            this.newSignal();
                
            setTimeout(() => {
                this.callPlaced = false;
            }, 1000);
            // if video or audio is muted, enable it so that the stopStreamedVideo method will work
            
        },

        newSignal(){
            this.initializeChannel(); // this initializes laravel echo
            this.initializeCallListeners();
        },
        
    },
};
</script>

<style scoped>
#video-row {

}

#incoming-call-card {
    border: 1px solid #0acf83;
}

.video-container {
    border: 1px solid #0acf83;
    position: absolute;
    box-shadow: 1px 1px 11px #9e9e9e;
    background-color: #fff;
    top: 8%;
    left: 5%;
    width: 90%;
    height: 90%;
    z-index: 50;
}

.video-container .user-video {
    width: 30%;
    position: absolute;
    left: 10px;
    bottom: 10px;
    border: 1px solid #fff;
    border-radius: 6px;
    z-index: 2;
}

.calling_user {
    width: 20px;
}

.video-container .partner-video {
    width: 100%;
    height: 100%;
    position: absolute;
    left: 0;
    right: 0;
    bottom: 0;
    top: 0;
    z-index: 1;
    margin: 0;
    padding: 0;
}

.video-container .action-btns {
    position: absolute;
    bottom: 20px;
    left: 50%;
    margin-left: -50px;
    z-index: 3;
    display: flex;
    flex-direction: row;
}

/* Mobiel Styles */
@media only screen and (max-width: 768px) {
    .video-container {
        height: 50vh;
    }
}

.col-12.video-container {
    position: fixed !important;
    top: 0;
    left: 0;
    right: 0;
    width: 100%;
    height: 100%;
}
</style>
