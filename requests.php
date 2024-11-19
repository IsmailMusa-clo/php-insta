<?php
include("includes/header.php"); // لتضمين ملف الرأس
?>

<!-- صفحة طلبات الصداقة -->

<div class="main_column column" id="main_column">

	<h2> طلبات الصداقة </h2>

	<hr></hr>

	<?php  

	$query = mysqli_query($con, "SELECT * FROM friend_requests WHERE user_to='$userLoggedIn'"); // استعلام للحصول على طلبات الصداقة المرسلة إلى المستخدم الحالي

	if(mysqli_num_rows($query) == 0) // إذا لم تكن هناك أي طلبات صداقة
		echo "ليس لديك أي طلبات صداقة حاليًا!";
	else {

		while($row = mysqli_fetch_array($query)) {

			$user_from = $row['user_from']; // الطلب مرسل من

			$user_from_obj = new User($con, $user_from);

			echo $user_from_obj->getFirstAndLastName() . " أرسل لك طلب صداقة!";

			$user_from_friend_array = $user_from_obj->getFriendArray();

			// عند الضغط على زر قبول الطلب
			if(isset($_POST['accept_request' . $user_from ])) {

				$add_friend_query = mysqli_query($con, "UPDATE users SET friend_array=CONCAT(friend_array, '$user_from,') WHERE username='$userLoggedIn'"); // استعلام لإضافة المستخدم المرسل إلى قائمة الأصدقاء

				$add_friend_query = mysqli_query($con, "UPDATE users SET friend_array=CONCAT(friend_array, '$userLoggedIn,') WHERE username='$user_from'"); // استعلام لإضافة المستخدم الحالي إلى قائمة الأصدقاء

				$delete_query = mysqli_query($con, "DELETE FROM friend_requests WHERE user_to='$userLoggedIn' AND user_from='$user_from'"); // حذف الطلب من قاعدة البيانات

				echo "لقد أصبحتم أصدقاء الآن!";

				header("Location: requests.php");
			}

			// عند الضغط على زر تجاهل الطلب
			if(isset($_POST['ignore_request' . $user_from ])) {

				$delete_query = mysqli_query($con, "DELETE FROM friend_requests WHERE user_to='$userLoggedIn' AND user_from='$user_from'"); // حذف الطلب من قاعدة البيانات

				echo "تم تجاهل الطلب!";

				header("Location: requests.php");
			}

			?>

			<!-- نموذج للتعامل مع طلبات الصداقة -->

			<form action="requests.php" method="POST">

				<input type="submit" name="accept_request<?php echo $user_from; ?>" id="accept_button" value="قبول">

				<input type="submit" name="ignore_request<?php echo $user_from; ?>" id="ignore_button" value="تجاهل">
				<hr></hr>

			</form>

			<?php
		}
	}
	?>

</div>
