<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // قراءه معلومات قاعدة البيانات من متغيرات البيئة
    $host = getenv("DB_HOST");
    $db = getenv("DB_NAME");
    $user = getenv("DB_USER");
    $password = getenv("DB_PASSWORD");
    $port = getenv("DB_PORT");

    // الاتصال بقاعدة البيانات
    $conn = pg_connect("host=$host dbname=$db user=$user password=$password port=$port");

    if (!$conn) {
        die("فشل الاتصال بقاعدة البيانات.");
    }
    // دوال آمنة
    function safeString($key) {
        return isset($_POST[$key]) && $_POST[$key] !== '' ? "'" . pg_escape_string($_POST[$key]) . "'" : "NULL";
    }

    function safeInt($key) {
        return isset($_POST[$key]) && $_POST[$key] !== '' ? (int) $_POST[$key] : "NULL";
    }

    function safeDate($key) {
        return isset($_POST[$key]) && $_POST[$key] !== '' ? "'" . $_POST[$key] . "'" : "NULL";
    }

    // رفع الصور
    $uploads_dir = 'uploads';
    function handleUpload($file_input_name) {
        global $uploads_dir;
        if (isset($_FILES[$file_input_name]) && $_FILES[$file_input_name]['error'] === UPLOAD_ERR_OK) {
            $tmp_name = $_FILES[$file_input_name]['tmp_name'];
            $name = basename($_FILES[$file_input_name]['name']);
            $target_path = "$uploads_dir/" . uniqid() . "_" . $name; // لتجنب التكرار
            if (move_uploaded_file($tmp_name, $target_path)) {
                return "'" . pg_escape_string($target_path) . "'";
            }
        }
        return "NULL";
    }

    // استدعاء القيم من النموذج
    $child_name             = safeString('child_name');
    $birth_date             = safeDate('birth_date');
    $birth_place            = safeString('birth_place');
    $nationality            = safeString('nationality');
    $religion               = safeString('religion');
    $residence              = safeString('residence');
    $home_phone             = safeString('home_phone');
    $mother_phone           = safeString('mother_phone');
    $father_phone           = safeString('father_phone');
    $brothers               = safeInt('brothers');
    $sisters                = safeInt('sisters');
    $child_order            = safeString('child_order');
    $father_job             = safeString('father_job');
    $father_workplace       = safeString('father_workplace');
    $father_work_phone      = safeString('father_work_phone');
    $mother_job             = safeString('mother_job');
    $mother_workplace       = safeString('mother_workplace');
    $mother_work_phone      = safeString('mother_work_phone');
    $emergency_contact      = safeString('emergency_contact');
    $child_lives_with       = safeString('child_lives_with');
    $parents_status         = safeString('parents_status');
    $chronic_diseases       = safeString('chronic_diseases');
    $food_allergy_details   = safeString('food_allergy_details');
    $other_disease_details  = safeString('other_disease_details');
    $had_surgery            = safeString('had_surgery');
    $surgery_description    = safeString('surgery_description');
    $takes_medicine         = safeString('takes_medicine');
    $medicine_info          = safeString('medicine_info');
    $vaccinations           = safeString('vaccinations');
    $has_needs              = safeString('has_needs');
    $needs_description      = safeString('needs_description');
    $family_needs           = safeString('family_needs');
    $family_needs_count     = safeInt('family_needs_count');
    $family_needs_type      = safeString('family_needs_type');
    $previous_kindergarten  = safeString('previous_kindergarten');
    $previous_kg_name       = safeString('previous_kg_name');
    $form_date              = safeDate('form_date');

    // رفع الصور
    $photo_child_path       = handleUpload('photo_child');
    $birth_certificate_path = handleUpload('birth_certificate');
    $parent_id_path         = handleUpload('parent_id');

    // استعلام الإدخال
    $query = "
        INSERT INTO registrations (
            child_name, birth_date, birth_place, nationality, religion,
            residence, home_phone, mother_phone, father_phone, brothers,
            sisters, child_order, father_job, father_workplace, father_work_phone,
            mother_job, mother_workplace, mother_work_phone, emergency_contact, child_lives_with,
            parents_status, chronic_diseases, food_allergy_details, other_disease_details, had_surgery,
            surgery_description, takes_medicine, medicine_info, vaccinations, has_needs,
            needs_description, family_needs, family_needs_count, family_needs_type,
            previous_kindergarten, previous_kg_name, form_date,
            photo_child_path, birth_certificate_path, parent_id_path
        ) VALUES (
            $child_name, $birth_date, $birth_place, $nationality, $religion,
            $residence, $home_phone, $mother_phone, $father_phone, $brothers,
            $sisters, $child_order, $father_job, $father_workplace, $father_work_phone,
            $mother_job, $mother_workplace, $mother_work_phone, $emergency_contact, $child_lives_with,
            $parents_status, $chronic_diseases, $food_allergy_details, $other_disease_details, $had_surgery,
            $surgery_description, $takes_medicine, $medicine_info, $vaccinations, $has_needs,
            $needs_description, $family_needs, $family_needs_count, $family_needs_type,
            $previous_kindergarten, $previous_kg_name, $form_date,
            $photo_child_path, $birth_certificate_path, $parent_id_path
        )
    ";

    $result = pg_query($conn, $query);

    if ($result) {
        header("Location: success.php");
        exit();

    } else {
        echo "<script>alert('❌ حدث خطأ أثناء حفظ البيانات');</script>";
        echo pg_last_error($conn);
    }

    pg_close($conn);
}
?>


