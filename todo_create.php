<?php
// POSTデータ確認
//var_dump($_POST);
//exit();

// DB接続
if(
    !isset($_POST["todo"]) || $_POST["todo"] == "" ||
    !isset($_POST["deadline"]) || $_POST["deadline"] == ""
){
exit("データが足りません");
}

//データの受取
$todo = $_POST["todo"];
$deadline = $_POST["deadline"];

// DB接続 ※基本変えない。
// 各種項目設定 ※基本変えない。dbnameを変えるだけ
$dbn ='mysql:dbname=gsacy_f11_09;charset=utf8mb4;port=3306;host=localhost';
$user = 'root';
$pwd = '';


try {
  $pdo = new PDO($dbn, $user, $pwd);
} catch (PDOException $e) {
  echo json_encode(["db error" => "{$e->getMessage()}"]);
  exit();
}
// （「dbError:...」が表示されたらdb接続でエラーが発生していることがわかる）


// ★SQL作成&実行★ ※基本変えない。$sql以下記載のコードはphpmyadminで実行できるのを確認してからそれをコピペ
$sql = "INSERT INTO todo_table (id, todo, deadline, created_at, updated_at) VALUES (NULL, :todo, :deadline, now(), now())";

$stmt = $pdo->prepare($sql);

// バインド変数を設定 ※基本変えない。バインド変数が多ければココで追加
$stmt->bindValue(':todo', $todo, PDO::PARAM_STR);
$stmt->bindValue(':deadline', $deadline, PDO::PARAM_STR);

// SQL実行（実行に失敗すると `sql error ...` が出力される）※基本変えない。
try {
  $status = $stmt->execute();
} catch (PDOException $e) {
  echo json_encode(["sql error" => "{$e->getMessage()}"]);
  exit();
}


// ★SQL実行の処理★
header('Location:todo_input.php');
exit();

