<?php $config_data = $this->common_model->get_site_config();?>
<!-- ===  For Firebase Web Notification Start === -->
<script type="module">
    import { initializeApp } from 'https://www.gstatic.com/firebasejs/9.0.0/firebase-app.js';
    import { getMessaging, getToken, onMessage } from 'https://www.gstatic.com/firebasejs/9.0.0/firebase-messaging.js';
    const firebaseConfig = {
        <?php echo $config_data["notification_script"];?>
    };

    const app = initializeApp(firebaseConfig);
    const messaging = getMessaging(app);
    var VapIDKey = '<?php echo $config_data['vapid_key'];?>';
    var topic = "chat_topic_web";
    <?php
    if($this->router->fetch_class()=='login'){ ?>
        function requestPermission() {
            Notification.requestPermission().then((permission) => {
                if (permission === 'granted') {
                    console.log('Notification permission granted.');
                    getToken(messaging, {
                        vapidKey: VapIDKey
                    }).then(token => {
                        unsubscribeTokenToTopic(token,topic);
                        document.getElementById('web_device_id').value=token;
                    }).catch(err => {
                        console.log(err);
                        return false;
                    });
                }
            });
        }
        // Call requestPermission to start the process
        requestPermission();
        function unsubscribeTokenToTopic(token, topic) {
            fetch('<?php echo $base_url.'custom_chat/manageTopicSubscription/remove';?>', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({ token: token, topic: topic })
            })
            .then(response => {
                // console.log(response);
            })
            .catch(error => {
                // console.error('Error:', error);
            });
        }
    <?php } else {
        $is_login = $this->common_front_model->checkLogin('return');
        if($is_login){ ?>
            function requestPermission() {
                Notification.requestPermission().then((permission) => {
                    if (permission === 'granted') {
                        console.log('Notification permission granted.');
                        getToken(messaging, { vapidKey: VapIDKey
                        }).then(token => {
                            subscribeTokenToTopic(token,topic);
                            console.log('web_device_id:'+token);
                        }).catch(err => {
                            console.log(err);
                            return false;
                        });
                    }
                });
            }
            // Call requestPermission to start the process
            //requestPermission();
            // Listen for foreground messages
            onMessage(messaging, (payload) => {
                // console.log(payload);
                var notification_data = payload.data;
                if(Notification.permission=="granted" && notification_data.notification_type != 'topic_notification'){
                    const notificationOption = {
                        body:notification_data.body,
                        icon:notification_data.icon,
                        image:notification_data.image,
                    }
                    var notification=new Notification(notification_data.title,notificationOption);
                    // If Custom Chat Forground Notification : 
                    if(notification_data.notification_type == 'custom_chat_message_received'){
                        appendNewMessageReceiver(notification_data); // Make Sure This function is include in custom_chat.js
                    }
                    notification.onclick= function (ev){
                        ev.preventDefault();
                        if(notification_data !=''){
                            window.open(notification_data.click_action,'_blank');
                        }
                        notification.close();
                    }
                    setTimeout(function (event) {
                        notification.close();
                    }, 4000)
                }else{
                    getOnlineUsers();
                }
            });
        
            const channel = new BroadcastChannel('sw-messages');
                channel.addEventListener('message', event => {
                var notification_data = event.data;
                // If Custom Chat Background Notification : 
                if(notification_data.notification_type == 'custom_chat_message_received'){
                    appendNewMessageReceiver(notification_data); // Make Sure This function is include in custom_chat.js
                }
                // If Topic Notification : 
                if(notification_data.notification_type == 'topic_notification'){
                    getOnlineUsers(); // Make Sure This function is include in custom_chat.js
                }
            });

            setInterval(() => {
                getToken(messaging, { vapidKey: VapIDKey
                }).then(token => {
                    subscribeTokenToTopic(token,topic);
                    console.log('web_device_id:'+token);
                }).catch(err => {
                    console.log(err);
                    return false;
                });
            }, 3600000); // Check every hour
            // These registration tokens come from the client FCM SDKs.
            // Suscribe Topic : 
            function subscribeTokenToTopic(token, topic) {
                fetch('<?php echo $base_url.'custom_chat/manageTopicSubscription/add';?>', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify({ token: token, topic: topic })
                })
                .then(response => {
                    // console.log(response);
                })
                .catch(error => {
                    // console.error('Error:', error);
                });
            }
    <?php }
}?>
</script>
<!-- === For Firebase Web Notification End === -->