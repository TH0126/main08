<?php


include('functions.php');
$pdo = connect_to_db();

$sql = "SELECT * FROM terms_table WHERE del_f = '0'";

$stmt = $pdo->prepare($sql);

try {
    $status = $stmt->execute();
} catch (PDOException $e) {
    echo json_encode(["sql error" => "{$e->getMessage()}"]);
    exit();
}

$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
$output = "";
$cnt = 1;
foreach ($result as $record) {

    $cnt = $record["id"];

    $output .= "
    <tr class='retu'>
        <td>
            <div class='form-check'>
                <input class='form-check-input position-static' type='checkbox' value='" . $cnt . "'>
            </div>
        </td>
        <td>{$record["id"]}</td>
        <td>{$record["currency"]}</td>
        <td>{$record["chart_time"]}</td>
        <td>{$record["b_from_ymd"]}</td>
        <td>{$record["rikaku"]}</td>
        <td>{$record["songiri"]}</td>
        <td>{$record["trend"]}</td>
        <td>{$record["trend_ma1"]}</td>
        <td>{$record["nehaba"]}</td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
    </tr>
  ";
}

?>

<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>結果履歴</title>
    <!-- <script type="text/javascript" src="https://code.jquery.com/jquery-1.8.0.min.js"></script> -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script type="text/javascript" src="https://code.jquery.com/ui/1.10.3/jquery-ui.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
    <link rel="stylesheet" href="./css/style4.css">
</head>

<body>
    <div class="container-fluid">
        <ul class="nav nav-tabs nav-pills">
            <li class="nav-item">
                <a href="index.php" class="nav-link">条件入力</a>
            </li>
            <li class="nav-item">
                <a href="index2.php" class="nav-link">分析結果（データ）</a>
            </li>
            <li class="nav-item">
                <a href="index3.php" class="nav-link">分析結果（チャート）</a>
            </li>
            <li class="nav-item">
                <a href="#" class="nav-link active">結果履歴</a>
            </li>
        </ul>
        <form action="data_delete.php" method="POST" name="set">
            <div class="dark">
                <div class="row offset-1">
                    <p class="w_col">結果履歴一覧</p>
                    <input type="hidden" id="delete" name="delete" value="">
                    <button type="submit" class="btn btn-info offset-md-9">削除</button>
                </div>
                <table class="col-10 offset-1 table table-bordered">
                    <thead class="header">
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">No.</th>
                            <th scope="col">通貨ペア</th>
                            <th scope="col">時間足</th>
                            <th scope="col">分析期間</th>
                            <th scope="col">利確(pips)</th>
                            <th scope="col">損切(pips)</th>
                            <th scope="col">トレンド</th>
                            <th scope="col">トレンド判断基準</th>
                            <th scope="col">トレンドの強さ</th>
                            <th scope="col">注文するタイミング</th>
                            <th scope="col">BUY/SELL</th>
                            <th scope="col">勝率</th>
                            <th scope="col">取引回数</th>
                            <th scope="col">損益(pips)</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?= $output ?>
                    </tbody>
                </table>
            </div>
        </form>
    </div>

    <script>
        $(document).ready(function() {});

        //HTMLの読み込みが終わった後、処理開始
        $(window).on('load', function() {

            $(".btn-info").on("click", function() {
                let arr = [];
                $('[class="form-check-input position-static"]:checked').each(function() {
                    // チェックされているの値を配列に格納
                    arr.push($(this).val());
                });
                $("#delete").val(arr);
            });

        });
    </script>
</body>

</html>