<?php
/**
* ###0. Playing with letters

* 0.0 Use function ord() to retrieve a numeric (ASCII) representation of a character: http://php.net/manual/en/function.ord.php
* 0.1 Generate random letters in an infinite loop, using rand() and chr(), but use the number only if the number stands for a valid lowercase OR uppercase letter.
* 0.2 Create a program which contains two loops (iterations). In the first one, generate 100 random numbers and put them into an array. In the second part, iterate over this array and print the numbers bigger than 20.
* 0.3 Modify the previous program so it does not print the numbers, but the indexes (positions in the array) where these numbers are.
* 0.4 Modify the previous program so it prints only the index of first number greater than 20 (first occurence of such number).
* 0.5 Create a program which prints numbers representing ASCII positions of letters of your name and surname. Hint: Create an array of the letters first, then iterate over that array and use ord() function.

 */

/**
 * Use function ord() to retrieve a numeric (ASCII) representation of a character: http://php.net/manual/en/function.ord.php
 * @param string $character transfer into ASCII
 * @return int ASCII value
 */
function zero(string $character): int
{
    return ord($character);
}

/**
 * Generate random letters in an infinite loop, using rand() and chr(),
 * but use the number only if the number stands for a valid lowercase OR uppercase letter.
 */
function one() {
    // ranges are 65-90 and 97-122
    while(true) {
        $letter = rand(0, 127);
        if (((65 <= $letter) && ($letter <= 90)) || ((97 <= $letter) && ($letter <= 122))) {
            echo chr($letter) . "\n";
        }
        sleep(0.5);
    }
}

/**
 * Create a program which contains two loops (iterations). In the first one,
 * generate 100 random numbers and put them into an array.
 * In the second part, iterate over this array and print the numbers bigger than 20.
 *
 * Modify the previous program so it does not print the numbers, but the indexes (positions in the array) where these numbers are.
 *
 * Modify the previous program so it prints only the index of first number greater than 20 (first occurence of such number).
 *
 */
function two(){
    $arr = [];
    for ($i = 0; $i < 100; $i++) {
        $arr[] = rand(0, 100);
    }
    foreach ($arr as $key => $value) {
        if ($value > 20) {
            echo "Index: $key, Number: $value \n";
            // for the second modification
            // break;
        }
    }
}

/**
 * Create a program which prints numbers representing ASCII positions of letters of your name and surname.
 * Hint: Create an array of the letters first, then iterate over that array and use ord() function.
 */
function five() {
    $surname = str_split("Simona Chovancova");
    foreach ($surname as $letter) {
        echo ord($letter) . " ";
    }
}