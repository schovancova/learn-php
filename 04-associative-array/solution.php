<?php


function generate_arr($maximum=9): array
{
    $arr = [];
    for ($i = 0; $i < 100; $i++) {
        $arr[] = rand(0, $maximum);
    }
    return $arr;
}

/**
 * Generate an array of 100 random numbers (range from 0 to 9).
 * Find the mode (most frequently occurring number), print it and print the number of its occurrences.
 *
 * Modify the previous program so it prints number of occurrences of
 * all items in the list (should be 10 records, unless we are extremely unlucky).

 */

function mode() {
    $arr = generate_arr();
    $frequencies = [];
    foreach ($arr as $item) {
        if (isset($frequencies[$item])) {
            $frequencies[$item]++;
        } else {
            $frequencies[$item] = 1;
        }
    }
    $maximum =  max($frequencies);
    $idOfMax = implode(", ", array_keys($frequencies, $maximum));
    echo "Mode is $idOfMax, occurred $maximum times, all occurrences are as follows:\n";
    asort($frequencies);
    print_r($frequencies);
}

/**
 * Generate an array of 100 random numbers (range from 0 to 99).
 * Divide them into "categories" identified by multiples of 10 (0, 10, 20, ..., 90),
 * so that each category is represented by an item in the associative array,
 * where the item key is the category identifier number (0, 10, 20, ..., 90),
 * and the value is a list (normal array) of all numbers from the original array,
 * which are greater than or equal to this number, but lower than the next one.
 * Hint: Initialize the $result array first, so you have an empty result list,
 * to which you add numbers as you iterate the randomly-generated input array.

 */
function categories() {
    $arr = generate_arr(99);
    $result = [];
    for ($i=0; $i<100; $i+=10) {
        $result[$i] = [];
    }
    foreach ($arr as $item) {
        $result[intval($item/10)*10][] = $item;
    }
    print_r($result);

}

/**
 * Open a CSV file and parse it using fgetcsv. Store the first line in a separate variable -
 * it's the array header. Use array_combine to create an associative array from each line.
 * If your original CSV file had N rows (including the header), you should have N-1 associative arrays,
 * ideally stored within one big array (with numeric index).
 * Use var_dump() to make sure you have the right result.
 *
 * MOD 1: Modify the previous program so it prints the names and prices of the products,
 * using the CSV header name. What is different to our last homework?
 * What happens if somebody changes the order of the columns in the CSV?

 */

function csv() {
    $header = [];
    $result = [];
    if (($handle = fopen("files/file.csv", "r")) !== false) {
        if (($data = fgetcsv($handle, 0, ",")) !== false) {
            $header = $data;
        }
        while (($data = fgetcsv($handle, 0, ",")) !== false) {
            $result[] = array_combine($header, $data);
            // First modification
            foreach ($header as $key => $value) {
                echo "$value is $data[$key]; ";
            }
            echo "\n";
        }
        fclose($handle);
    }
    //print_r($result);
}

/**
 * MOD 2: Modify the previous program so it does not print the names and prices.
 * Instead, create a new associative array, where the keys will be product IDs,
 * and the values the product names.
 * Use json_encode() to generate a JSON from this new array.
 * Hint: Initialize your $result (associative) array before you start iterating over the CSV lines.
 * Then, for each line, do the data processing and add the product to the result,
 * such as $result[$productId] = $productName.
 */
function csvMod2() {
    $result = [];
    if (($handle = fopen("files/file.csv", "r")) !== false) {
        fgetcsv($handle, 0, ","); // skip header
        while (($data = fgetcsv($handle, 0, ",")) !== false) {
            $result[$data[0]] = $data[1];
        }
        fclose($handle);
    }
    $resultJson = json_encode($result);
    echo "JSON result for second modification: $resultJson";
}

/**
 * Modify the previous program so each record (the assoc. array value) will consist
 * of a (nested) associative array, containing the product price, name and link, identified with these words as keys.
 */

function csvMod3() {
    $header = [];
    $result = [];
    if (($handle = fopen("files/file.csv", "r")) !== false) {
        if (($data = fgetcsv($handle, 0, ",")) !== false) {
            $header = $data;
        }
        while (($data = fgetcsv($handle, 0, ",")) !== false) {
            $row = array_combine($header, $data);
            unset($row[$header[0]]);
            $result[$data[0]] = $row;
        }
        fclose($handle);
    }
    print_r($result);
}

/**
 * Create a simple associative array, such as Hawk team members we did in the lesson.
 * Use isset($assocArray[$key]) to check whether a certain key exists in that array.
 * What happens if there is an item in the array with null value?
 * Use unset($assocArray[$key]) to remove a key from the array.
 * Check that the item is actually removed using isset.
 * What happens if you try to unset it again? Can you an item with the same key, if you already unset it?

 */
