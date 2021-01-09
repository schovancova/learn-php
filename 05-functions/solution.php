<?php

/**
 * Create a function which transforms the number into a currency code: 1 = GBP, 2 = USD, 3 = EUR
 * (these values are hard-coded in the function body, use if/elseif/elseif,
 * switch or associative array and key-value lookup).
 */

/**
 * @param int $num number to decode
 * @return string representation of currency
 */
function currency_decode(int $num): ?string  {
    $currencies = [1 => "GBP", 2=>"USD", 3=>"EUR"];
    return (isset($currencies[$num]) ? $currencies[$num] : null);
}

/**
 * Use the function from above in the program from our last lesson, which reads product data from the CSV.
 * ^ I modified the CSV to include currency integers and not strings
 */
function csv() {
    if (($handle = fopen("files/file.csv", "r")) !== false) {
        while (($data = fgetcsv($handle, 0, ",")) !== false) {
            echo "Currency int is $data[3] and it's represented as " . currency_decode($data[3]) . "\n";
        }
        fclose($handle);
    }
}

/**
 * Use the same function in the program which reads the product info from the API.
 * ^ the currency is already written there and there's no currency integer
 *
 * Finish your homework from last lessons (ideally doing (or at least trying) optional assignments as well).
 * Use functions where applicable. That includes cross-task functionality, such as "modify the previous program..."
 * Also, modify your already completed and submitted programs from the last lesson, so there is no unnecessary code duplication.
 * ^ all previous tasks are already in functions
 */