<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>تسجيل طفل في روضة طيور الجنة</title>
    <link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@400;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        :root {
            --primary-color: #8e44ad;
            --secondary-color: #9b59b6;
            --accent-color: #e84393;
            --light-color: #f5e6ff;
            --dark-color: #2c3e50;
            --success-color: #27ae60;
            --warning-color: #f39c12;
            --error-color: #e74c3c;
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: 'Tajawal', sans-serif;
            background: linear-gradient(135deg, #f5f7fa 0%, #e4e8f0 100%);
            color: var(--dark-color);
            line-height: 1.6;
            padding: 0;
            margin: 0;
        }

        .container {
            max-width: 800px;
            margin: 30px auto;
            background: #fff;
            border-radius: 20px;
            padding: 30px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            position: relative;
            overflow: hidden;
        }

        .container::before {
            content: "";
            position: absolute;
            top: 0;
            right: 0;
            width: 100%;
            height: 10px;
            background: linear-gradient(90deg, var(--primary-color), var(--accent-color));
        }

        h2 {
            text-align: center;
            color: var(--primary-color);
            margin-bottom: 30px;
            font-size: 28px;
            position: relative;
            padding-bottom: 15px;
        }

        h2::after {
            content: "";
            position: absolute;
            bottom: 0;
            right: 50%;
            transform: translateX(50%);
            width: 100px;
            height: 4px;
            background: linear-gradient(90deg, var(--primary-color), var(--accent-color));
            border-radius: 2px;
        }

        .form-header {
            text-align: center;
            margin-bottom: 30px;
        }

        .form-header img {
            width: 120px;
            height: 120px;
            object-fit: contain;
            margin-bottom: 15px;
        }

        .form-header h3 {
            color: var(--primary-color);
            font-size: 22px;
            margin-bottom: 10px;
        }

        .form-header p {
            color: #666;
            font-size: 16px;
        }

        .progress-steps {
            display: flex;
            justify-content: space-between;
            margin-bottom: 30px;
            position: relative;
        }

        .progress-steps::before {
            content: "";
            position: absolute;
            top: 50%;
            right: 0;
            left: 0;
            height: 2px;
            background: #ddd;
            z-index: 1;
        }

        .step {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: #ddd;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #999;
            font-weight: bold;
            position: relative;
            z-index: 2;
            transition: all 0.3s ease;
        }

        .step.active {
            background: var(--primary-color);
            color: white;
            transform: scale(1.1);
        }

        .step.completed {
            background: var(--success-color);
            color: white;
        }

        .form-section {
            display: none;
            animation: fadeIn 0.5s ease;
        }

        .form-section.active {
            display: block;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        fieldset {
            border: none;
            padding: 0;
            margin-bottom: 25px;
        }

        legend {
            font-weight: bold;
            font-size: 1.2rem;
            color: var(--primary-color);
            margin-bottom: 15px;
            display: flex;
            align-items: center;
        }

        legend i {
            margin-left: 10px;
            color: var(--accent-color);
        }

        .form-group {
            margin-bottom: 20px;
            position: relative;
        }

        label {
            display: block;
            margin-bottom: 8px;
            font-weight: 500;
            color: #555;
            transition: all 0.3s ease;
        }

        label.required::after {
            content: " *";
            color: var(--error-color);
        }

        .input-icon {
            position: relative;
        }

        .input-icon i {
            position: absolute;
            top: 50%;
            right: 15px;
            transform: translateY(-50%);
            color: #999;
        }
        img, video {
            max-width: 100%;
            height: auto;
        }

        input, select, textarea {
            width: 100%;
            padding: 12px 15px;
            border: 2px solid #ddd;
            border-radius: 10px;
            font-size: 16px;
            font-family: 'Tajawal', sans-serif;
            transition: all 0.3s ease;
            background-color: #f9f9f9;
        }

        input:focus, select:focus, textarea:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 3px rgba(142, 68, 173, 0.2);
            outline: none;
            background-color: #fff;
        }

        input[type="date"] {
            padding: 11px 15px;
        }

        .form-actions {
            display: flex;
            justify-content: space-between;
            margin-top: 30px;
        }

        button {
            padding: 12px 25px;
            border: none;
            border-radius: 10px;
            font-size: 16px;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        button i {
            margin-left: 8px;
        }

        .btn-next {
            background-color: var(--primary-color);
            color: white;
        }

        .btn-next:hover {
            background-color: var(--secondary-color);
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(142, 68, 173, 0.3);
        }

        .btn-prev {
            background-color: #f1f1f1;
            color: var(--dark-color);
        }

        .btn-prev:hover {
            background-color: #e1e1e1;
        }

        .btn-submit {
            background-color: var(--accent-color);
            color: white;
            width: 100%;
            padding: 15px;
            font-size: 18px;
        }

        .btn-submit:hover {
            background-color: #d63073;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(232, 67, 147, 0.3);
        }

        .form-navigation {
            display: flex;
            justify-content: space-between;
            margin-top: 30px;
        }

        .tooltip {
            position: relative;
            display: inline-block;
            margin-right: 5px;
            color: var(--accent-color);
            cursor: pointer;
        }

        .tooltip .tooltiptext {
            visibility: hidden;
            width: 200px;
            background-color: var(--dark-color);
            color: #fff;
            text-align: center;
            border-radius: 6px;
            padding: 10px;
            position: absolute;
            z-index: 1;
            bottom: 125%;
            right: 50%;
            transform: translateX(50%);
            opacity: 0;
            transition: opacity 0.3s;
            font-size: 14px;
            font-weight: normal;
        }

        .tooltip:hover .tooltiptext {
            visibility: visible;
            opacity: 1;
        }

        .confirmation-message {
            text-align: center;
            padding: 30px;
            display: none;
        }

        .confirmation-message i {
            font-size: 60px;
            color: var(--success-color);
            margin-bottom: 20px;
        }

        .confirmation-message h3 {
            color: var(--primary-color);
            font-size: 24px;
            margin-bottom: 15px;
        }

        .confirmation-message p {
            color: #666;
            font-size: 16px;
            margin-bottom: 25px;
        }

        @media (max-width: 768px) {
            .container {
                margin: 15px;
                padding: 20px;
                border-radius: 15px;
            }

            h2 {
                font-size: 24px;
            }

            .form-header img {
                width: 80px;
                height: 80px;
            }

            input, select, textarea {
                padding: 10px 12px;
                font-size: 15px;
            }

            button {
                padding: 10px 20px;
                font-size: 15px;
            }
        }

        /* Animation for form sections */
        @keyframes slideInRight {
            from { transform: translateX(100px); opacity: 0; }
            to { transform: translateX(0); opacity: 1; }
        }

        @keyframes slideInLeft {
            from { transform: translateX(-100px); opacity: 0; }
            to { transform: translateX(0); opacity: 1; }
        }

        .slide-in-right {
            animation: slideInRight 0.5s ease forwards;
        }

        .slide-in-left {
            animation: slideInLeft 0.5s ease forwards;
        }

        /* أنماط خاصة بالقسم الصحي */
        .health-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
            margin-bottom: 25px;
        }

        .full-width {
            grid-column: 1 / -1;
        }

        .details-field {
            margin-top: 10px;
            padding: 10px;
            background-color: #f8f9fa;
            border-radius: 8px;
            border-right: 3px solid var(--primary-color);
        }

        .attachments-section {
            margin: 30px 0;
            padding: 20px;
            background-color: #f8f9fa;
            border-radius: 10px;
        }

        .attachments-section h4 {
            color: var(--primary-color);
            margin-bottom: 20px;
            display: flex;
            align-items: center;
        }

        .attachments-section h4 i {
            margin-left: 10px;
        }

        .attachment-item {
            display: flex;
            align-items: center;
            margin-bottom: 15px;
            padding: 15px;
            background: white;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.05);
        }

        .attachment-icon {
            width: 50px;
            height: 50px;
            background-color: var(--light-color);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-left: 15px;
            color: var(--primary-color);
            font-size: 20px;
        }

        .attachment-details {
            flex: 1;
        }

        .attachment-details small {
            display: block;
            color: #666;
            font-size: 13px;
            margin-top: 5px;
        }

        .signatures-section {
            margin: 30px 0;
        }

        .signatures-section h4 {
            color: var(--primary-color);
            margin-bottom: 20px;
            display: flex;
            align-items: center;
        }

        .signatures-section h4 i {
            margin-left: 10px;
        }

        .signature-grid {
            display: grid;
            grid-template-columns: 1fr 1fr 1fr;
            gap: 15px;
        }

        @media (max-width: 768px) {
            .health-grid {
                grid-template-columns: 1fr;
            }

            .signature-grid {
                grid-template-columns: 1fr 1fr;
            }
        }

        @media (max-width: 480px) {
            .signature-grid {
                grid-template-columns: 1fr;
            }
        }

        /* أنماط خاصة بالقسم الصحي المحدث */
        .health-intro {
            display: flex;
            align-items: center;
            background: linear-gradient(135deg, #f8f5ff 0%, #f0e9ff 100%);
            padding: 20px;
            border-radius: 15px;
            margin-bottom: 30px;
            border-right: 5px solid var(--primary-color);
        }

        .health-icon {
            width: 70px;
            height: 70px;
            background-color: var(--primary-color);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-left: 20px;
            color: white;
            font-size: 30px;
        }

        .health-text h4 {
            color: var(--dark-color);
            margin-bottom: 10px;
            font-size: 18px;
        }

        .health-text p {
            color: #666;
            font-size: 15px;
        }

        .health-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }

        .health-card {
            background: white;
            border-radius: 15px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.05);
            overflow: hidden;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            border: 1px solid #eee;
        }

        .health-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0,0,0,0.1);
        }

        .card-header {
            display: flex;
            align-items: center;
            padding: 15px 20px;
            background: linear-gradient(135deg, var(--light-color) 0%, #f5e6ff 100%);
            border-bottom: 1px solid #eee;
        }

        .card-header i {
            font-size: 24px;
            color: var(--primary-color);
            margin-left: 15px;
        }

        .card-header h5 {
            font-size: 18px;
            color: var(--dark-color);
            margin: 0;
        }

        .card-body {
            padding: 20px;
        }

        .toggle-switch {
            position: relative;
            display: inline-block;
            width: 120px;
            height: 40px;
            margin-bottom: 20px;
        }

        .toggle-label {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: #f1f1f1;
            border-radius: 20px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .toggle-handle {
            position: absolute;
            top: 3px;
            left: 3px;
            width: 34px;
            height: 34px;
            background-color: white;
            border-radius: 50%;
            box-shadow: 0 2px 5px rgba(0,0,0,0.2);
            transition: transform 0.3s;
        }

        .toggle-text {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            font-weight: bold;
            font-size: 14px;
            color: #666;
        }

        .toggle-off {
            right: 15px;
        }

        .toggle-on {
            left: 15px;
            color: white;
            display: none;
        }

        #chronic_diseases:checked ~ .toggle-label,
        #had_surgery:checked ~ .toggle-label,
        #takes_medicine:checked ~ .toggle-label {
            background-color: var(--primary-color);
        }

        #chronic_diseases:checked ~ .toggle-label .toggle-handle,
        #had_surgery:checked ~ .toggle-label .toggle-handle,
        #takes_medicine:checked ~ .toggle-label .toggle-handle {
            transform: translateX(80px);
        }

        #chronic_diseases:checked ~ .toggle-label .toggle-off,
        #had_surgery:checked ~ .toggle-label .toggle-off,
        #takes_medicine:checked ~ .toggle-label .toggle-off {
            display: none;
        }

        #chronic_diseases:checked ~ .toggle-label .toggle-on,
        #had_surgery:checked ~ .toggle-label .toggle-on,
        #takes_medicine:checked ~ .toggle-label .toggle-on {
            display: block;
        }

        .card-details {
            display: none;
            animation: fadeIn 0.5s ease;
        }

        .disease-select, .needs-select {
            width: 100%;
            padding: 10px 15px;
            border: 2px solid #ddd;
            border-radius: 8px;
            font-family: 'Tajawal', sans-serif;
            background-color: #f9f9f9;
            appearance: none;
            background-image: url("data:image/svg+xml;charset=UTF-8,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='none' stroke='%239b59b6' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3e%3cpolyline points='6 9 12 15 18 9'%3e%3c/polyline%3e%3c/svg%3e");
            background-repeat: no-repeat;
            background-position: right 10px center;
            background-size: 15px;
        }

        .vaccine-status {
            display: flex;
            gap: 15px;
            margin-bottom: 15px;
        }

        .status-option {
            flex: 1;
        }

        .status-option input {
            display: none;
        }

        .status-label {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 10px;
            border: 2px solid #eee;
            border-radius: 10px;
            cursor: pointer;
            transition: all 0.3s;
            text-align: center;
            height: 100%;
        }

        .status-label i {
            font-size: 24px;
            margin-bottom: 5px;
            color: #ccc;
        }

        .status-label span {
            font-size: 14px;
        }

        #vaccine_yes:checked ~ .status-label {
            border-color: var(--success-color);
            background-color: rgba(39, 174, 96, 0.1);
        }

        #vaccine_yes:checked ~ .status-label i {
            color: var(--success-color);
        }

        #vaccine_no:checked ~ .status-label {
            border-color: var(--error-color);
            background-color: rgba(231, 76, 60, 0.1);
        }

        #vaccine_no:checked ~ .status-label i {
            color: var(--error-color);
        }

        .vaccine-note {
            display: flex;
            align-items: center;
            background-color: #f8f9fa;
            padding: 10px 15px;
            border-radius: 8px;
            font-size: 14px;
            color: #666;
        }

        .vaccine-note i {
            margin-left: 10px;
            color: var(--primary-color);
        }

        .signature-preview {
            margin-top: 20px;
            text-align: center;
        }

        .signature-line {
            width: 100%;
            height: 2px;
            background-color: #ddd;
            margin-bottom: 5px;
        }

        .signature-preview p {
            font-size: 14px;
            color: #999;
        }

        /* أنماط قسم المرفقات */
        .attachments-section {
            margin: 40px 0;
            background-color: #f8f9fa;
            border-radius: 15px;
            padding: 20px;
            border: 1px dashed #ddd;
        }

        .attachments-header {
            display: flex;
            align-items: center;
            margin-bottom: 20px;
        }

        .attachments-header i {
            font-size: 24px;
            color: var(--primary-color);
            margin-left: 15px;
        }

        .attachments-header h4 {
            margin: 0;
            color: var(--primary-color);
        }

        .attachment-cards {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
            gap: 15px;
        }

        .attachment-card {
            background: white;
            border-radius: 10px;
            padding: 15px;
            display: flex;
            align-items: center;
            box-shadow: 0 3px 10px rgba(0,0,0,0.05);
            border: 1px solid #eee;
        }

        .attachment-card.required {
            border-right: 3px solid var(--accent-color);
        }

        .attachment-icon {
            width: 50px;
            height: 50px;
            background-color: var(--light-color);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-left: 15px;
            color: var(--primary-color);
            font-size: 20px;
        }

        .attachment-info {
            flex: 1;
        }

        .attachment-info h6 {
            margin: 0 0 5px 0;
            font-size: 16px;
            color: var(--dark-color);
        }

        .attachment-info p {
            margin: 0;
            font-size: 13px;
            color: #777;
        }

        .upload-btn {
            padding: 8px 15px;
            background-color: var(--light-color);
            color: var(--primary-color);
            border-radius: 8px;
            font-size: 14px;
            cursor: pointer;
            transition: all 0.3s;
            display: inline-block;
            border: 1px solid #e0d0f0;
        }

        .upload-btn:hover {
            background-color: var(--primary-color);
            color: white;
        }

        /* تأثيرات الحركة */
        @keyframes pulse {
            0% { transform: scale(1); }
            50% { transform: scale(1.05); }
            100% { transform: scale(1); }
        }

        .health-card:hover .card-header i {
            animation: pulse 1s infinite;
        }

        /* أنماط للجوال */
        @media (max-width: 768px) {
            .health-grid {
                grid-template-columns: 1fr;
            }

            .health-intro {
                flex-direction: column;
                text-align: center;
            }

            .health-icon {
                margin-left: 0;
                margin-bottom: 15px;
            }

            .attachment-cards {
                grid-template-columns: 1fr;
            }

            .vaccine-status {
                flex-direction: column;
            }
        }
    </style>
