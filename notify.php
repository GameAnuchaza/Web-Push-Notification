<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Web-Push-Notification</title>
</head>
<body>
    <p>Web-Push-Notification</p>
    <p>การแจ้งเตือนผ่านเว็บ</p>
<script>
        //console.log เอาไว้เช็คค่าต่างๆ
        
        if ('serviceWorker' in navigator) {
            navigator.serviceWorker.register('service-worker.js')
                .then(function(registration) {
                    // console.log('Service Worker registered with scope:', registration.scope);
                })
                .catch(function(error) {
                    // console.error('Service Worker registration failed:', error);
                });
        }

        $(document).ready(function() {
            
            pushNotify();

            // ตั้งให้ทำการดึงข้อมูลจาก PHP ทุก 1 วินาที (60000 ms)
            setInterval(function() {
                // console.log("Fetching new data from server...");
                pushNotify();
            }, 60000); // 30000 ms = 30 วินาที
        });

 
        function pushNotify() {
            if (!("Notification" in window)) {
                // alert("Web browser does not support desktop notification");
                return;
            }

            // ตรวจสอบว่าอนุญาตให้แสดง notification หรือไม่
            if (Notification.permission !== "granted") {
                Notification.requestPermission().then(function(permission) {
                    if (permission === "granted") {
                        loadNotificationData();
                    } else {
                        // console.log("Notification permission denied");
                    }
                });
            } else {
                loadNotificationData();
            }
        }

       
        function loadNotificationData() {
            // console.log("Sending AJAX request to PHP...");
            $.ajax({
                url: "push-notify.php",
                type: "POST",
                success: function(data, textStatus, jqXHR) {
                    // console.log("AJAX request successful:", data);
                    if ($.trim(data)) {
                        handleNotifications(data);
                    } else {
                        // console.error("No notification data received from server.");
                    }
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    // console.error('Error:', textStatus, errorThrown);
                    // แสดงข้อความแจ้งเตือนผู้ใช้ว่าเกิดข้อผิดพลาดในการดึงข้อมูล
                    // alert("เกิดข้อผิดพลาดในการดึงข้อมูลการแจ้งเตือน กรุณาลองใหม่อีกครั้ง");
                }
            });
        }

        // ฟังก์ชันนี้จะถูกเรียกเพื่อจัดการข้อมูลการแจ้งเตือนที่ได้รับจาก PHP
        function handleNotifications(data) {
            var notifications = JSON.parse(data);

            notifications.forEach(function(notificationData) {
                var notificationTime = new Date(notificationData.notification_time).getTime();
                var currentTime = new Date().getTime();
                var timeDiff = notificationTime - currentTime;

                // หากเวลายังไม่ถึงเวลาที่กำหนด ก็ให้รอจนกว่าจะถึงเวลาแจ้งเตือน
                if (timeDiff > 0) {
                    setTimeout(function() {
                        var notification = new Notification(notificationData.title, {
                            body: notificationData.body,
                            icon: notificationData.icon,
                            data: {
                                url: notificationData.url
                            } // ส่ง URL ในข้อมูล
                        });

                        notification.onclick = function() {
                            window.open(notificationData.url); // ใช้ URL ที่ส่งมาใน notification
                        };

                        // ปิดการแจ้งเตือนหลัง 5 วินาที
                        // setTimeout(function() {
                        //     notification.close();
                        // }, 5000); // ปิดหลัง 5 วินาที
                    }, timeDiff); // ใช้ timeDiff เป็นเวลารอจนถึงเวลาที่กำหนด
                }
            });
        }
    </script>
</body>
</html>
     
   
    
