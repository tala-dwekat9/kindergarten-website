<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
// الاتصال بقاعدة بيانات Render
$conn = pg_connect("host=dpg-d1sdorh5pdvs73acqt10-a port=5432 dbname=kindergarten_db_bwsx user=kindergarten_db_bwsx_user
 password=CbXQZDSBQjNnU2b3MGsLJVBcdURX5JzX");
if (!$conn) {
    die("❌ فشل الاتصال بقاعدة البيانات.");
}

// تحميل ملف SQL
$sqlFile = 'registrations.sql';
$sqlContent = file_get_contents($sqlFile);

if (!$sqlContent) {
    die("❌ فشل في قراءة ملف SQL.");
}

$statements = array_filter(array_map('trim', explode(";", $sqlContent)));

$success = true;
foreach ($statements as $query) {
    if ($query === '' || strpos($query, '--') === 0) continue;

    $result = pg_query($conn, $query);
    if (!$result) {
        echo "❌ فشل في تنفيذ الاستعلام: " . pg_last_error($conn) . "<br>";
        $success = false;
        break;
    }
}

if ($success) {
    echo "<h3 style='color: green;'>✅ تم رفع الجدول بنجاح</h3>";
} else {
    echo "<h3 style='color: red;'>❌ فشل رفع الجدول</h3>";
}

pg_close($conn);
?>
