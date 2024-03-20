<?php

  $file = file_get_contents('https://srmcgann.github.io/game_folders_sql/games.zip');
  file_put_contents('../games.zip', $file);
  
  $zip = new ZipArchive;
  $zip->open('../games.zip');
  $zip->extractTo('../.');
  $zip->close();
  unlink('../games.zip');

  require('db.php');
  $sql = "SELECT * FROM orbsMirrors";
  $res = mysqli_query($link, $sql);
  for($i=0; $i<mysqli_num_rows($res); ++$i){
    $row = mysqli_fetch_assoc($res);
    $gameDir = $row['gameDir'];
    @copy('/db.php', $gameDir);
  }
?>
