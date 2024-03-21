<?php

require('db.php');

$sql = file_get_contents('https://srmcgann.github.io/game_folders_sql/infinityGames.sql');

if (mysqli_multi_query($link, $sql)) {
  do {
    if ($result = mysqli_store_result($link)) {
      while ($row = mysqli_fetch_row($result)) {
        printf("%s\n", $row[0]);
      }
      mysqli_free_result($result);
    }
    if (mysqli_more_results($link)) {
      printf("-------------\n");
    }
  } while (mysqli_next_result($link));
}

?>