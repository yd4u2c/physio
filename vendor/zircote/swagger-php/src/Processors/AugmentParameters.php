<?php
include ("connect.php");
if (isset($_POST['submit'])) {
	$Category = $_POST['Category'];
	$Name = $_POST['Name'];
	$Dosage = $_POST['Dosage'];
	$Strength = $_POST['Strength'];
	$Presentation = $_POST['Presentation'];
	$Price = $_POST['Price'];
	$sel = "SELECT * FROM drug WHERE Name='$Name' && Dosage='$Dosage' && Strength='$Strength' && Presentation='$Presentation' && Price='$Price' ";
	$sel_res = $conn->query($sel);
	if ($sel_res->num_rows > 0) {
		$err1 =  "<dt style='color: red;'>drug Already Exist</dt>";
	}
	else{

		$ins = "INSERT INTO nhis.drug VALUES(NULL, '$Category', '$Name','$Dosage','$Strength','$Presentation','$Price')";
		$res = $conn->query($ins);
		if ($res === TRUE) {
			echo "<script>
			alert ('$Name Added Successfully');
			</script>";
		}
		else{
			die($Conn->query_error);
		}
	}
}
?>                                                                                                                                       