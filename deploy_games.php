<?php

  $file = file_get_contents('https://srmcgann.github.io/game_folders_sql/games.zip');
  file_put_contents('../games.zip', $file);
  
  $zip = new ZipArchive;
  $zip->open('../games.zip');
  $zip->extractTo('../.');
  $zip->close()
  unlink('../games.zip');
?>