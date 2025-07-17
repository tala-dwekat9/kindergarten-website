<?php
// معلومات الاتصال من Render
$conn = pg_connect("host=dpg-d1sdorh5pdvs73acqt10-a port=5432 dbname=kindergarten_db_bwsx user=kindergarten_db_bwsx_user password=CbXQZDSBQjNnU2b3MGsLJVBcdURX5JzX");

if (!$conn) {
    die("❌ فشل الاتصال بقاعدة البيانات.");
}

// الاستعلام عن أسماء الجداول الموجودة في القاعدة
$query = "SELECT table_name FROM information_schema.tables WHERE table_schema = 'public'";
$result = pg_query($conn, $query);

echo "<h3>✅ الجداول الموجودة:</h3><ul>";
while ($row = pg_fetch_assoc($result)) {
    echo "<li>" . $row['table_name'] . "</li>";
}
echo "</ul>";

pg_close($conn);
?>
