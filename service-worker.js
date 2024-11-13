self.addEventListener('push', function(event) {

    var options = {
        body: 'New Notification',
        icon: '/path/to/icon.png',
        badge: '/path/to/badge.png',
        data: {
            url: ''
        },
   
        actions: [
            {
                action: 'open_url',
                title: 'Open Link'
            }
        ]
    };

    if (event.data) {

        try {
            var payload = event.data.json();
            options.body = payload.body || options.body; 
            options.data.url = payload.url || options.data.url;
        } catch (e) {
            console.error('Error parsing push data:', e);
        }
    }

    // แสดงการแจ้งเตือน
    event.waitUntil(
        self.registration.showNotification('Push Notification', options)
    );
});

// กำหนดฟังก์ชันเมื่อผู้ใช้คลิกที่การแจ้งเตือน
self.addEventListener('notificationclick', function(event) {
    // ปิดการแจ้งเตือนเมื่อคลิก
    event.notification.close();

    // ตรวจสอบว่า URL มีอยู่ในข้อมูลหรือไม่
    if (event.notification.data && event.notification.data.url) {
        // ถ้ามี URL ให้เปิดในแท็บใหม่
        event.waitUntil(
            clients.openWindow(event.notification.data.url)
        );
    } else {
        // ถ้าไม่มี URL ก็เปิดหน้าเริ่มต้น
        event.waitUntil(
            clients.openWindow('/')
        );
    }
});

// ตรวจสอบและข้ามการติดตั้งถ้าเป็นเวอร์ชันใหม่ของ Service Worker
self.addEventListener('install', (event) => {
    self.skipWaiting(); // บังคับให้ Service Worker ใช้งานทันทีหลังจากติดตั้งเสร็จ
});