</head>
<body>

<div id="header"></div>

<div class="container">
    <div class="form-header">
        <img src="img/logo.jpg" alt="شعار روضة طيور الجنة">
        <h3>استمارة التسجيل الإلكتروني</h3>
        <p>نرحب بكم في روضة طيور الجنة، يرجى تعبئة النموذج التالي بدقة</p>
    </div>

    <div class="progress-steps">
        <div class="step active" data-step="1">1</div>
        <div class="step" data-step="2">2</div>
        <div class="step" data-step="3">3</div>
        <div class="step" data-step="4">4</div>
        <div class="step" data-step="5">5</div>
        <div class="step" data-step="6">6</div>
    </div>

    <form id="registrationForm" method="post" action="registration.php" enctype="multipart/form-data">
    <!-- القسم 1: بيانات الطفل الأساسية -->
        <div class="form-section active" id="section1">
            <fieldset>
                <legend><i class="fas fa-child"></i> بيانات الطفل الأساسية</legend>

                <div class="form-group">
                    <label class="required">اسم الطفل الرباعي</label>
                    <div class="input-icon">
                        <input type="text" name="child_name" required placeholder="أدخل الاسم الرباعي للطفل">

                    </div>
                </div>

                <div class="form-group">
                    <label class="required">تاريخ الميلاد</label>
                    <div class="input-icon">
                        <input type="date" name="birth_date" required>

                    </div>
                </div>

                <div class="form-group">
                    <label>مكان الولادة</label>
                    <div class="input-icon">
                        <input type="text" name="birth_place" required placeholder="المستشفى أو المدينة">

                    </div>
                </div>

                <div class="form-group">
                    <label>الجنسية</label>
                    <div class="input-icon">
                        <input type="text" name="nationality" required placeholder="الجنسية">

                    </div>
                </div>

                <div class="form-group">
                    <label>الديانة</label>
                    <div class="input-icon">
                        <input type="text" name="religion" required placeholder="الديانة">

                    </div>
                </div>
            </fieldset>

            <div class="form-navigation">
                <button type="button" class="btn-next" onclick="nextSection(1)">التالي <i class="fas fa-arrow-left"></i></button>
            </div>
        </div>

        <!-- القسم 2: معلومات السكن والاتصال -->
        <div class="form-section" id="section2">
            <fieldset>
                <legend><i class="fas fa-home"></i> معلومات السكن والتواصل</legend>

                <div class="form-group">
                    <label class="required">مكان السكن</label>
                    <div class="input-icon">
                        <input type="text" name="residence" required placeholder="أدخل مكان السكن الحالي">

                    </div>
                </div>

                <div class="form-group">
                    <label>رقم تلفون البيت </label>
                    <div class="input-icon">
                        <input type="tel" name="home_phone" required placeholder="رقم الهاتف الأرضي">

                    </div>
                </div>

                <div class="form-group">
                    <label class="required">هاتف الأم</label>
                    <div class="input-icon">
                        <input type="tel" name="mother_phone" required placeholder="أدخل رقم هاتف الأم">

                    </div>
                </div>

                <div class="form-group">
                    <label class="required">هاتف الأب</label>
                    <div class="input-icon">
                        <input type="tel" name="father_phone" required placeholder="أدخل رقم هاتف الأب">

                    </div>
                </div>
            </fieldset>

            <div class="form-navigation">
                <button type="button" class="btn-prev" onclick="prevSection(2)"><i class="fas fa-arrow-right"></i> السابق</button>
                <button type="button" class="btn-next" onclick="nextSection(2)">التالي <i class="fas fa-arrow-left"></i></button>
            </div>
        </div>

        <!-- القسم 3: أفراد الأسرة -->
        <div class="form-section" id="section3">
            <fieldset>
                <legend><i class="fas fa-users"></i> أفراد الأسرة</legend>

                <div class="form-group">
                    <label>عدد الأخوة</label>
                    <div class="input-icon">
                        <input type="number" name="brothers" min="0" required placeholder="عدد الأخوة الذكور">

                    </div>
                </div>

                <div class="form-group">
                    <label>عدد الأخوات</label>
                    <div class="input-icon">
                        <input type="number" name="sisters" min="0" required placeholder="عدد الأخوات الإناث">

                    </div>
                </div>

                <div class="form-group">
                    <label>ترتيب الطفل في الأسرة</label>
                    <div class="input-icon">
                        <input type="text" name="child_order" required placeholder="مثال: الثاني بين 3 أطفال">

                    </div>
                </div>
            </fieldset>

            <div class="form-navigation">
                <button type="button" class="btn-prev" onclick="prevSection(3)"><i class="fas fa-arrow-right"></i> السابق</button>
                <button type="button" class="btn-next" onclick="nextSection(3)">التالي <i class="fas fa-arrow-left"></i></button>
            </div>
        </div>

        <!-- القسم 4: بيانات الوالدين -->
        <div class="form-section" id="section4">
            <fieldset>
                <legend><i class="fas fa-user-tie"></i> بيانات الوالدين</legend>

                <div class="form-group">
                    <label>مهنة الأب</label>
                    <div class="input-icon">
                        <input type="text" name="father_job" required placeholder="مهنة الأب">

                    </div>
                </div>

                <div class="form-group">
                    <label>مكان عمل الأب</label>
                    <div class="input-icon">
                        <input type="text" name="father_workplace" required placeholder="مكان العمل">

                    </div>
                </div>

                <div class="form-group">
                    <label>هاتف عمل الأب</label>
                    <div class="input-icon">
                        <input type="tel" name="father_work_phone" required placeholder="هاتف العمل">

                    </div>
                </div>

                <div class="form-group">
                    <label>مهنة الأم</label>
                    <div class="input-icon">
                        <input type="text" name="mother_job" required placeholder="مهنة الأم">

                    </div>
                </div>

                <div class="form-group">
                    <label>مكان عمل الأم</label>
                    <div class="input-icon">
                        <input type="text" name="mother_workplace" required placeholder="مكان العمل">

                    </div>
                </div>

                <div class="form-group">
                    <label>هاتف عمل الأم</label>
                    <div class="input-icon">
                        <input type="tel" name="mother_work_phone" required placeholder="هاتف العمل">

                    </div>
                </div>
            </fieldset>

            <div class="form-navigation">
                <button type="button" class="btn-prev" onclick="prevSection(4)"><i class="fas fa-arrow-right"></i> السابق</button>
                <button type="button" class="btn-next" onclick="nextSection(4)">التالي <i class="fas fa-arrow-left"></i></button>
            </div>
        </div>

        <!-- القسم 5: معلومات إضافية -->
        <div class="form-section" id="section5">
            <fieldset>
                <legend><i class="fas fa-info-circle"></i> معلومات إضافية</legend>

                <div class="form-group">
                    <label class="required">وسيلة الاتصال مع الأهل في حالة حدوث الطوارئ</label>
                    <div class="input-icon">
                        <input type="tel" name="emergency_contact" required placeholder="رقم هاتف للطوارئ">

                    </div>
                </div>

                <div class="form-group">
                    <label class="required">يعيش الطفل مع</label>
                    <div class="input-icon">
                        <input type="text" name="child_lives_with" required placeholder="مثال: الوالدين، الأم فقط، الأب فقط">

                    </div>
                </div>

                <div class="form-group">
                    <label class="required">الوضع الحالي للوالدين</label>
                    <div class="input-icon">
                        <select name="parents_status" required>
                            <option value="">-- اختر الوضع --</option>
                            <option value="يعيشان معاً">يعيشان معاً</option>
                            <option value="منفصلين">منفصلين</option>
                            <option value="مطلقين">مطلقين</option>
                            <option value="أحدهم متوفي">أحدهم متوفي</option>
                        </select>

                    </div>
                </div>

            </fieldset>

            <div class="form-navigation">
                <button type="button" class="btn-prev" onclick="prevSection(5)"><i class="fas fa-arrow-right"></i> السابق</button>
                <button type="button" class="btn-next" onclick="nextSection(5)">التالي <i class="fas fa-arrow-left"></i></button>
            </div>
        </div>

        <!-- القسم 6: البطاقة الصحية -->
        <div class="form-section" id="section6">
            <fieldset>
                <legend><i class="fas fa-heartbeat"></i> البطاقة الصحية التفاعلية</legend>

                <div class="health-intro">
                    <div class="health-icon">
                        <i class="fas fa-user-md"></i>
                    </div>
                    <div class="health-text">
                        <h4>معلومات صحية دقيقة تساعدنا على رعاية طفلك بشكل أفضل</h4>
                        <p>نرجو الإجابة بدقة. سيتم عرض الحقول المناسبة بناءً على اختيارك.</p>
                    </div>
                </div>

                <div class="health-grid">
                    <!-- الأمراض المزمنة -->
                    <div class="form-group full-width">
                        <label>هل يعاني الطفل من أمراض مزمنة؟</label>
                        <select id="chronic_diseases_select" name="chronic_diseases">
                            <option value="لا يوجد">لا يوجد</option>
                            <option value="سكري">سكري</option>
                            <option value="صرع">صرع</option>
                            <option value="حساسية لبعض الأطعمة">حساسية لبعض الأطعمة</option>
                            <option value="القلب">أمراض القلب</option>
                            <option value="جلدية">أمراض جلدية</option>
                            <option value="تنفسية">أمراض تنفسية</option>
                            <option value="أخرى">أمراض أخرى</option>
                        </select>
                        <div id="food_allergy_box" class="details-field" style="display:none;">
                            <label>ما الأطعمة التي يتحسس منها؟</label>
                            <input type="text" name="food_allergy_details" placeholder="مثل: الفستق، الحليب">
                        </div>
                        <div id="other_disease_box" class="details-field" style="display:none;">
                            <label>حدد نوع المرض الآخر</label>
                            <input type="text" name="other_disease_details" placeholder="أدخل نوع المرض">
                        </div>
                    </div>

                    <!-- العمليات الجراحية -->
                    <div class="form-group full-width">
                        <label>هل أُجريت للطفل عملية جراحية؟</label>
                        <select id="surgery_select" name="had_surgery">
                            <option value="لا">لا</option>
                            <option value="نعم">نعم</option>
                        </select>
                        <div id="surgery_box" class="details-field" style="display:none;">
                            <label>ما نوع العملية؟</label>
                            <input type="text" name="surgery_description" placeholder="مثال: لوز، فتاق...">
                        </div>
                    </div>

                    <!-- الأدوية -->
                    <div class="form-group full-width">
                        <label>هل يتناول الطفل أي نوع من الأدوية؟</label>
                        <select id="medicine_select" name="takes_medicine">
                            <option value="لا">لا</option>
                            <option value="نعم">نعم</option>
                        </select>
                        <div id="medicine_box" class="details-field" style="display:none;">
                            <label>ما الأدوية التي يتناولها؟</label>
                            <textarea name="medicine_info" rows="2"></textarea>
                        </div>
                    </div>

                    <!-- التطعيمات -->
                    <div class="form-group full-width">
                        <label>هل أخذ الطفل جميع التطعيمات؟</label>
                        <select name="vaccinations">
                            <option value="نعم">نعم</option>
                            <option value="لا">لا</option>
                        </select>
                    </div>

                    <!-- ذوي الاحتياجات الخاصة -->
                    <div class="form-group full-width">
                        <label>هل لدى الطفل احتياجات خاصة؟</label>
                        <select id="needs_select" name="has_needs">
                            <option value="لا يوجد">لا يوجد</option>
                            <option value="حركية">حركية</option>
                            <option value="عقلية">عقلية</option>
                            <option value="نطق">نطق</option>
                            <option value="بصرية">بصرية</option>
                            <option value="أخرى">أخرى</option>
                        </select>
                        <div id="needs_box" class="details-field" style="display:none;">
                            <label>اذكر نوع الاحتياج الخاص</label>
                            <input type="text" name="needs_description">
                        </div>
                    </div>

                    <!-- احتياجات في الأسرة -->
                    <div class="form-group full-width">
                        <label>هل يوجد أحد في الأسرة من ذوي الاحتياجات الخاصة؟</label>
                        <select id="family_needs_select" name="family_needs">
                            <option value="لا">لا</option>
                            <option value="نعم">نعم</option>
                        </select>
                        <div id="family_needs_box" class="details-field" style="display:none;">
                            <label>عدد الحالات</label>
                            <input type="number" name="family_needs_count" min="1">
                            <label>نوعها</label>
                            <input type="text" name="family_needs_type">
                        </div>
                    </div>

                    <!-- روضة سابقة -->
                    <div class="form-group full-width">
                        <label>هل التحق الطفل بروضة أخرى؟</label>
                        <select id="prev_kg_select" name="previous_kindergarten">
                            <option value="لا">لا</option>
                            <option value="نعم">نعم</option>
                        </select>
                        <div id="prev_kg_box" class="details-field" style="display:none;">
                            <label>اسم الروضة</label>
                            <input type="text" name="previous_kg_name">
                        </div>
                    </div>

                    <!-- التاريخ التلقائي -->
                    <div class="form-group full-width">
                        <label>تاريخ تعبئة البطاقة</label>
                        <input type="text" name="form_date" id="form_date" readonly>
                    </div>
                </div>

                <!-- قسم المرفقات -->
                <div class="attachments-section">
                    <div class="attachments-header">
                        <i class="fas fa-paperclip"></i>
                        <h4>المرفقات المطلوبة</h4>
                    </div>

                    <div class="attachment-cards">
                        <div class="attachment-card required">
                            <div class="attachment-icon">
                                <i class="fas fa-camera"></i>
                            </div>
                            <div class="attachment-info">
                                <h6>صورة شخصية للطفل</h6>
                                <p>  تصويروا بالجوال (صورة عادية) </p>
                            </div>
                            <div class="attachment-upload">
                                <label class="upload-btn">
                                    <input type="file" name="photo_child" accept="image/*" required hidden>
                                    <span>رفع الملف</span>
                                </label>
                            </div>
                        </div>

                        <div class="attachment-card required">
                            <div class="attachment-icon">
                                <i class="fas fa-certificate"></i>
                            </div>
                            <div class="attachment-info">
                                <h6>شهادة الميلاد</h6>
                                <p>صورة واضحة عن شهادة الميلاد</p>
                            </div>
                            <div class="attachment-upload">
                                <label class="upload-btn">
                                    <input type="file" name="birth_certificate" accept="image/*,.pdf" required hidden>
                                    <span>رفع الملف</span>
                                </label>
                            </div>
                        </div>

                        <div class="attachment-card required">
                            <div class="attachment-icon">
                                <i class="fas fa-id-card"></i>
                            </div>
                            <div class="attachment-info">
                                <h6>هوية ولي الأمر</h6>
                                <p>صورة عن هوية الأم أو الأب</p>
                            </div>
                            <div class="attachment-upload">
                                <label class="upload-btn">
                                    <input type="file" name="parent_id" accept="image/*,.pdf" required hidden>
                                    <span>رفع الملف</span>
                                </label>
                            </div>
                        </div>
                        </div>
                    </div>


                <div class="form-navigation">
                    <button type="button" class="btn-prev" onclick="prevSection(6)"><i class="fas fa-arrow-right"></i> السابق</button>
                    <button type="submit" class="btn-submit">إتمام التسجيل <i class="fas fa-check-circle"></i></button>
                </div>
            </fieldset>
        </div>


    </form>


