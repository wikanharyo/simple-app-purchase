<?php
    $grid =[
       ['#','#','#','#','#','#','#','#'],
       ['#','.','.','.','.','.','.','#'],
       ['#','.','#','#','#','.','.','#'],
       ['#','.','.','.','.','#','.','#'],
       ['#','X','#','.','.','.','.','#'],
       ['#','#','#','#','#','#','#','#']
    ];

    //Initiate Position Start
    $startX = 4; 
    $startY = 1;
    
    //Create Random Treasure Position
    $posX = rand(1,4);
    $posY = rand(1,6);

    //Make sure Treasure Not In Obstacle
    $bool = true;
    while ($bol){
      if ($grid[$posX][$posY] == '#'){
          $posX = rand(1,4);
          $posY = rand(1,6);
      } else $bool = false;
    }

    //Display Treasure Location
    $grid[$posX][$posY] = '$';
    for ($x = 0; $x <= 5; $x++) {
        for ($y = 0; $y <= 7; $y++) {
            echo $grid[$x][$y];
        }
        echo PHP_EOL;
    }
    echo PHP_EOL;
    
    echo 'Input Your Move' . PHP_EOL;
    echo 'Up/North A step(s):';
    $up = fgets(STDIN);
    echo 'Right/East B step(s):';
    $right = fgets(STDIN);
    echo 'Down/South C step(s):';
    $down = fgets(STDIN);

    // Search treasure
    $guessedX = $startX - $up;
    $guessedY = $startY + $right;
    $guessedX += $down;

    if (($posX == $guessedX) && ($posY == $guessedY)) {
        echo 'You win' . PHP_EOL;
    } else {
        echo 'You lose' . PHP_EOL;
    }
