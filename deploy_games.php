<?php

  $file = file_get_contents('https://srmcgann.github.io/game_folders_sql/games.zip');
  file_put_contents('../games.zip', $file);
  
  $zip = new ZipArchive;
  $zip->open('../games.zip');
  $zip->extractTo('../.');
  $zip->close();
  unlink('../games.zip');

  @copy('db.php', "../tictactoe");
  @copy('db.php', "../trektris");
  @copy('db.php', "../orbs");
  @copy('db.php', "../sidetoside");
  @copy('db.php', "../puyopuyo");
  @copy('db.php', "../battleracer");
  @copy('db.php', "../spelunk");
  @copy('db.php', "../battlejets");
  @copy('db.php', "../run");
?>
