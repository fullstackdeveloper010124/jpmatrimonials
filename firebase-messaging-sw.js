importScripts('https://www.gstatic.com/firebasejs/8.10.0/firebase-app.js');
importScripts('https://www.gstatic.com/firebasejs/8.10.0/firebase-messaging.js');
const firebaseConfig = {
    apiKey: "AIzaSyA53xdH7VSu4UVMn1DhBcAdof6WAHp6mSo",
    authDomain: "shehnayi-matrimonial-26916.firebaseapp.com",
    projectId: "shehnayi-matrimonial-26916",
    storageBucket: "shehnayi-matrimonial-26916.appspot.com",
    messagingSenderId: "198749134179",
    appId: "1:198749134179:web:7180c47cc934c5216b0756"
};

firebase.initializeApp(firebaseConfig);
const messaging = firebase.messaging();
messaging.onBackgroundMessage((payload) => {
    // console.log('Background : ', payload );
    var notification_data = payload.data;
    // Send Data To our firebase_js.php : Date : 19-11-2021
    const channel = new BroadcastChannel('sw-messages');
    channel.postMessage(notification_data);
    // Customize notification here
    if(notification_data.notification_type != 'topic_notification'){
        const notificationOptions = {
            body:payload.notification.body,
            icon:payload.notification.icon,
            image:payload.notification.image,
        };
        self.registration.showNotification(payload.notification.title,notificationOptions);
    }else{
        // console.log(payload);
        // console.log('back ground');
    }
});