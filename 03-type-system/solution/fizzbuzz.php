<?php
/**
 * Generate an array of 50 random numbers (range from 0 to 99). Create a program which
 * finds the biggest of these numbers and prints it, along with the index (position) of the number in the array.
 * 2.2 Create a similar program which calculates an average (mean) of the array.
 * 2.3 Try implementing the previous two tasks using built-in functions max() (for the former)
 * and array-sum() (the latter) - or without these functions, if you already used them (basically the other way):
 */

function generate_arr(): array
{
    $arr = [];
    for ($i = 0; $i < 50; $i++) {
        $arr[] = rand(0, 99);
    }
    return $arr;
}

function without_built_ins()
{
    $arr = generate_arr();
    $maximum = $arr[0];
    $idx_max = 0;
    $average = 0;
    $arr_length = 0;
    foreach ($arr as $key => $value) {
        if ($value > $maximum) {
            $maximum = $value;
            $idx_max = $key;
        }
        $arr_length++;
        $average += $value;
    }
    $average /= $arr_length;
    echo "Max is $maximum  at index $idx_max and average is $average \n";
}

function with_built_ins() {
    $arr = generate_arr();
    $average = array_sum($arr)/count($arr);
    $idx_max = array_search(max($arr), $arr);
    $maximum = max($arr);
    echo "Max is $maximum  at index $idx_max and average is $average \n";
}

/**
 * Create another two similar programs which find modal and median of the array of 50 random numbers.
 * @param array $arr
 * @return int median
 */
function median(array $arr=[]):int {
    if ($arr === []) {
        $arr = generate_arr();
    }
    sort($arr);
    $middle = floor((count($arr) - 1) / 2);
    if (count($arr) % 2) {
        $median = $arr[$middle];
    } else {
        $median = ($arr[$middle] + $arr[$middle+1])/2;
    }
    return $median;
}

function modus(array $arr=[]):array {
    if ($arr === []) {
        $arr = generate_arr();
    }
    $frequencies = [];
    foreach ($arr as $item) {
        if (isset($frequencies[$item])) {
            $frequencies[$item]++;
        } else {
            $frequencies[$item] = 1;
        }
    }
    $idx_of_max = array_keys($frequencies, max($frequencies));
    return $idx_of_max;
}

/**
 * Create the standard FizzBuzz program: Print numbers from 1 to 500 with additional
 * "Fizz" when the number is divisible by 3, Buzz when divisible by 5 and
 * FizzBuzz when divisible by 3 AND 5. Remember algorithmic thinking!
 *
 * How would you approach FizzBuzz++, where you also need to find out whether
 * the number is prime? How do you find out whether a number is prime at the
 * first place? Hint: Use pen-n-paper to find an algorithmic way to get this
 * information (prime or not) just for one number.
 */

function is_prime($number){
    if ($number == 1)
        return 0;
    for ($i = 2; $i <= $number/2; $i++){
        if ($number % $i == 0)
            return false;
    }
    return true;
}

function fizzbuzz() {
    for ($i=1; $i<=500; $i++) {
        $prime = (is_prime($i) ? "prime" : "not prime");
        echo "$i $prime ";
        if (!($i % 3)) {
            echo "Fizz";
        }
        if (!($i % 5)) {
            echo "Buzz";
        }
        echo "\n";
    }
}

/**
 * Use rand() function to generate a number. Use this number as a size (length) of an array,
 * and generate an array of random numbers of this size.
 */
function array_maker() {
    $length = rand(0, 50);
    $arr = [];
    for ($i=0; $i < $length; $i++) {
        $arr[] = rand(0, 50);
    }
    print_r($arr);
}

/**
 * Modify the previous program so it creates an array of arrays of random numbers.
 * Hint: Generate the first number, which determines the length of the "main" array.
 * Instead of filling this array directly with numbers, use similar approach to generate
 * another number, which will determine the length of the "nested" array. Only then generate the members.
 */
function array_maker_extended() {
    $length = rand(0, 50);
    $arr = [];
    for ($i=0; $i < $length; $i++) {
        $sub_arr_length = rand(0, 50);
        $sub_arr = [];
        for ($x=0; $x < $sub_arr_length; $x++) {
            $sub_arr[] = rand(0, 50);
        }
        $arr[] = $sub_arr;
    }
    print_r($arr);
}
