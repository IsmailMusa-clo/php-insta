<?php

include("includes/header.php");

if(isset($_GET['q'])) {
	$query = $_GET['q'];
}
else {
	$query = "";
}

if(isset($_GET['type'])) {
	$type = $_GET['type'];
}
else {
	$type = "name";
}
?>

<div class="main_column column" id="main_column">

	<?php 
	if($query == "")
		echo "يجب عليك إدخال نص في صندوق البحث.";
	else {

		// إذا كان الاستعلام يحتوي على "_" اعتبر أن البحث يتم عن اسم المستخدم
		if($type == "username") 
			$usersReturnedQuery = mysqli_query($con, "SELECT * FROM users WHERE username LIKE '$query%' AND user_closed='no' LIMIT 8");
		// إذا كان هناك كلمتان في الاستعلام، اعتبرهما الاسم الأول واسم العائلة
		else {

			$names = explode(" ", $query);

			if(count($names) == 3)
				$usersReturnedQuery = mysqli_query($con, "SELECT * FROM users WHERE (first_name LIKE '$names[0]%' AND last_name LIKE '$names[2]%') AND user_closed='no'");
			// إذا كان هناك كلمة واحدة فقط، ابحث في الأسماء الأولى أو أسماء العائلة
			else if(count($names) == 2)
				$usersReturnedQuery = mysqli_query($con, "SELECT * FROM users WHERE (first_name LIKE '$names[0]%' AND last_name LIKE '$names[1]%') AND user_closed='no'");
			else 
				$usersReturnedQuery = mysqli_query($con, "SELECT * FROM users WHERE (first_name LIKE '$names[0]%' OR last_name LIKE '$names[0]%') AND user_closed='no'");
		}

		// تحقق إذا تم العثور على نتائج
		if(mysqli_num_rows($usersReturnedQuery) == 0)
			echo "لم يتم العثور على أي شخص بـ " . $type . " يشبه: " .$query;
		else 
			echo mysqli_num_rows($usersReturnedQuery) . " نتائج تم العثور عليها: <br> <br>";

		echo "<p id='grey'>جرّب البحث عن:</p>";
		echo "<a href='search.php?q=" . $query ."&type=name'>الأسماء</a>, <a href='search.php?q=" . $query ."&type=username'>أسماء المستخدمين</a><br><br><hr id='search_hr'>";

		while($row = mysqli_fetch_array($usersReturnedQuery)) {
			$user_obj = new User($con, $user['username']);

			$button = "";
			$mutual_friends = "";

			if($user['username'] != $row['username']) {

				// توليد الأزرار بناءً على حالة الصداقة
				if($user_obj->isFriend($row['username']))
					$button = "<input type='submit' name='" . $row['username'] . "' class='danger' value='إزالة الصديق'>";
				else if($user_obj->didReceiveRequest($row['username']))
					$button = "<input type='submit' name='" . $row['username'] . "' class='warning' value='الرد على الطلب'>";
				else if($user_obj->didSendRequest($row['username']))
					$button = "<input type='submit' class='default' value='تم إرسال الطلب'>";
				else 
					$button = "<input type='submit' name='" . $row['username'] . "' class='success' value='إضافة صديق'>";

				$mutual_friends = $user_obj->getMutualFriends($row['username']) . " أصدقاء مشتركين";


				// نماذج الأزرار
				if(isset($_POST[$row['username']])) {

					if($user_obj->isFriend($row['username'])) {
						$user_obj->removeFriend($row['username']);
						header("Location: http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]");
					}
					else if($user_obj->didReceiveRequest($row['username'])) {
						header("Location: requests.php");
					}
					else if($user_obj->didSendRequest($row['username'])) {

					}
					else {
						$user_obj->sendRequest($row['username']);
						header("Location: http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]");
					}

				}

			}

			echo "<div class='search_result'>
					<div class='searchPageFriendButtons'>
						<form action='' method='POST'>
							" . $button . "
							<br>
						</form>
					</div>


					<div class='result_profile_pic'>
						<a href='" . $row['username'] ."'><img src='". $row['profile_pic'] ."' style='height: 100px;'></a>
					</div>

						<a href='" . $row['username'] ."'> " . $row['first_name'] . " " . $row['last_name'] . "
						<p id='grey'> " . $row['username'] ."</p>
						</a>
						<br>
						" . $mutual_friends ."<br>

				</div>
				<hr id='search_hr'>";

		} // نهاية حلقة while
	}

	?>

</div>
