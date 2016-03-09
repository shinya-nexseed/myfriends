<?php 
    define('PDO_DSN', 'mysql:dbname=myfriends;host=localhost');
    define('DB_USERNAME', 'root');
    define('DB_PASSWORD', '');

    $dbh = new PDO(PDO_DSN,DB_USERNAME,DB_PASSWORD);
    $dbh->query('SET NAMES utf8');

    $sql = 'SELECT * FROM areas';
    $stmt = $dbh->prepare($sql);
    $stmt->execute();

    // 取得データを格納するための配列を用意
    $areas = array();

    while(1) {
        // データを取得
        $rec = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($rec == false) {
            break;
        }

        // データを用意しておいた配列に格納
        $areas[] = $rec;
    }

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
       <legend>都道府県一覧</legend>
       <table>
         <thead>
           <tr>
             <th>id</th>
             <th>県名</th>
             <th>人数</th>
           </tr>
         </thead>
         <tbody>
           <?php foreach ($areas as $area) { ?>
               <tr>
                 <td><?php echo $area['area_id']; ?></td>
                 <td><a href="show.php?area_id=<?php echo $area['area_id']; ?>"><?php echo $area['area_name']; ?></a></td>
                 <td>3</td>
               </tr>
           <?php } ?>
         </tbody>
       </table>
     </div>
   </body>
 </html>
