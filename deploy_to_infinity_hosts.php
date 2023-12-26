<?php

require('db.php');

$sql = file_get_contents('https://srmcgann.github.io/game_folders_sql/deploy_to_infinity_hosts.sql');

if (mysqli_multi_query($link, $sql)) {
  do {
    if ($res = mysqli_store_result($link)) {
      while ($row = mysqli_fetch_row($res)) {
        printf("%s\n", $row[0]);
      }
     mysqli_free_result($res);
    }
    if (mysqli_more_results($link)) {
    }
  } while (mysqli_next_result($link));
}

mysqli_close($link);

echo "\n\ndone.\n\n";
