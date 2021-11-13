<?php

// Fill in these variables to match your database credentials
$db_name = '';
$db_user = '';
$db_user_pass = '';

$connect = new PDO('mysql:host=localhost;dbname=$db_name', '$db_user', '$db_user_pass');

$error = '';
$comment_name = '';
$comment_content = '';

if(empty($_POST["comment_name"]))
{
	$error .= '<p class="text-danger">Your Name is required</p>';
}
else
{
	$comment_name = test_input($_POST["comment_name"]);
	if (!preg_match("/^[a-zA-Z-' ]*$/",$comment_name)) {
		$error .= '<p class="text-danger">Name can only contain letters and white space</p>';
	}
}

if(empty($_POST["comment_content"]))
{
	$error .= '<p class="text-danger">Cant post an empty comment</p>';
}
else
{
	$comment_content = test_input($_POST["comment_content"]);
	if (!preg_match("/^[a-zA-Z-' ]*$/",$comment_content)) {
		$error .= '<p class="text-danger">Your comment can only contain letters and white space</p>';
	}
}

if($error == '')
{
	$query = "
 INSERT INTO tbl_comment
 (parent_comment_id, comment, comment_sender_name)
 VALUES (:parent_comment_id, :comment, :comment_sender_name)
 ";
	$statement = $connect->prepare($query);
	$statement->execute(
		array(
			':parent_comment_id' => $_POST["comment_id"],
			':comment'    => $comment_content,
			':comment_sender_name' => $comment_name
		)
	);
	$error = '<label class="text-success">Comment Posted</label>';
}

$data = array(
	'error'  => $error
);

echo json_encode($data);

function test_input($data) {
	$data = trim($data);
	$data = stripslashes($data);
	$data = htmlspecialchars($data);
	return $data;
}
?>
