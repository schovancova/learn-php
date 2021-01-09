<?php

/**
 * 1.0 Create a program which reads a CSV file containing one product on each line.\
 * Find the cheapest product and print its name and price. Do not print data of any other product.
 */


function find_cheapest_explode()
{
    $price = $product = null;
    if (($handle = fopen("../files/file.csv", "r")) !== false) {
        while ($data = fgets($handle)) {
            $data = explode(",", $data);
            if (($price == null) || intval($data[1]) < $price) {
                $price = $data[1];
                $product = $data[0];
            }
        }
        fclose($handle);
    }
    echo "Cheapest is $product for $price";
}

/**
 * Modify the previous program so it uses fgetcsv() function.
 * What is the advantage of using it, instead of file() and explode()?
 * Hint: you will need to open the file separately using fopen(), save the "handle"
 * into a variable and only then call fgetcsv.
 */
function find_cheapest_fgetcsv() {
    $price = $product = null;
    if (($handle = fopen("../files/file.csv", "r")) !== false) {
        while (($data = fgetcsv($handle, 0, ",")) !== false) {
            if (($price == null) || intval($data[1]) < $price) {
                $price = $data[1];
                $product = $data[0];
            }
        }
        fclose($handle);
    }
    echo "Cheapest is $product for $price";
}

/**
 * Create a similar program, which reads products information from a CSV file.
 * Each product has a currency. Print a list of all currencies which appear in the
 * CSV file - but each currency only once! Hint: Build a list of currencies first,
 * using in_array function to find out whether we already have the currency in the list or not.
 * The printing part is easy then.
 */
function print_currencies() {
    $currencies = [];
    if (($handle = fopen("../files/file.csv", "r")) !== false) {
        while (($data = fgetcsv($handle, 0, ",")) !== false) {
            if (!in_array($data[2], $currencies)) {
               $currencies[] = $data[2];
            }
        }
        fclose($handle);
    }
    print_r($currencies);
}