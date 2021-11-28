<?php

$connect = new PDO('mysql:host=localhost;dbname=DATABASE_NAME_HERE', 'DATABASE_USERNAME_HERE', 'DATABASE_USER_PASSWORD_HERE');

$query = "
SELECT * FROM //TABLE_NAME_HERE
WHERE parent_comment_id = '0'
ORDER BY comment_id DESC
";

$statement = $connect->prepare($query);

$statement->execute();

$result = $statement->fetchAll();
$output = '';
foreach($result as $row)
{
	$output .= '
 <div class="panel panel-default">
  <div class="panel-heading">By <b>'.$row["comment_sender_name"].'</b> on <i>'.$row["date"].'</i></div>
  <div class="panel-body" style="padding: 15px;">'.$row["comment"].'</div>
  <div class="panel-footer" align="right"><button type="button" class="btn btn-default reply" id="'.$row["comment_id"].'">Reply</button></div>
 </div>
 ';
	$output .= get_reply_comment($connect, $row["comment_id"]);
}

echo $output;

function get_reply_comment($connect, $parent_id = 0, $marginleft = 0)
{
	$query = "
 SELECT * FROM //TABLE_NAME_HERE WHERE parent_comment_id = '".$parent_id."'
 ";
	$output = '';
	$statement = $connect->prepare($query);
	$statement->execute();
	$result = $statement->fetchAll();
	$count = $statement->rowCount();
	if($parent_id == 0)
	{
		$marginleft = 0;
	}
	else
	{
		$marginleft = $marginleft + 48;
	}
	if($count > 0)
	{
		foreach($result as $row)
		{
			$output .= '
   <div class="panel panel-default" style="margin-left:'.$marginleft.'px">
    <div class="panel-heading">By <b>'.$row["comment_sender_name"].'</b> on <i>'.$row["date"].'</i></div>
    <div class="panel-body" style="padding: 15px;">'.$row["comment"].'</div>
    <div class="panel-footer" align="right"><button type="button" class="btn btn-default reply" id="'.$row["comment_id"].'">Reply</button></div>
   </div>
   ';
			$output .= get_reply_comment($connect, $row["comment_id"], $marginleft);
		}
	}
	return $output;
}

?>