function arrays() {
    $arr = ["name"=>"phone", "price"=>10000, "brand"=>"Nokia", "something"=>null];
    // prints 1
    echo isset($arr["name"]);
    // testing for null does not print anything
    echo isset($arr["something"]);
    // remove key, echo shouldn't print anything
    unset($arr["name"]);
    echo isset($arr["name"]);
    // unsetting again doesn't do anything
    unset($arr["name"]);
    // using the unset key will produce PHP notice
    echo $arr["name"] ?? null;
    // setting it again, prints 1 again
    $arr["name"] = "new name";
    echo isset($arr["name"]);

}

/**
 * Remember how we can download data from FIE API and parse the JSON into an (nested)
 * associative array structure. Create a program which iterates over the products from
 * the result (var_dump can help you find the right "path" inside the data) and checks,
 * whether the score, price and affiliate link is set for each product:
 * http://search-api.fie.futurenet.com/widget.php?site=TRD&territory=GB&trd_product_id=1191350&id=top
 *
 * ^ that didn't work so I used the one from interview task:
 * https://search-api.fie.future.net.uk/widget.php?id=review&model_name=xbox_one_s&area=GB

 */
function parseProducts() {
    $data = file_get_contents("https://search-api.fie.future.net.uk/widget.php?id=review&model_name=xbox_one_s&area=GB&product_id=1191350");
    $json = json_decode($data, true);
    $products = $json["widget"]["data"]["offers"];
    foreach ($products as $item) {
        $score = (isset($item['score'])) ? $item['score'] : null;
        $price = (isset($item['offer']['price'])) ? $item['offer']['price'] : null;
        $link = (isset($item['offer']['link'])) ? $item['offer']['link'] : null;
        echo "Score is " . (($score) ? "set as " . $score : "not set") . "\n";
        echo "Price is " . (($price) ? "set as " . $price : "not set") . "\n";
        echo "Link is " . (($link) ? "set as " . $link : "not set") . "\n";
        echo "\n";
    }
}

/**
 * Modify the previous program so it checks that the score is a floating-point number;
 * price is a string but can be converted to non-zero floating-point number as well,
 * and affiliate link is URL (use filter_var($url, FILTER_VALIDATE_URL)).
 * Test whether the products are ordered by price, from the cheapest to the most expensive.
 * Test whether the score attribute is descending (the first product should have the highest score,
 * the last one the lowest).
 */

function is_string_float(string $num) {
    $floatVal = floatval($num);
    if($floatVal && intval($floatVal) != $floatVal) return true;
    return false;
}
function parseProductsMod1() {
    $prices = [];
    $scores = [];
    $data = file_get_contents("https://search-api.fie.future.net.uk/widget.php?id=review&model_name=xbox_one_s&area=GB&product_id=1191350");
    $json = json_decode($data, true);
    $products = $json["widget"]["data"]["offers"];
    foreach ($products as $item) {
        $score = (isset($item['score'])) ? $item['score'] : null;
        $price = (isset($item['offer']['price'])) ? $item['offer']['price'] : null;
        $link = (isset($item['offer']['link'])) ? $item['offer']['link'] : null;
        $scores[] = (float)$score;
        $prices[] = (float)$price;
        echo "Score ($score) is " . ((is_string_float($item['score'])) ? "float" : "not float") . "\n";
        echo "Price ($price) is " . ((is_string_float($price)) ? "float" : "not float") . "\n";
        echo "Link is " . ((filter_var($link, FILTER_VALIDATE_URL)) ? "valid URL" : "invalid URL") . "\n";
        echo "\n";
    }
    $ascending_prices = $prices;
    sort($ascending_prices);
    echo "Prices are " . (($ascending_prices === $prices) ? "ascending" : "descending or neither") . "\n";
    $descending_scores = $scores;
    rsort($descending_scores);
    echo "Scores are " . (($descending_scores === $scores) ? "descending" : "ascending or neither") . "\n";
}
/**
 * These 2 I didn't do, as the link didn't work
 *
 * Use the Comparison Chart API to get slightly different data:
 * http://search-api.fie.futurenet.com/widget.php?site=TRD&territory=GB&trd_product_id=1191350&id=comparison&rows=20
 * With this dataset, check the previous two conditions as well (price order, score order).
 * What results do you see? Is it correct?
 *
 * 3.3.5 Put the Top Widget test and Comparison Chart test into one test file,
 * copy-paste code when necessary. Realize how much code you need to duplicate and think about the disadvantages
 * of copy-pasted (very similar) code snippets. Think about what the best solutions might be.
 */