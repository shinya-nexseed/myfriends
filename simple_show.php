<?php 
    // echo $_GET['area_id'];
    define('PDO_DSN', 'mysql:dbname=myfriends;host=localhost');
    define('DB_USERNAME', 'root');
    define('DB_PASSWORD', '');

    $dbh = new PDO(PDO_DSN,DB_USERNAME,DB_PASSWORD);
    $dbh->query('SET NAMES utf8');

    $sql = sprintf('SELECT * FROM areas WHERE area_id=%s', $_GET['area_id']);
    // var_dump($_GET['area_id']); ← var_dumpで型の判定ができる
    
    $stmt = $dbh->prepare($sql);
    $stmt->execute();

    $rec = $stmt->fetch(PDO::FETCH_ASSOC);
    // var_dump($rec);
?>

<!DOCTYPE html>
<html lang="ja">
  <head>
    <meta charset="utf-8">
    <title>myFriends</title>

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

  </head>
  <body>
    <div>
      <legend><?php echo $rec['area_name']; ?>の友達</legend>
      <div>男性：2名　女性：1名</div>
      <table>
        <thead>
          <tr>
            <th>名前</th>
            <th></th>
          </tr>
        </thead>
        <tbody>
          <!-- 友達の名前を表示 -->
          <tr>
            <td>山田　太郎</td>
            <td>
              <div>
                <a href="edit.html"><i>編集</i></a>&nbsp;&nbsp;&nbsp;&nbsp;
                <a href="javascript:void(0);" onclick="destroy();"><i>削除</i></a>
              </div>
            </td>
          </tr>
          <tr>
            <td>小林　花子</td>
            <td>
              <div>
                <a href="edit.html"><i>編集</i></a>&nbsp;&nbsp;&nbsp;&nbsp;
                <a href="javascript:void(0);" onclick="destroy();"><i>削除</i></a>
              </div>
            </td>
          </tr>
          <tr>
            <td>佐藤　健</td>
            <td>
              <div>
                <a href="edit.html"><i>編集</i></a>&nbsp;&nbsp;&nbsp;&nbsp;
                <a href="javascript:void(0);" onclick="destroy();"><i>削除</i></a>
              </div>
            </td>
          </tr>
        </tbody>
      </table>

      <input type="button" value="新規作成" onClick="location.href='new.html'">
    </div>
  </body>
</html>
