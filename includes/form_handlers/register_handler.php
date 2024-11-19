<?php

// تأكد من تفعيل الجلسات
 
// تضمين مكتبة Transliterator
function arabicToEnglish($text) {
    $transliterator = Transliterator::create('Any-Latin; Latin-ASCII');
    return $transliterator->transliterate($text);
}

// بقية الكود بدون تغيير
$fname = ""; // اسم المستخدم الأول
$lname = ""; // اسم المستخدم الأخير
$em = ""; // البريد الإلكتروني
$em2 = ""; // تأكيد البريد الإلكتروني
$password = ""; // كلمة المرور
$password2 = ""; // تأكيد كلمة المرور
$date = ""; // تاريخ التسجيل
$error_array = array(); // أخطاء

if (isset($_POST['register_button'])) {

    // قراءة البيانات من النموذج
    $fname = strip_tags($_POST['reg_fname']);
    $fname = str_replace(' ', '', $fname);
    $fname = ucfirst(strtolower($fname));
    $_SESSION['reg_fname'] = $fname;

    $lname = strip_tags($_POST['reg_lname']);
    $lname = str_replace(' ', '', $lname);
    $lname = ucfirst(strtolower($lname));
    $_SESSION['reg_lname'] = $lname;

    $em = strip_tags($_POST['reg_email']);
    $em = str_replace(' ', '', $em);
    $_SESSION['reg_email'] = $em;

    $em2 = strip_tags($_POST['reg_email2']);
    $em2 = str_replace(' ', '', $em2);
    $_SESSION['reg_email2'] = $em2;

    $password = strip_tags($_POST['reg_password']);
    $password2 = strip_tags($_POST['reg_password2']);

    $date = date("Y-m-d");

    // التحقق من تطابق البريد الإلكتروني
    if ($em == $em2) {
        if (filter_var($em, FILTER_VALIDATE_EMAIL)) {
            $em = filter_var($em, FILTER_VALIDATE_EMAIL);
            $e_check = mysqli_query($con, "SELECT email FROM users WHERE email='$em'");
            $num_rows = mysqli_num_rows($e_check);

            if ($num_rows > 0) {
                array_push($error_array, "البريد الإلكتروني مستخدم مسبقًا<br>");
            }
        } else {
            array_push($error_array, "صيغة البريد الإلكتروني غير صحيحة<br>");
        }
    } else {
        array_push($error_array, "البريد الإلكتروني غير متطابق<br>");
    }

    // التحقق من الطول
    if (strlen($fname) > 25 || strlen($fname) < 2) {
        array_push($error_array, "اسمك الأول يجب أن يكون بين 2 و 25 حرفًا<br>");
    }

    if (strlen($lname) > 25 || strlen($lname) < 2) {
        array_push($error_array, "اسمك الأخير يجب أن يكون بين 2 و 25 حرفًا<br>");
    }

    // التحقق من كلمة المرور
    if ($password != $password2) {
        array_push($error_array, "كلمات المرور غير متطابقة<br>");
    } else {
        if (preg_match('/[^A-Za-z0-9]/', $password)) {
            array_push($error_array, "كلمة المرور يجب أن تحتوي على حروف وأرقام فقط<br>");
        }
    }

    if (empty($error_array)) {
        $password = md5($password);

        // تحويل الأسماء إلى الإنجليزية
        $fname_eng = arabicToEnglish($fname);
        $lname_eng = arabicToEnglish($lname);

        // التحقق من نجاح التحويل
        if (!$fname_eng || !$lname_eng) {
            array_push($error_array, "خطأ في تحويل الاسم إلى الإنجليزية<br>");
        } else {
            // إنشاء اسم المستخدم
            $username = strtolower($fname_eng . "_" . $lname_eng);
            $check_username_query = mysqli_query($con, "SELECT username FROM users WHERE username='$username'");
            $i = 0;

            while (mysqli_num_rows($check_username_query) != 0) {
                $i++;
                $username = strtolower($fname_eng . "_" . $lname_eng . "_" . $i);
                $check_username_query = mysqli_query($con, "SELECT username FROM users WHERE username='$username'");
            }

            // تحديد صورة الملف الشخصي
            $rand = rand(1, 2);
            $profile_pic = ($rand == 1) ? "assets/images/profile_pics/defaults/head_green_sea.png" : "assets/images/profile_pics/defaults/head_wet_asphalt.png";

            // إدخال البيانات إلى قاعدة البيانات
            $query = mysqli_query($con, "INSERT INTO users (first_name, last_name, username, email, password, signup_date, profile_pic, num_posts, num_likes, user_closed, friend_array) VALUES ('$fname', '$lname', '$username', '$em', '$password', '$date', '$profile_pic', '0', '0', 'no', ',')");

            array_push($error_array, "<span style='color: #14C800;'>تم التسجيل بنجاح! يمكنك تسجيل الدخول الآن</span><br>");

            // مسح المتغيرات المؤقتة
            $_SESSION['reg_fname'] = "";
            $_SESSION['reg_lname'] = "";
            $_SESSION['reg_email'] = "";
            $_SESSION['reg_email2'] = "";
        }
    }
}
