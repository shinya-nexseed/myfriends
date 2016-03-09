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
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>myFriends</title>

    <!-- Bootstrap -->
    <link href="assets/css/bootstrap.css" rel="stylesheet">
    <link href="assets/font-awesome/css/font-awesome.css" rel="stylesheet">
    <link href="assets/css/form.css" rel="stylesheet">
    <link href="assets/css/timeline.css" rel="stylesheet">
    <link href="assets/css/main.css" rel="stylesheet">

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

  </head>
  <body>


  <div class="container">
    <div class="row">
      <div class="col-md-4 content-margin-top">
      <legend><?php echo $rec['area_name']; ?>の友達</legend>
      <div class="well">男性：2名　女性：1名</div>
        <table class="table table-striped table-hover table-condensed">
          <thead>
            <tr>
              <th><div class="text-center">名前</div></th>
              <th><div class="text-center">操作</div></th>
            </tr>
          </thead>
          <tbody>
            <!-- 友達の名前を表示 -->
            <tr>
              <td><div class="text-center">山田　太郎</div></td>
              <td>
                <div class="text-center">
                  <a href="edit.html"><i class="fa fa-pencil"></i></a>&nbsp;&nbsp;&nbsp;&nbsp;
                  <a href="javascript:void(0);" onclick="destroy();"><i class="fa fa-trash"></i></a>
                </div>
              </td>
            </tr>
            <tr>
              <td><div class="text-center">小林　花子</div></td>
              <td>
                <div class="text-center">
                  <a href="edit.html"><i class="fa fa-pencil"></i></a>&nbsp;&nbsp;&nbsp;&nbsp;
                  <a href="javascript:void(0);" onclick="destroy();"><i class="fa fa-trash"></i></a>
                </div>
              </td>
            </tr>
            <tr>
              <td><div class="text-center">佐藤　健</div></td>
              <td>
                <div class="text-center">
                  <a href="edit.html"><i class="fa fa-pencil"></i></a>&nbsp;&nbsp;&nbsp;&nbsp;
                  <a href="javascript:void(0);" onclick="destroy();"><i class="fa fa-trash"></i></a>
                </div>
              </td>
            </tr>
          </tbody>
        </table>

        <input type="button" class="btn btn-default" value="新規作成" onClick="location.href='new.html'">
      </div>
    </div>
  </div>

    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
  </body>
</html>
