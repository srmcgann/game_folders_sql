<?php

$file = file_get_contents('https://srmcgann.github.io/game_folders_sql/battleracer.zip');

file_put_contents('../battleracer.zip', $file);

$zip = new ZipArchive;
if($zip->open('../battleracer.zip')){
  $zip->extractTo('../');
}
$zip->close();

unlink('../battleracer.zip');

@copy('../puyopuyo/db.php', '../battleracer/db.php');
