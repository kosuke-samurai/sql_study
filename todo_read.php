<?php

// DB接続
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


// SQL作成&実行
//$sql = "SELECT todo, deadline FROM todo_table ORDER BY deadline DESC";
$sql = "SELECT todo, deadline FROM todo_table WHERE deadline >= '2022-05-01' AND deadline <= '2022-06-30' ORDER BY deadline ASC LIMIT 5";

$stmt = $pdo->prepare($sql);


// SQL実行（実行に失敗すると `sql error ...` が出力される）※基本変えない。
try {
  $status = $stmt->execute();
  //fetchAll() 関数でデータ自体を取得する．
  $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

//できているか確認する際、テーブルを見やすくするコツ
//echo '<pre>';
//var_dump($result);
//echo '</pre>';
//exit(); 

$output = "";
foreach($result as $record){
 $output .="<tr><td>{$record["deadline"]}</td><td>{$record["todo"]}</td><tr>";

}
} catch (PDOException $e) {
  echo json_encode(["sql error" => "{$e->getMessage()}"]);
  exit();
}


?>

<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>DB連携型todoリスト（一覧画面）</title>
</head>

<body>
  <fieldset>
    <legend>DB連携型todoリスト（一覧画面）</legend>
    <a href="todo_input.php">入力画面</a>
    <table>
      <thead>
        <tr>
          <th>deadline</th>
          <th>todo</th>
        </tr>
      </thead>
      <tbody>
        <!-- ここに<tr><td>deadline</td><td>todo</td><tr>の形でデータが入る -->
          <?= $output ?>
      </tbody>
    </table>
  </fieldset>
</body>

<script>
const resultArray = <?=json_encode($result) ?>;
console.log(resultArray);


</script>

</html>