<?php
// الاتصال بقاعدة البيانات على Render
$conn = pg_connect("host=dpg-d1sdorh5pdvs73acqt10-a port=5432 dbname=kindergarten_db_bwsx user=kindergarten_db_bwsx_user password=CbXQZDSBQjNnU2b3MGsLJVBcdURX5JzX");

if (!$conn) {
    die("فشل الاتصال بقاعدة البيانات.");
}

// تحميل ملف SQL المعدل
$sqlFile = 'cleaned_kindergarten.sql';  // تأكد أن هذا هو اسم الملف الصحيح
$sqlContent = file_get_contents($sqlFile);

if (!$sqlContent) {
    die("❌ فشل في قراءة ملف SQL.");
}

// تقسيم الأوامر بناءً على الفاصلة المنقوطة (;) وتجاهل الأسطر الفارغة أو التعليقات
$statements = array_filter(array_map('trim', explode(";", $sqlContent)));

$success = true;
foreach ($statements as $query) {
    // تخطي التعليقات أو الأسطر الفارغة
    if ($query === '' || strpos($query, '--') === 0) continue;

    $result = pg_query($conn, $query);
    if (!$result) {
        echo "❌ فشل الاستيراد: " . pg_last_error($conn) . "<br>";
        $success = false;
        break;
    }
}

if ($success) {
    echo "<h3 style='color: green;'>✅ تم استيراد البيانات بنجاح</h3>";
} else {
    echo "<h3 style='color: red;'>❌ حدث خطأ أثناء الاستيراد</h3>";
}

pg_close($conn);
?>
