<!DOCTYPE HTML>

<html lang = "en">
  <head>
    <title>formDemo.html</title>
    <meta charset = "UTF-8">
    <script>
	function displayResult()
	{
	var table=document.getElementById("myTable");
	var row=table.insertRow(-1);
	var cell1=row.insertCell(0);
	var cell2=row.insertCell(1);
	var cell3=row.insertCell(2);
	var cell4=row.insertCell(3);
	var cell5=row.insertCell(4);
	}</script>
  </head>
  <body>
<?php
	session_start();
	if(!isset($_SESSION['user_id']))
	{
		require('login_tools.php');
		load();
		echo "<p>";
		echo "You are now logged in, {$_SESSION['username']}";
		echo"</p>";
	}
?>

<?php
	require ('/helperFunctions.php');
	render_logo();
	#render_login();
	#render_semester();
?>


<h2>Selections</h2>

<?php
	render_selections('user_id');
	render_buttons();
?>



  </body>
</html>
