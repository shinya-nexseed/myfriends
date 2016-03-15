<?php 
    // echo $_GET['area_id'];
    define('PDO_DSN', 'mysql:dbname=myfriends;host=localhost');
    define('DB_USERNAME', 'root');
    define('DB_PASSWORD', '');

    $dbh = new PDO(PDO_DSN,DB_USERNAME,DB_PASSWORD);
    $dbh->query('SET NAMES utf8');

    // ページ読み込み時にURLのパラメータ上でactionがあれば処理をする
    if (isset($_GET['action']) && !empty($_GET['action'])) {

        // actionパラメータの値はdeleteであれば削除処理実行
        if ($_GET['action'] === 'delete') {
            // 実際の削除処理
            // $sql = 'DELETE FROM `テーブル名` WHERE 削除したいレコードの条件';
            // 削除する処理の場合、一件の単位がレコードなのでカラムを指定する必要はない
            // どのレコードを削除するかをprimary keyであるidで指定して削除する
            $sql = 'DELETE FROM `friends` WHERE `friend_id` = ' . $_GET['friend_id'];

            $stmt = $dbh->prepare($sql);
            $stmt->execute();

            header('Location: index.php');
        }
    }


    // 都道府県名を表示するためのSQL文
    $sql = sprintf('SELECT * FROM areas WHERE area_id=%s', $_GET['area_id']);
    // var_dump($_GET['area_id']); ← var_dumpで型の判定ができる
    
    $stmt = $dbh->prepare($sql);
    $stmt->execute();

    $rec = $stmt->fetch(PDO::FETCH_ASSOC);

    $area_name = $rec['area_name'];

    // var_dump($rec);

    // 友達リストを表示するためのSQL文
    $sql = sprintf("SELECT * FROM `friends` WHERE  `area_id` = %s", $_GET['area_id']);

    // SQL文の実行
    $stmt = $dbh->prepare($sql);
    $stmt->execute();

    // 取得データ格納用Array
    $friends = array();

    // 男女カウント用変数
    $male = 0;
    $female = 0;

    while(1){
      // データ取得
      $rec = $stmt->fetch(PDO::FETCH_ASSOC);

      if ($rec == false){
        //データ取得の末尾まで到達したので繰り返しの処理を終了する
        break;
      }

      //データ格納
      $friends[] = $rec;

      //男女の人数を計算
      if ($rec['gender'] == 1){
        $male++;
      }else if ($rec['gender'] == 2){
        $female++;
      }
    }

    // 平均年齢取得
    $sql = 'SELECT `gender`, TRUNCATE(AVG(`age`), 2) AS avgAge FROM `friends` WHERE `area_id` = '
            . $_GET['area_id']
            . ' GROUP BY `gender`';

    $stmt = $dbh->prepare($sql);
    $stmt->execute();

    $avgAge = array();

    while(1) {
        $rec = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($rec == false) {
            break;
        }

        $avgAge[] = $rec;
    }

    echo '<pre>';
    var_dump($avgAge);
    echo '</pre>';


    //var_dump($friends);
    //var_dump($male);
    //var_dump($female);
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

    <script type="text/javascript">
      function destroy(friend_id) {
        // confirm()内のokボタンを押すとtrueを、cancelボタンを押すとfalseを返す
        if (confirm('FRIEND_ID: ' + friend_id + 'の友達を削除しますか？') == true) {
          var fuga = 'ふが'; // 変数定義
          console.log(fuga); // PHPのecho文的な役割

          // ページをリロードしdelete処理を実行するための記述
          // JSでの文字連結は+でできます (PHPのドットと同じ)
          location.href = 'show.php?action=delete&friend_id=' + friend_id;
        }

      }
    </script>

  </head>
  <body>

  <div>
    <div>
      <div>
      <legend><?php echo $area_name; ?>の友達</legend>
      <div>
        男性：<?php echo $male; ?>名　女性：<?php echo $female; ?>名<br>
        <?php
            if ($avgAge[0]['gender'] == 2) {
                echo '男性平均:--歳　';
                echo '女性平均:' . $avgAge[0]['avgAge'] . '歳';

                
            } else if (empty($avgAge[1]['gender'])) {
                echo '男性平均:' . $avgAge[0]['avgAge'] . '歳　';
                echo '女性平均:--歳';


            } else {
                echo '男性平均:' . $avgAge[0]['avgAge'] . '歳　';
                echo '女性平均:' . $avgAge[1]['avgAge'] . '歳';
            }
        ?>
      </div>

        <table>
          <thead>
            <tr>
              <th><div>名前</div></th>
              <th><div>操作</div></th>
            </tr>
          </thead>
          <tbody>
            <!-- 友達の名前を表示 -->
            <?php foreach ($friends as $friend) { ?>
              <tr>
                <td><div><?php echo $friend['friend_name']; ?></div></td>
                <td>
                  <div>
                    <a href="edit.php?friend_id=<?php echo $friend['friend_id']; ?>">編集</a>&nbsp;&nbsp;&nbsp;&nbsp;
                    <a href="#" onclick="destroy(<?php echo $friend['friend_id']; ?>);">削除</a>
                    <!-- aタグやbuttonタグなどユーザーが押せるタグにonclickを指定することで
                    javascriptのコードを発動することができる
                    今回はjavascript内で定義するdestroy関数にfriend_idを渡した状態で
                    処理を実行する。 -->
                  </div>
                </td>
              </tr>
            <?php 
              }
            ?>
          </tbody>
        </table>

        <input type="button"value="新規作成" onClick="location.href='new.php'">
      </div>
    </div>
  </div>

    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
  </body>
</html>
