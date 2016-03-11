<?php 
    define('PDO_DSN', 'mysql:dbname=myfriends;host=localhost');
    define('DB_USERNAME', 'root');
    define('DB_PASSWORD', '');

    $dbh = new PDO(PDO_DSN,DB_USERNAME,DB_PASSWORD);
    $dbh->query('SET NAMES utf8');

    //POST 送信された情報を取得
    // POST送信されたら、友達データを追加
    if (isset($_POST) && !empty($_POST)){
      var_dump($_POST['name']);
      //INSERT文作成
      $sql = sprintf("INSERT INTO `myfriends`.`friends` (`friend_id`, `friend_name`, `area_id`, `gender`, `age`, `created`) VALUES (NULL, '%s', '%s', '%s', '%s', now());",$_POST['name'],$_POST['area_id'],$_POST['gender'],$_POST['age']);

      //SQL実行
      $stmt = $dbh->prepare($sql);
      $stmt->execute();

    }
    

?>


<!DOCTYPE html>
<html lang="ja">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>myFriends</title>

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>
  <body>
        <legend>友達の登録</legend>
        <form method="post" action="" class="form-horizontal" role="form">
            <!-- 名前 -->
            <div>
              <label class="col-sm-2 control-label">名前</label>
              <div>
                <input type="text" name="name" class="form-control" placeholder="例：山田　太郎">
              </div>
            </div>
            <!-- 出身 -->
            <div>
              <label class="col-sm-2 control-label">出身</label>
              <div>
                <select class="form-control" name="area_id">
                  <option value="0">出身地を選択</option>
                  <option value="1">北海道</option>
                  <option value="2">青森</option>
                  <option value="3">岩手</option>
                  <option value="4">宮城</option>
                  <option value="5">秋田</option>
                </select>
              </div>
            </div>
            <!-- 性別 -->
            <div>
              <label class="col-sm-2 control-label">性別</label>
              <div>
                <select class="form-control" name="gender">
                  <option value="0">性別を選択</option>
                  <option value="1">男性</option>
                  <option value="2">女性</option>
                </select>
              </div>
            </div>
            <!-- 年齢 -->
            <div>
              <label class="col-sm-2 control-label">年齢</label>
              <div>
                <input type="text" name="age" class="form-control" placeholder="例：27">
              </div>
            </div>

          <input type="submit" class="btn btn-default" value="登録">
        </form>
  </body>
</html>
