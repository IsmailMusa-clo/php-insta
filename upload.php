<?php 

include("includes/header.php");

$profile_id = $user['username'];
$imgSrc = "";
$result_path = "";
$msg = "";

/***********************************************************
	0 - إزالة الصورة المؤقتة إذا كانت موجودة
***********************************************************/
	if (!isset($_POST['x']) && !isset($_FILES['image']['name']) ){
		// حذف صورة المستخدم المؤقتة
			$temppath = 'assets/images/profile_pics/'.$profile_id.'_temp.jpeg';
			if (file_exists ($temppath)){ @unlink($temppath); }
	} 


if(isset($_FILES['image']['name'])){	
/***********************************************************
	1 - رفع الصورة الأصلية إلى الخادم
***********************************************************/	
	// الحصول على الاسم | الحجم | الموقع المؤقت		    
		$ImageName = $_FILES['image']['name'];
		$ImageSize = $_FILES['image']['size'];
		$ImageTempName = $_FILES['image']['tmp_name'];
	// الحصول على نوع الملف   
		$ImageType = @explode('/', $_FILES['image']['type']);
		$type = $ImageType[1]; // نوع الملف	
	// تحديد مجلد التحميل    
		$uploaddir = $_SERVER['DOCUMENT_ROOT'].'/demo/assets/images/profile_pics';
	// تحديد اسم الملف	
  $file_temp_name = $profile_id.'_original_'.md5(time()).'.'.$type;
  $fullpath = $uploaddir."/".$file_temp_name; // مسار الملف المؤقت
		$file_name = $profile_id.'_temp.jpeg'; //$profile_id.'_temp.'.$type; // للصورة النهائية المصغرة
		$fullpath_2 = $uploaddir."/".$file_name; // للصورة النهائية المصغرة
	// نقل الملف إلى المكان الصحيح
		$move = move_uploaded_file($ImageTempName ,$fullpath) ; 
		chmod($fullpath, 0777);  
		// التحقق من رفع الملف بنجاح
		if (!$move) { 
			die ('لم يتم رفع الملف');
		} else { 
			$imgSrc= "assets/images/profile_pics/".$file_name; // الصورة لعرضها في منطقة القص
			$msg= "تم الرفع بنجاح!";  	// الرسالة المعروضة في الصفحة
			$src = $file_name;	 		// اسم الملف لتمريره من نموذج القص للتعديل		
		} 

/***********************************************************
	2  - تعديل حجم الصورة لتناسب منطقة القص
***********************************************************/		
		// الحصول على حجم الصورة المرفوعة	
			clearstatcache();				
			$original_size = getimagesize($fullpath);
			$original_width = $original_size[0];
			$original_height = $original_size[1];	
		// تحديد الحجم الجديد
			$main_width = 500; // تعيين عرض الصورة
			$main_height = $original_height / ($original_width / $main_width);	// تعيين الارتفاع بالنسبة للحجم									
		// إنشاء صورة جديدة باستخدام الدالة الصحيحة في PHP			
			if($_FILES["image"]["type"] == "image/gif"){
				$src2 = imagecreatefromgif($fullpath);
			}elseif($_FILES["image"]["type"] == "image/jpeg" || $_FILES["image"]["type"] == "image/pjpeg"){
				$src2 = imagecreatefromjpeg($fullpath);
			}elseif($_FILES["image"]["type"] == "image/png"){ 
				$src2 = imagecreatefrompng($fullpath);
			}else{ 
				$msg .= "حدث خطأ أثناء رفع الملف. يرجى رفع ملف .jpg أو .gif أو .png. <br />";
			}
		// إنشاء الصورة الجديدة بالحجم المعدل
			$main = imagecreatetruecolor($main_width,$main_height);
			imagecopyresampled($main,$src2,0, 0, 0, 0,$main_width,$main_height,$original_width,$original_height);
		// رفع النسخة المعدلة
			$main_temp = $fullpath_2;
			imagejpeg($main, $main_temp, 90);
			chmod($main_temp,0777);
		// تحرير الذاكرة
			imagedestroy($src2);
			imagedestroy($main);
			//imagedestroy($fullpath);
			@ unlink($fullpath); // حذف الملف الأصلي					
									

}// إضافة صورة 	

