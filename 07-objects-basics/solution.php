<?php
require_once '../03-type-system/solution/fizzbuzz.php';
/**
7.1.1 Create an empty class called Person.
7.1.2 Create a method sayHello() which prints "Hello!" whenever called.
7.1.3 Create another method getGreeting(), which returns "Hello!",
 * instead of printing it. We provide the top-level program with the result,
 * and the top-level program should print it.
7.1.4 Create a constructor (__construct() method),
 * which takes a string variable $name as a parameter (argument)
 * and saves it in the object property public $name.
7.1.5 Create a method getName(), which returns a string like "I am ",
 * where will be the actual name previously provided in the contructor.
7.1.6 Read about time() function in PHP and find out, what "Unix timestamp" is.
 * Make sure you understand the concept.
7.1.7 When the object is created, save current time to a property (use time() function).
 * That will be the "birth second" of our object.
7.1.8 Create a method getAgeInSeconds(),
 * which determines what the "age" of the object is (in seconds),
 * and returns the result (as a number).
 * Use sleep() in the top-level program to test whether it actually works.
 */

class Person {
    /**
     * @var string name of the person
     */
    private $name;

    /**
     * @var int creation UNIX timestamp
     */
    private $created;

    public function __construct(string $name)
    {
        $this->name = $name;
        $this->created = time();
    }

    public function sayHello(): void {
        echo $this->getGreeting();
    }

    private function getGreeting(): string
    {
        return "Hello!";
    }

    public function getName(): string
    {
        return "I am " . $this->name;
    }
    public function getAgeInSeconds(): int
    {
        sleep(1.5);
        return (time() - $this->created);
    }

}

new Person("Jozko");

/**
 * 7.2.1 Create NumberAggregator class.
7.2.2 Make sure the connstructor takes array of numbers
 * as an argument (parameter) and keeps them in the object property
 * (so the property will be an array).
 * Use PHPDoc to annotate the type of the property with /** @var array .
7.2.3 Create a method addNumber() which will add another
 * number (provided as a method parameter) to the array of numbers stored within the object.
7.2.4 Create getNumbers() method, which returns the array of
 * numbers currently stored in the given NumberAggregator object.
 * Use PHPDoc to annotate the result type of the method.
7.2.5 Create getMaximum() method, which returns the highest number
 * from the numbers currently stored in the given object. Feel free to use max() within the method.
7.2.6 Create similar getMinimum() which returns the lowest number.
7.2.7 Create getMean(), getMedian() and getMode() methods returning
 * the respective "average" number. Reuse the code from your previews homeworks.
 * Ideally, you should already have each of these ready as a plain
 * function from the previous homeworks, so make sure you require_once the
 * file with the function (include it to the top of the class file, above the name)
 * and call the appropriate function from within each method.

 */
class NumberAggregator
{
    /**
     * @var array numbers
     */
    private $nums;

    public function __construct(array $nums)
    {
        $this->nums = $nums;
    }

    /**
     * @param int $num number to add
     */
    public function addNumber(int $num) {
        $this->nums[] = $num;
    }

    /**
     * @return array numbers stored
     */
    public function getNumbers(): array {
        return $this->nums;
    }

    /**
     * @return int maximum number
     */
    public function getMaximum(): int {
        return max($this->nums);
    }

    /**
     * @return int minimum number
     */
    public function getMinimum(): int {
        return min($this->nums);
    }

    /**
     * @return int mean of numbers
     */
    public function getMean(): int {
        return array_sum($this->nums)/count($this->nums);
    }

    /**
     * @return int median of nums
     */
    public function getMedian(): int {
        return median($this->nums);
    }

    /**
     * @return array modes of array
     */
    public function getMode(): array {
        return modus($this->nums);
    }
}
new NumberAggregator([1,1,6,8,12]);

/**
 * ###7.3 Hawk Data Accessor

7.3.1 Create HawkDataAccessor class.
7.3.2 Make sure the constructor accepts $hostName parameter,
 * and saves it in the object property of the same name.
 * The host name should represent the API host name, such as
 * "stage.search-api.fie.future.net.uk" or "search-api.fie.future.net.uk".
7.3.3 Create a method fetchData($url), which uses the host to retrieve
 * the data from the API. The $url parameter is the part of the request URL
 * on the right side of slash (called "path" and "query") -
 * for example "widget.php?site=TRD&trd_product_id=1191350&id=top".
 * You can json_decode() the result before the method returns it, if you think it's sensible.
7.3.4 Create a method fetchWidgetQuery($widgetName, $query).
 * The first argument stands for the widget name, such as "top",
 * which is the "path" part of the URL (basically everything between
 * the first slash and the question mark). The second one contains the "query"
 * part of the URL, such as "site=TRD&trd_product_id=1191350&id=top".
 * The method should connect these two and use fetchData (which you have created before)
 * to get the same result. So, the only difference in these two methods is in how
 * they accept the request parameters.
7.3.5 Create another method fetchWidgetAssoc($widgetName, $parameters),
 * which is very similar to the previous one. The main difference is that
 * $parameters are an associative array of the parameters specified in "query"
 * part of the URL. An example would be $parameters = array('site' => 'TRD',
 * 'trd_product_id' => 1191350, 'id' => 'top'); Use http_build_query function to
 * generate the query string, and then use fetchWidgetQuery to retrieve the data.
7.3.6 Add a validation to the fetchWidgetAssoc method. Check, whether the
 * $parameters array contains the keys 'id' and 'site'. If it does not,
 * print an error message and return null.
 */
class HawkDataAccessor {
    /**
     * @var string hostname
     */
    private $hostName;

    public function __construct(string $hostName)
    {
        $this->hostName = $hostName;
    }

    /**
     * Make a request
     * @param $url
     * @return array parsed data
     */
    private function makeRequest($url):array {
        if (!filter_var($url, FILTER_VALIDATE_URL)) {
            throw new InvalidArgumentException("Invalid URL");
        }
        $data = file_get_contents($url);
        return  json_decode($data, true);
    }

    /**
     * @param string $url
     * @return array data
     */
    public function fetchData(string $url): array {
        $complete_url = $this->hostName . "/" . $url;
        return $this->makeRequest($complete_url);
    }

    /**
     * @param string $widgetName
     * @param string $query
     * @return array data
     */
    public function fetchWidgetQuery(string $widgetName, string $query): array {
        $complete_url = $this->hostName . "/" . $widgetName . "?" . $query;
        return $this->makeRequest($complete_url);
    }

    /**
     * Validate whether url params contain id and site
     * @param array $params
     * @return bool
     */
    private function validateParams(array $params): bool {
        if (isset($params['id']) && (isset($params['site']))) {
            return true;
        }
        return false;
    }

    /**
     * @param string $widgetName
     * @param array $parameters
     * @return array data
     */
    public function fetchWidgetAssoc(string $widgetName, array $parameters): array {
        if (!$this->validateParams($parameters)) {
            throw new InvalidArgumentException("Invalid params");
        }
        $query = http_build_query($parameters);
        return $this->fetchWidgetQuery($widgetName, $query);
    }

}
new HawkDataAccessor("www.google.com");