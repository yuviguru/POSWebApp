<?php 
	$page_access='';
	if(isset($_SESSION['USER_MENU_ACCESS'])){
		$user_menus = explode(',',$_SESSION['USER_MENU_ACCESS']);
		$current_file = basename($_SERVER['PHP_SELF'],".php");
		$sql_access_check = $conn->query("SELECT * FROM file_master  where FILE_NAME='$current_file'");
		$sql_access = $sql_access_check->fetch_assoc()['MENU_ID'];
		foreach ($user_menus as $user_menu) {	
			if($sql_access == $user_menu){
				$page_access = 'YES';
				}
			}
	}
	if($page_access != 'YES') {
		echo"<script>alert('Access Denied');window.top.location.href='index.php'</script>";
	}
?>