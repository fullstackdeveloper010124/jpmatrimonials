<!-- ===  For Firebase Web Notification Start === -->
<?php /*
<script src="https://www.gstatic.com/firebasejs/8.10.0/firebase-app.js"></script>
<script src="https://www.gstatic.com/firebasejs/8.10.0/firebase-messaging.js"></script>
<script>

    // Fire Base Configuration
    // const firebaseConfig = {
    //     apiKey: "AIzaSyAi1oHX2pLDXDR5DNCIEg16OiyirJcAUy8",
    //     authDomain: "lohana-jivansathi.firebaseapp.com",
    //     projectId: "lohana-jivansathi",
    //     storageBucket: "lohana-jivansathi.appspot.com",
    //     messagingSenderId: "39499881182",
    //     appId: "1:39499881182:web:2af0d7673b177b98dbc04f",
    //     measurementId: "G-7QHE1NVKDP"
    // };

    // firebase.initializeApp(firebaseConfig);
    // const messaging = firebase.messaging();
    // Fire Base Configuration

    <?php
    if($this->router->fetch_class()=='login'){ ?>
        function initializeFireBaseMessaging(){
            messaging
            .requestPermission()
            .then(function () {
                console.log('Notification Permission Granted.'); 
                return messaging.getToken();
            })
            .then(function (tocken){
                document.getElementById('web_device_id').value=tocken;
            })
            .catch(function (reason){
                console.log(reason);
            });
        }
        initializeFireBaseMessaging();
    <?php } else {
        $is_login = $this->common_front_model->checkLogin('return');
        if($is_login){ ?>
            var topic = "chat_topic_web";
            var fcm_server_key = "AAAA_hQzcOA:APA91bEtbO6IvpRRFYcI9mEYqxOt3fsndquRbUEfCZ-Agtrkn5mmZr8aYUw_cbYdsZpc9zpCTv4U0Y7KIvfHFJlJZ026TqZYnyaD82iiwIyFRmBhlZYAeXD2f_jUzAE0yugcscqiJ3yZ";
            function initializeFireBaseMessaging(){
                messaging
                .requestPermission()
                .then(function () {
                    console.log('Notification Permission Granted.'); 
                    return messaging.getToken();
                })
                .then(function (tocken){
                    // Suscribe Topic : 
                    subscribeTokenToTopic(tocken,topic);
                    console.log('web_device_id:'+tocken);
                })
                .catch(function (reason){
                    console.log(reason);
                });
            }
            messaging.onMessage(function (payload){

                var notification_data = payload.data;
                if(Notification.permission=="granted" && notification_data.notification_type != 'topic_notification'){
                    const notificationOption= {
                        body:payload.notification.body,
                        icon:payload.notification.icon,
                        image:payload.notification.image,
                    }
                    // var notification=new Notification(payload.notification.title,notificationOption);
                    // If Custom Chat Forground Notification : 
                    if(notification_data.notification_type == 'custom_chat_message_received'){
                        appendNewMessageReceiver(notification_data); // Make Sure This function is include in custom_chat.js
                    }
                    // notification.onclick= function (ev){
                    //     ev.preventDefault();
                    //     if(payload.notification.click_action !=''){
                    //         window.open(payload.notification.click_action,'_blank');
                    //     }
                    //     notification.close();
                    // }
                    // setTimeout(function (event) {
                    //     notification.close();
                    // }, 4000)
                    
                }else{
                    // console.log('fore ground');
                    getOnlineUsers();
                }
            });
        
        const channel = new BroadcastChannel('sw-messages');
            channel.addEventListener('message', event => {
            var notification_data = event.data;
            console.log('Back Ground STart');
            console.log(notification_data);
            console.log('Back Ground End');
            // If Custom Chat Background Notification : 
            if(notification_data.notification_type == 'custom_chat_message_received'){
                appendNewMessageReceiver(notification_data); // Make Sure This function is include in custom_chat.js
            }
            // If Topic Notification : 
            if(notification_data.notification_type == 'topic_notification'){
                getOnlineUsers(); // Make Sure This function is include in custom_chat.js
            }
        });
        messaging.onTokenRefresh(function (){
            messaging.getToken()
            .then(function (tocken) {
                // Suscribe Topic : 
                subscribeTokenToTopic(tocken,topic);
                console.log('New token:'+tocken);
            })
            .catch(function (reason){
                console.log(reason);
            })
        });
        initializeFireBaseMessaging();

        // Suscribe Topic : 
        function subscribeTokenToTopic(user_tocken, topic) {
            fetch('https://iid.googleapis.com/iid/v1/'+user_tocken+'/rel/topics/'+topic, {
                method: 'POST',
                headers: new Headers({
                'Authorization': 'key='+fcm_server_key
                })
            }).then(response => {
                // console.log(response);
                if (response.status < 200 || response.status >= 400) {
                throw 'Error subscribing to topic: '+response.status + ' - ' + response.text();
                }
                // console.log('Subscribed to "'+topic+'"');
            }).catch(error => {
                // console.error(error);
            })
        }
    <?php }
}?>
</script>
<!-- === For Firebase Web Notification End === -->