</div>

<div id="footer"></div>

<script>
    // Header and footer inclusion
    fetch("header.html")
        .then(response => response.text())
        .then(data => {
            document.getElementById("header").innerHTML = data;
        });

    fetch("footer.html")
        .then(response => response.text())
        .then(data => {
            document.getElementById("footer").innerHTML = data;
        });

    // Form navigation logic
    function nextSection(current) {
        // Validate current section before proceeding
        if(validateSection(current)) {
            document.getElementById(`section${current}`).classList.remove('active');
            document.getElementById(`section${current+1}`).classList.add('active');
            document.getElementById(`section${current+1}`).classList.add('slide-in-right');

            // Update progress steps
            document.querySelector(`.step[data-step="${current}"]`).classList.remove('active');
            document.querySelector(`.step[data-step="${current}"]`).classList.add('completed');
            document.querySelector(`.step[data-step="${current+1}"]`).classList.add('active');

            // Scroll to top of form
            window.scrollTo({top: 0, behavior: 'smooth'});
        }
    }

    function prevSection(current) {
        document.getElementById(`section${current}`).classList.remove('active');
        document.getElementById(`section${current-1}`).classList.add('active');
        document.getElementById(`section${current-1}`).classList.add('slide-in-left');

        // Update progress steps
        document.querySelector(`.step[data-step="${current}"]`).classList.remove('active');
        document.querySelector(`.step[data-step="${current-1}"]`).classList.add('active');

        // Scroll to top of form
        window.scrollTo({top: 0, behavior: 'smooth'});
    }

    function validateSection(sectionNum) {
        let isValid = true;
        const currentSection = document.getElementById(`section${sectionNum}`);
        const requiredInputs = currentSection.querySelectorAll('input[required], select[required]');

        requiredInputs.forEach(input => {
            if(!input.value) {
                input.style.borderColor = 'var(--error-color)';
                isValid = false;

                // Add error message
                if(!input.nextElementSibling || !input.nextElementSibling.classList.contains('error-message')) {
                    const errorMsg = document.createElement('div');
                    errorMsg.className = 'error-message';
                    errorMsg.style.color = 'var(--error-color)';
                    errorMsg.style.fontSize = '14px';
                    errorMsg.style.marginTop = '5px';
                    errorMsg.textContent = 'هذا الحقل مطلوب';
                    input.parentNode.insertBefore(errorMsg, input.nextSibling);
                }
            } else {
                input.style.borderColor = '#ddd';
                if(input.nextElementSibling && input.nextElementSibling.classList.contains('error-message')) {
                    input.nextElementSibling.remove();
                }
            }
        });

        if(!isValid) {
            // Scroll to first error
            const firstError = currentSection.querySelector('input[required][value=""], select[required][value=""]');
            if(firstError) {
                firstError.scrollIntoView({behavior: 'smooth', block: 'center'});
                firstError.focus();
            }
        }

        return isValid;
    }

 

    function resetForm() {
        document.getElementById('registrationForm').reset();
        document.getElementById('registrationForm').style.display = 'block';
        document.getElementById('confirmationMessage').style.display = 'none';
        document.querySelector('.progress-steps').style.display = 'flex';

        // Reset progress steps
        document.querySelectorAll('.step').forEach((step, index) => {
            step.classList.remove('completed');
            if(index === 0) {
                step.classList.add('active');
            } else {
                step.classList.remove('active');
            }
        });

        // Show first section
        document.querySelectorAll('.form-section').forEach((section, index) => {
            if(index === 0) {
                section.classList.add('active');
            } else {
                section.classList.remove('active');
            }
        });

        // Scroll to top
        window.scrollTo({top: 0, behavior: 'smooth'});
    }

    // Add input focus effects
    document.querySelectorAll('input, select, textarea').forEach(input => {
        input.addEventListener('focus', function() {
            this.parentNode.querySelector('label').style.color = 'var(--primary-color)';
            this.parentNode.querySelector('i').style.color = 'var(--primary-color)';
        });

        input.addEventListener('blur', function() {
            this.parentNode.querySelector('label').style.color = '#555';
            this.parentNode.querySelector('i').style.color = '#999';
        });
    });

    // تفعيل حقول التفاصيل عند اختيار "نعم"
    document.querySelectorAll('.has-details').forEach(select => {
        select.addEventListener('change', function() {
            const detailsId = this.name.replace('_', '-') + '-details';
            const detailsField = document.getElementById(detailsId);
            if (detailsField) {
                detailsField.style.display = this.value === 'نعم' ? 'block' : 'none';
                if (this.value === 'نعم') {
                    detailsField.querySelector('input, textarea').focus();
                }
            }
        });
    });

    // تفعيل جميع حقول التفاصيل عند التحميل إذا كانت "نعم" محددة
    document.addEventListener('DOMContentLoaded', function() {
        document.querySelectorAll('.has-details').forEach(select => {
            if (select.value === 'نعم') {
                const detailsId = select.name.replace('_', '-') + '-details';
                const detailsField = document.getElementById(detailsId);
                if (detailsField) {
                    detailsField.style.display = 'block';
                }
            }
        });
    });

    window.addEventListener("DOMContentLoaded", () => {
        const dateField = document.getElementById("form_date");
        const today = new Date().toISOString().split("T")[0];
        if(dateField) dateField.value = today;

        // إظهار الحقول حسب الاختيارات
        document.getElementById("chronic_diseases").addEventListener("change", e => {
            const show = e.target.value === "نعم";
            document.getElementById("chronic-options").style.display = show ? 'block' : 'none';
        });

        document.getElementById("disease_type").addEventListener("change", e => {
            document.getElementById("disease-food").style.display = e.target.value === "حساسية لبعض الأطعمة" ? 'block' : 'none';
            document.getElementById("disease-other").style.display = e.target.value === "أمراض أخرى" ? 'block' : 'none';
        });

        document.getElementById("had_surgery").addEventListener("change", e => {
            document.getElementById("surgery-details").style.display = e.target.value === "نعم" ? 'block' : 'none';
        });

        document.getElementById("takes_medicine").addEventListener("change", e => {
            document.getElementById("medicine-details").style.display = e.target.value === "نعم" ? 'block' : 'none';
        });

        document.getElementById("has_needs").addEventListener("change", e => {
            document.getElementById("needs-details").style.display = e.target.value === "غير ذلك" ? 'block' : 'none';
        });

        document.getElementById("family_needs").addEventListener("change", e => {
            document.getElementById("family-needs-info").style.display = e.target.value === "نعم" ? 'block' : 'none';
        });

        document.getElementById("previous_kindergarten").addEventListener("change", e => {
            document.getElementById("previous-kg-name").style.display = e.target.value === "نعم" ? 'block' : 'none';
        });
    });

    // تفعيل حقول التفاصيل عند التبديل
    document.addEventListener('DOMContentLoaded', function() {
        // تعيين تاريخ اليوم
        const today = new Date().toLocaleDateString('ar-EG');
        document.getElementById('form_date').value = today;

        // تفعيل التبديل للأمراض المزمنة
        const chronicDiseases = document.getElementById('chronic_diseases');
        chronicDiseases.addEventListener('change', function() {
            const details = document.getElementById('chronic-details');
            details.style.display = this.checked ? 'block' : 'none';
            if(this.checked) {
                details.scrollIntoView({behavior: 'smooth', block: 'nearest'});
            }
        });

        // تفعيل التبديل للعمليات الجراحية
        const hadSurgery = document.getElementById('had_surgery');
        hadSurgery.addEventListener('change', function() {
            document.getElementById('surgery-details').style.display = this.checked ? 'block' : 'none';
        });

        // تفعيل التبديل للأدوية
        const takesMedicine = document.getElementById('takes_medicine');
        takesMedicine.addEventListener('change', function() {
            document.getElementById('medicine-details').style.display = this.checked ? 'block' : 'none';
        });

        // تفعيل حقول الأمراض الديناميكية
        const diseaseType = document.getElementById('disease_type');
        diseaseType.addEventListener('change', function() {
            document.getElementById('allergy-field').style.display = this.value === 'حساسية' ? 'block' : 'none';
            document.getElementById('other-disease-field').style.display = this.value === 'أخرى' ? 'block' : 'none';
        });

        // تفعيل حقول الاحتياجات الخاصة
        const hasNeeds = document.getElementById('has_needs');
        hasNeeds.addEventListener('change', function() {
            document.getElementById('needs-details').style.display = this.value === 'أخرى' ? 'block' : 'none';
        });

        // تأثيرات عند رفع الملفات
        document.querySelectorAll('.attachment-card input[type="file"]').forEach(input => {
            input.addEventListener('change', function() {
                if(this.files.length > 0) {
                    const card = this.closest('.attachment-card');
                    card.style.borderColor = 'var(--success-color)';
                    card.style.boxShadow = '0 0 0 2px rgba(39, 174, 96, 0.2)';

                    setTimeout(() => {
                        card.style.borderColor = '#eee';
                        card.style.boxShadow = '0 3px 10px rgba(0,0,0,0.05)';
                    }, 2000);
                }
            });
        });
    });

    // عرض اسم الملف بعد الرفع
    document.querySelectorAll('input[type="file"]').forEach(input => {
        input.addEventListener('change', function() {
            if(this.files.length > 0) {
                const fileName = this.files[0].name;
                const uploadBtn = this.nextElementSibling;
                uploadBtn.innerHTML = `<span>${fileName}</span> <i class="fas fa-check-circle"></i>`;
                uploadBtn.style.backgroundColor = 'var(--success-color)';
                uploadBtn.style.color = 'white';
            }
        });
    });

    document.addEventListener("DOMContentLoaded", function() {
        document.getElementById("form_date").value = new Date().toISOString().split("T")[0];

        const toggleField = (selectId, boxId, value = "نعم") => {
            document.getElementById(selectId).addEventListener("change", function() {
                document.getElementById(boxId).style.display = this.value === value ? "block" : "none";
            });
        };

        toggleField("chronic_diseases_select", "food_allergy_box", "حساسية لبعض الأطعمة");
        toggleField("chronic_diseases_select", "other_disease_box", "أخرى");

        toggleField("surgery_select", "surgery_box");
        toggleField("medicine_select", "medicine_box");
        toggleField("needs_select", "needs_box", "أخرى");
        toggleField("family_needs_select", "family_needs_box");
        toggleField("prev_kg_select", "prev_kg_box");
    });
</script>
</body>
</html>