/***********************************************************
	3- القص وتحويل الصورة إلى JPG
***********************************************************/
if (isset($_POST['x'])){
	
	// نوع الملف المرسل
		$type = $_POST['type'];	
	// مصدر الصورة
		$src = 'assets/images/profile_pics/'.$_POST['src'];	
		$finalname = $profile_id.md5(time());	
	
	if($type == 'jpg' || $type == 'jpeg' || $type == 'JPG' || $type == 'JPEG'){	
	
		// الأبعاد المستهدفة 150x150
			$targ_w = $targ_h = 150;
		// جودة الصورة الناتجة
			$jpeg_quality = 90;
		// إنشاء نسخة مصغرة من الصورة
			$img_r = imagecreatefromjpeg($src);
			$dst_r = imagecreatetruecolor( $targ_w, $targ_h );
			imagecopyresampled($dst_r,$img_r,0,0,$_POST['x'],$_POST['y'],
			$targ_w,$targ_h,$_POST['w'],$_POST['h']);
		// حفظ النسخة المصغرة
			imagejpeg($dst_r, "assets/images/profile_pics/".$finalname."n.jpeg", 90); 	
	
	}else if($type == 'png' || $type == 'PNG'){
		
		// الأبعاد المستهدفة 150x150
			$targ_w = $targ_h = 150;
		// جودة الصورة الناتجة
			$jpeg_quality = 90;
		// إنشاء نسخة مصغرة من الصورة
			$img_r = imagecreatefrompng($src);
			$dst_r = imagecreatetruecolor( $targ_w, $targ_h );		
			imagecopyresampled($dst_r,$img_r,0,0,$_POST['x'],$_POST['y'],
			$targ_w,$targ_h,$_POST['w'],$_POST['h']);
		// حفظ النسخة المصغرة
			imagejpeg($dst_r, "assets/images/profile_pics/".$finalname."n.jpeg", 90); 	
	
	}else if($type == 'gif' || $type == 'GIF'){
		
		// الأبعاد المستهدفة 150x150
			$targ_w = $targ_h = 150;
		// جودة الصورة الناتجة
			$jpeg_quality = 90;
		// إنشاء نسخة مصغرة من الصورة
			$img_r = imagecreatefromgif($src);
			$dst_r = imagecreatetruecolor( $targ_w, $targ_h );		
			imagecopyresampled($dst_r,$img_r,0,0,$_POST['x'],$_POST['y'],
			$targ_w,$targ_h,$_POST['w'],$_POST['h']);
		// حفظ النسخة المصغرة
			imagejpeg($dst_r, "assets/images/profile_pics/".$finalname."n.jpeg", 90); 	
		
	}
		// تحرير الذاكرة
			imagedestroy($img_r); // تحرير الذاكرة
			imagedestroy($dst_r); // تحرير الذاكرة
			@ unlink($src); // حذف الملف الأصلي					
		
		// إرجاع الصورة المقصوصة إلى الصفحة	
		$result_path ="assets/images/profile_pics/".$finalname."n.jpeg";

		// إدخال الصورة في قاعدة البيانات
		$insert_pic_query = mysqli_query($con, "UPDATE users SET profile_pic='$result_path' WHERE username='$userLoggedIn'");
		header("Location: ".$userLoggedIn);
														

}// post x
?>
<div id="Overlay" style=" width:100%; height:100%; border:0px #990000 solid; position:absolute; top:0px; left:0px; z-index:2000; display:none;"></div>
<div class="main_column column">


	<div id="formExample">
		
	    <p><b> <?=$msg?> </b></p>
	    
	    <form action="upload.php" method="post"  enctype="multipart/form-data">
	        قم برفع شيء ما<br /><br />
	        <input type="file" id="image" name="image" style="width:200px; height:30px; " /><br /><br />
	        <input type="submit" value="إرسال" style="width:85px; height:25px;" />
	    </form><br /><br />
	    
	</div> <!-- النموذج-->  



  <?php
    if($imgSrc){ // إذا تم رفع صورة، عرض منطقة القص
?>
    <script>
        $('#Overlay').show();
        $('#formExample').hide();
    </script>
    <div id="CroppingContainer" style="width:800px; max-height:600px; background-color:#FFF; margin-left: -200px; position:relative; overflow:hidden; border:2px #666 solid; z-index:2001; padding-bottom:0px;">  
    
        <div id="CroppingArea" style="width:500px; max-height:400px; position:relative; overflow:hidden; margin:40px 0px 40px 40px; border:2px #666 solid; float:left;">  
            <img src="<?=$imgSrc?>" border="0" id="jcrop_target" style="border:0px #990000 solid; position:relative; margin:0px 0px 0px 0px; padding:0px; " />
        </div>  

        <div id="InfoArea" style="width:180px; height:150px; position:relative; overflow:hidden; margin:40px 0px 0px 40px; border:0px #666 solid; float:left;">  
           <p style="margin:0px; padding:0px; color:#444; font-size:18px;">          
                <b>قص صورة الملف الشخصي</b><br /><br />
                <span style="font-size:14px;">
                    قم بقص / تغيير حجم صورة الملف الشخصي التي قمت برفعها. <br />
                    بمجرد أن تكون راضيًا عن صورة الملف الشخصي، اضغط على "حفظ".
                </span>
           </p>
        </div>  

        <br />

        <div id="CropImageForm" style="width:100px; height:30px; float:left; margin:10px 0px 0px 40px;" >  
            <form action="upload.php" method="post" onsubmit="return checkCoords();">
                <input type="hidden" id="x" name="x" />
                <input type="hidden" id="y" name="y" />
                <input type="hidden" id="w" name="w" />
                <input type="hidden" id="h" name="h" />
                <input type="hidden" value="jpeg" name="type" /> <?php // $type ?> 
                <input type="hidden" value="<?=$src?>" name="src" />
                <input type="submit" value="حفظ" style="width:100px; height:30px;"   />
            </form>
        </div>

        <div id="CropImageForm2" style="width:100px; height:30px; float:left; margin:10px 0px 0px 40px;" >  
            <form action="upload.php" method="post" onsubmit="return cancelCrop();">
                <input type="submit" value="إلغاء" style="width:100px; height:30px;"   />
            </form>
        </div>            
                
    </div><!-- CroppingContainer -->
<?php 
} ?>
</div>

 
 
 
 
 
 <?php if($result_path) {
	 ?>
     
     <img src="<?=$result_path?>" style="position:relative; margin:10px auto; width:150px; height:150px;" />
	 
 <?php } ?>
 
 
    <br /><br />
