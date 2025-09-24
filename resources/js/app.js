import './bootstrap';
import Alpine from 'alpinejs';
window.Alpine = Alpine;
Alpine.start();

import { initializeApp } from "firebase/app";
import { getMessaging, getToken } from "firebase/messaging";

const firebaseConfig = {
  apiKey: "AIzaSyBQCPTwnybdtLNUwNCzDDA23TLt3pD5zP4",
  authDomain: "omdachina25.firebaseapp.com",
  projectId: "omdachina25",
  storageBucket: "omdachina25.firebasestorage.app",
  messagingSenderId: "1031143486488",
  appId: "1:1031143486488:web:0a662055d970826268bf6d",
  measurementId: "G-G9TLSKJ92H"
};

const app = initializeApp(firebaseConfig);
const messaging = getMessaging(app);

// نفّذها بعد تحميل الصفحة وبعد تسجيل دخول المستخدم
document.addEventListener('DOMContentLoaded', async () => {
    try {
        const currentToken = await getToken(messaging, { vapidKey: "5JoIvtj7AdKPL-ZNuFgIw04AW4EU6VnPX0hbXi6mIx4" });
        console.log("FCM Token:", currentToken); // لازم يظهر هنا في Console
        if(currentToken){
            await fetch("/save-fcm-token", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify({ token: currentToken })
            });
        }
    } catch(e) {
        console.error("Error retrieving FCM token:", e);
    }
});
