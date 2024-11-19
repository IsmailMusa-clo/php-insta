<?php 

include("includes/header.php");

$profile_id = $user['username'];
$imgSrc = "";
$result_path = "";
$msg = "";

// إزالة الصورة المؤقتة إذا كانت موجودة
if (!isset($_POST['x']) && !isset($_FILES['image']['name'])) {
    $temppath = 'assets/images/profile_pics/' . $profile_id . '_temp.jpeg';
    if (file_exists($temppath)) {
        @unlink($temppath);
    }
}

if (isset($_FILES['image']['name'])) {
    // الحصول على الاسم | الحجم | الموقع المؤقت		    
    $ImageName = $_FILES['image']['name'];
    $ImageSize = $_FILES['image']['size'];
    $ImageTempName = $_FILES['image']['tmp_name'];

    // الحصول على نوع الملف   
    $type = mime_content_type($ImageTempName);
    $allowed_types = ['image/jpeg', 'image/png', 'image/gif'];

    if (!in_array($type, $allowed_types)) {
        die("الملف غير مدعوم. الرجاء رفع صورة بصيغة JPG أو PNG أو GIF.");
    }

    // تحديد المجلد والمسار
    $uploaddir = realpath($_SERVER['DOCUMENT_ROOT']) . DIRECTORY_SEPARATOR . 'demo' . DIRECTORY_SEPARATOR . 'assets' . DIRECTORY_SEPARATOR . 'images' . DIRECTORY_SEPARATOR . 'profile_pics';

    // إنشاء المجلد إذا لم يكن موجودًا
    if (!is_dir($uploaddir)) {
        mkdir($uploaddir, 0777, true);
    }

    // تحديد أسماء الملفات والمسارات
    $file_temp_name = $profile_id . '_original_' . md5(time()) . '.' . pathinfo($ImageName, PATHINFO_EXTENSION);
    $fullpath = $uploaddir . DIRECTORY_SEPARATOR . $file_temp_name;

    $file_name = $profile_id . '_temp.jpeg';
    $fullpath_2 = $uploaddir . DIRECTORY_SEPARATOR . $file_name;

    // نقل الملف إلى المسار المحدد
    if (move_uploaded_file($ImageTempName, $fullpath)) {
        chmod($fullpath, 0777);
        $imgSrc = "assets/images/profile_pics/" . $file_name;
        $msg = "تم الرفع بنجاح!";
        $src = $file_name;
    } else {
        die("لم يتم رفع الملف: تحقق من صلاحيات المجلد أو المسار المستهدف.");
    }

    // تعديل حجم الصورة
    clearstatcache();
    $original_size = getimagesize($fullpath);
    $original_width = $original_size[0];
    $original_height = $original_size[1];

    $main_width = 500; // تعيين عرض الصورة
    $main_height = round($original_height / ($original_width / $main_width)); // تقريب القيمة
    
    if ($type == 'image/jpeg') {
        $src2 = imagecreatefromjpeg($fullpath);
    } elseif ($type == 'image/png') {
        $src2 = imagecreatefrompng($fullpath);
    } elseif ($type == 'image/gif') {
        $src2 = imagecreatefromgif($fullpath);
    } else {
        die("حدث خطأ أثناء معالجة الصورة.");
    }

    $main = imagecreatetruecolor($main_width, $main_height);
    imagecopyresampled($main, $src2, 0, 0, 0, 0, $main_width, $main_height, $original_width, $original_height);

    $main_temp = $fullpath_2;
    imagejpeg($main, $main_temp, 90);
    chmod($main_temp, 0777);

    imagedestroy($src2);
    imagedestroy($main);

    @unlink($fullpath);
}
if (isset($_POST['x'])) {
  // نوع الملف
  $type = $_POST['type'];
  $src = 'assets/images/profile_pics/' . $_POST['src'];

  // التحقق من وجود الملف
  if (!file_exists($src)) {
      die("الملف غير موجود: $src");
  }

  // أبعاد الصورة المستهدفة
  $targ_w = $targ_h = 150;
  $jpeg_quality = 90;

  // إنشاء نسخة مصغرة من الصورة بناءً على النوع
  if ($type == 'jpeg' || $type == 'jpg') {
      $img_r = @imagecreatefromjpeg($src);
  } elseif ($type == 'png') {
      $img_r = @imagecreatefrompng($src);
  } elseif ($type == 'gif') {
      $img_r = @imagecreatefromgif($src);
  } else {
      die("نوع الملف غير مدعوم.");
  }

  // التحقق من نجاح تحميل الصورة
  if (!$img_r) {
      die("فشل في تحميل الصورة. تأكد أن الملف صالح وأن الصيغة صحيحة.");
  }

  // إنشاء الصورة المصغرة
  $dst_r = imagecreatetruecolor($targ_w, $targ_h);
  imagecopyresampled(
      $dst_r,
      $img_r,
      0,
      0,
      $_POST['x'],
      $_POST['y'],
      $targ_w,
      $targ_h,
      $_POST['w'],
      $_POST['h']
  );

  // حفظ الصورة المصغرة
  $finalname = $profile_id . md5(time());
  $result_path = "assets/images/profile_pics/" . $finalname . "n.jpeg";
  imagejpeg($dst_r, $result_path, $jpeg_quality);

  // تحرير الموارد
  imagedestroy($img_r);
  imagedestroy($dst_r);
  @unlink($src);

  // تحديث قاعدة البيانات
  $insert_pic_query = mysqli_query($con, "UPDATE users SET profile_pic='$result_path' WHERE username='$userLoggedIn'");

  // إعادة التوجيه
  header("Location: " . $userLoggedIn);
}


?>
<div id="Overlay" style="width:100%; height:100%; border:0px #990000 solid; position:absolute; top:0px; left:0px; z-index:2000; display:none;"></div>
<div class="main_column column">
    <div id="formExample">
        <p><b> <?= $msg ?> </b></p>
        <form action="upload.php" method="post" enctype="multipart/form-data">
            قم برفع شيء ما<br><br>
            <input type="file" id="image" name="image" style="width:200px; height:30px;"><br><br>
            <input type="submit" value="إرسال" style="width:85px; height:25px;">
        </form><br><br>
    </div>
    <?php if ($imgSrc) { ?>
        <script>
            $('#Overlay').show();
            $('#formExample').hide();
        </script>
        <div id="CroppingContainer" style="width:800px; max-height:600px; background-color:#FFF; position:relative; overflow:hidden; border:2px #666 solid; z-index:2001; padding-bottom:0px;">
            <div id="CroppingArea" style="width:500px; max-height:400px; position:relative; overflow:hidden; margin:40px 0px 40px 40px; border:2px #666 solid; float:left;">
                <img src="<?= $imgSrc ?>" id="jcrop_target" />
            </div>
            <form action="upload.php" method="post" onsubmit="return checkCoords();">
                <input type="hidden" id="x" name="x">
                <input type="hidden" id="y" name="y">
                <input type="hidden" id="w" name="w">
                <input type="hidden" id="h" name="h">
                <input type="hidden" value="jpeg" name="type">
                <input type="hidden" value="<?= $src ?>" name="src">
                <input type="submit" value="حفظ" style="width:100px; height:30px;">
            </form>
        </div>
    <?php } ?>
</div>
