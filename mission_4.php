<?php
//DB接続
$dsn='mysql:dbname=データベース名;host=localhost';
$user='ユーザー名';
$password='パスワード';
$pdo=new PDO($dsn,$user,$password,array(PDO::ATTR_ERRMODE=>PDO::ERRMODE_WARNING));

//テーブル作成
/*$sql="CREATE TABLE missiontable"
."("
."id INT PRIMARY KEY AUTO_INCREMENT,"
."name char(32),"
."comment TEXT,"
."date DATETIME,"
."password char(20)"
.");";
$stmt=$pdo->query($sql);*/


//テーブル作成確認
/*$sql='SHOW TABLES';
$result=$pdo->query($sql);
foreach($result as $row){
echo $row[0];
echo'<br>';
}
echo"<hr>";
?>*/

//テーブル中身確認
/*$sql='SHOW CREATE TABLE missiontable';
$result=$pdo->query($sql);
foreach($result as $row){
print_r($row);
}
echo"<hr>";*/

//定義
$name=$_POST['name'];
$comment=$_POST['comment'];

date_default_timezone_set('Asia/Tokyo');
$date=date('Y/m/d H:i:s');

$edit=$_POST["edit"];
$edipass=$_POST["edipass"];
$number=$_POST["number"];
$delete=$_POST["delete"];
$delpass=$_POST["delpass"];
$conpass=$_POST["conpass"];

//データ投稿
if(!empty($_POST["name"])&&!empty($_POST["comment"])&&empty($_POST["number"])&&!empty($_POST["conpass"])){
//データ入力
$sql=$pdo->prepare("INSERT INTO missiontable(name,comment,date,password)VALUES(:name,:comment,:date,:password)");
$sql->bindParam(':name',$name,PDO::PARAM_STR);
$sql->bindParam(':comment',$comment,PDO::PARAM_STR);
$sql->bindParam(':date',$date,PDO::PARAM_STR);
$sql->bindParam(':password',$conpass,PDO::PARAM_STR);	

$sql->execute();
}
//データ編集機能
if(!empty($_POST["edit"])&&!empty($_POST["edipass"])){
	$sql="SELECT*FROM missiontable";
	$results=$pdo->query($sql);
	$result=$results->fetchALL();
	foreach($result as $row){
if($row["id"]==$edit){
if($row["password"]==$edipass){
	$editnumber=$row["id"];
	$editname=$row["name"];
	$editcomment=$row["comment"];
	$editpassword=$row["password"];
}
else{
	echo"パスワードが間違っています";
}
}
}
}

//編集実行
if(!empty($_POST["number"])&&!empty($_POST["name"])&&!empty($_POST["comment"])){
	$sql="SELECT*FROM missiontable";
	$sql="update missiontable set name='$name',comment='$comment', date='$date', password='$conpass' where id=$number";
	$result=$pdo->query($sql);
}

//データ削除機能
if(!empty($_POST["delete"])&&!empty($_POST["delpass"])){
	$sql="SELECT*FROM missiontable";
	$results=$pdo->query($sql);
	$result=$results->fetchALL();
	foreach($result as $row){
if($row["id"]==$delete){
if($row["password"]==$delpass){
	$sql="delete from missiontable where id=$delete";
	$result=$pdo->query($sql);
}
else{
	echo"パスワードが間違っています";
}
}
}
}
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8"/>
</head>
<body>
<form action="mission_4.php" method="post">
<input type="text" placeholder="名前" name="name" value=<?php echo $editname;?>><br>
<input type="text"  placeholder="コメント" name="comment" value=<?php echo $editcomment;?>><br>
<input type="text" name="conpass" placeholder="パスワード" value=<?php echo $editpassword;?>>
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
//データ表示
$sql='SELECT * FROM missiontable order by id asc';
$results=$pdo->query($sql);
$result=$results->fetchALL();
foreach ($result as $row){
//$rowの中にはテーブルのカラム名が入る
echo $row['id'].',';
echo $row['name'].',';
echo $row['comment'].',';
echo $row['date'].'<br>';

} 

?>
</body>
</html>
