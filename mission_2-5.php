<?php
$name=$_POST["name"];
$comment=$_POST["comment"];

$date=date("Y年m月d日　H時i分");

$filename='mission_2-5.txt';


//以下編集機能
if(!empty($_POST["edit"])&&!empty($_POST["edipass"]))
{
	$edit=$_POST["edit"];
	$edipass=$_POST["edipass"];
	$ediCon=file($filename);

foreach($ediCon as $value)
{
	$contents=explode("<>",$value);

//各投稿番号とPOST送信された編集番号がイコールのときの配列の値
if($contents[0]==$edit&&$contents[4]==$edipass)
{
	$editnumber=$contents[0];
	$editname=$contents[1];
	$editcomment=$contents[2];
}
}
}

//編集
if(!empty($_POST["number"])&&!empty($_POST["name"])&&!empty($_POST["comment"]))
{
	$number=$_POST["number"];
	$numCon=file($filename);
	$fp=fopen($filename,"w");

foreach($numCon as $value)
{
	$contents=explode("<>",$value);

if($number==$contents[0])
{
	fwrite($fp,$number."<>".$name."<>".$comment."<>".$date."\n");
}
else
{
	fwrite($fp,$value);
}
}
	
	fclose($fp);
}
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8"/>
</head>
<body>
<form action="mission_2-5.php" method="post">
<input type="text" placeholder="名前" name="name" value=<?php echo $editname;?>><br>
<input type="text"  placeholder="コメント" name="comment"value=<?php echo $editcomment;?>><br>
<input type="text" name="conpass" placeholder="パスワード">
<input type="submit" value="送信"><br><br>

<input type="hidden" value=<?php echo $editnumber;?> name="number"><br>

<input type="text" placeholder="削除対象番号" name="delete"><br>
<input type="text" placeholder="パスワード" name="delpass">
<input type="submit" value="削除"><br><br>


<input type="text" placeholder="編集対象番号" name="edit"><br>
<input type="text" placeholder="パスワード" name="edipass">
<input type="submit" value="編集"><br>
</form>


<?php
//以下削除機能
if(!empty($_POST["delete"])&&!empty($_POST["delpass"]))
{
	$delete=$_POST["delete"];
	$delpass=$_POST["delpass"];
	$delCon=file($filename);
	$fp=fopen($filename,"w");

foreach($delCon as $value)
{
	$contents=explode("<>",$value);

	
if($contents[0]!=$delete&&$contents[4]!=$delpass)
//両方一致すれば削除
{
	fwrite($fp,$value);

}
}
	
	fclose($fp);
}
//以下投稿機能
if(!empty($_POST["name"])&&!empty($_POST["comment"])&&empty($_POST["number"])&&!empty($_POST["conpass"]))
{	
	$fp=fopen($filename,"a");
	$file=file($filename);
	$count=count($file);
	$id=$count+1;
	$conpass=$_POST["conpass"];
	fwrite($fp,$id."<>".$name."<>".$comment."<>".$date."<>".$conpass."<>"."\n");

	fclose($fp);
}

//ファイル出力
if(file_exists($filename))
{
	$file=file($filename);
foreach((array)$file as $value)
{
	$contents=explode("<>",$value);
	echo $contents[0]." ".$contents[1]." ".$contents[2]." ".$contents[3];
	echo "<br>";
}
}
?>
</body>
</html>