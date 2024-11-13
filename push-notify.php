<?php
// กำหนดค่าของ Web Notification Payload หลายรายการ
$notifications = [
    [
        'title' => 'First Push Notification',
        'body' => 'This is the first notification from PHP.',
        'icon' => 'https://yt3.googleusercontent.com/ytc/AIdro_lqQ_x3gNjJLyJrwodzFTe20hFqHe92Ypz2vSYwfxepxdI=s900-c-k-c0x00ffffff-no-rj',
        'url' => 'https://www.youtube.com/@GameAnuchaza',
        'notification_time' => '2024-11-06 16:10:00' // เวลาสำหรับการแจ้งเตือนแรก
    ],
    [
        'title' => 'Second Push Notification',
        'body' => 'This is the second notification from PHP.',
        'icon' => 'https://yt3.googleusercontent.com/ytc/AIdro_lqQ_x3gNjJLyJrwodzFTe20hFqHe92Ypz2vSYwfxepxdI=s900-c-k-c0x00ffffff-no-rj',
        'url' => 'https://www.youtube.com/@GameAnuchaza',
        'notification_time' => '2024-11-06 16:10:00' // เวลาสำหรับการแจ้งเตือนที่สอง
    ],
    [
        'title' => 'Third Push Notification',
        'body' => 'This is the third notification from PHP.',
        'icon' => 'https://yt3.googleusercontent.com/ytc/AIdro_lqQ_x3gNjJLyJrwodzFTe20hFqHe92Ypz2vSYwfxepxdI=s900-c-k-c0x00ffffff-no-rj',
        'url' => 'https://www.youtube.com/@GameAnuchaza',
        'notification_time' => '2024-11-06 16:11:00' // เวลาสำหรับการแจ้งเตือนที่สาม
    ]
];

// ส่งข้อมูลการแจ้งเตือนกลับไปยัง Client
echo json_encode($notifications);
exit();
?>