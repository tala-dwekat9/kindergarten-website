<?php
// الاتصال بقاعدة البيانات من متغيرات البيئة
$host = getenv("DB_HOST");
$db = getenv("DB_NAME");
$user = getenv("DB_USER");
$password = getenv("DB_PASSWORD");
$port = getenv("DB_PORT");

$conn = pg_connect("host=$host dbname=$db user=$user password=$password port=$port");

if (!$conn) {
    die("فشل الاتصال بقاعدة البيانات.");
}

// مسار ملف SQL (تأكدي إنه بنفس مجلد هذا الملف)
$sqlFile = "kindergarten.sql";

// قراءة محتوى الملف
$sqlContent = file_get_contents($sqlFile);

if (!$sqlContent) {
    die("فشل في قراءة ملف SQL.");
}

// تنفيذ الأوامر
$result = pg_query($conn, $sqlContent);

if ($result) {
    echo "✅ تم استيراد قاعدة البيانات بنجاح!";
} else {
    echo "❌ فشل الاستيراد: " . pg_last_error($conn);
}

pg_close($conn);
?>
