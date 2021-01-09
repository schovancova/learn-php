<?php

/**
 * Write a short script which will print current time, wait for 1 minute and print the time again
 */
function print_time(){
    echo "Time is " . date("H:i:s\n");
}
function first() {
    print_time();
    sleep(60);
    print_time();
}

/**
 * Write an infinite script which will print the time every second (interrupt using Ctrl+C in command line)
 */
function second() {
    while (true) {
        print_time();
        sleep(1);
    }
}

/**
 * Write a script which will print a random number from 0 to 50 (check http://php.net/manual/en/function.rand.php)
 */
function third() {
    echo rand(0, 50);
}

/**
 * Write an infinite script which will print a different random number every second
 * Modify the previous program, so it also prints the verbal information whether the random number is greater or lower than 500
 */
function fourth_and_fifth() {
    while (true) {
        $num = rand(0, 1000);
        echo $num . ($num>=500?" is >= than 500":" is < than 500") . "\n";
        sleep(1);
    }
}

/**
 * Write a similar program, which prints the number only if it is divisible by 3 (use operator modulo, N % M)
 */
function sixth() {
    while (true) {
        $num = rand(0, 1000);
        if ($num % 3 == 0) {
            echo "$num\n";
        }
        sleep(1);
    }
}

/**
 *  Write a similar program, which prints the number only if it is bigger then the digit representing the number of seconds of the current time.
 */
function seventh() {
    while (true) {
        $num = rand(0, 60);
        $seconds = intval(date("s"));
        if ($num > $seconds) {
            echo "$num, current second is $seconds \n";
        }
        sleep(1);
    }
}

/**
 *  Write a program which generates a random number from 0 to 50 every second.
 *  When the number is greater than 40, it prints it and finishes (use break; statement).
 */
function eighth() {
    while (true) {
        $num = rand(0, 50);
        if ($num > 40) {
            echo "Generated $num, exiting\n";
            break;
        }
        sleep(1);
    }
}

/**
 *  Write a similar program. It finishes if the number equals to the digit representing
 *  the number of seconds of the time when it was started.
 */
function ninth() {
    $seconds = intval(date("s"));
    echo "Starting at $seconds \n";
    while (true) {
        $num = rand(0, 60);
        echo "Generated $num \n";
        if ($num == $seconds) {
            break;
        }
        sleep(1);
    }
}
