<?php
/**
 * Test Input The test input should be represented by TestInput class.
 * It is very simple, it basically consists (i.e. is has properties) of the widget name (string)
 * and (an associative array of) query parameters, which together define an
 * API endpoint (assuming we already know the host name). The parameters are basically
 * the same as the parameters of the last method of HawkDataAccessor you have worked on last week.
 */

class TestInput {
    /**
     * @var string
     */
    public $widgetName;
    /**
     * @var array
     */
    public $queryParams;

    /**
     * TestInput constructor.
     * @param string $widgetName
     * @param array $queryParams
     */
    public function __construct(string $widgetName, array $queryParams)
    {
        $this->widgetName = $widgetName;
        $this->queryParams = $queryParams;
    }
}


/**
 * Refactor your HawkDataAccessor (or create a new similar class, if you want),
 * so that it will take a TestInput object as a parameter.
 * Then, inside the method of HawkDataAccessor, the actual values are "pulled" from the specific
 * TestInput (use getters) and the respective request is sent to the API.
 *
 * Test that your code works so far by creating a simple top level program,
 * which creates several different TestInputs, one HawkDataAccessor and prints the JSON
 * response for each request. You should get this working before you continue with the next part.
 * Ideally, json_decode the response inside the HawkDataAccessor class, so the result will be an associative array
 * (use the second parameter true to enforce it to be an array) representing the result, NOT just a long string
 * with bunch of curly brackets.
 */
class HawkDataAccessorRedo {
    /**
     * @var TestInput hostname
     */
    public $input;

    const hostName = "www.google.com";

    /**
     * HawkDataAccessorRedo constructor.
     * @param TestInput $input
     */
    public function __construct(TestInput $input)
    {

        $this->input = $input;
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
        $complete_url = HawkDataAccessorRedo::hostName . "/" . $url;
        return $this->makeRequest($complete_url);
    }

    /**
     * @param string $query
     * @return array data
     */
    public function fetchWidgetQuery(string $query): array {
        $complete_url = HawkDataAccessorRedo::hostName . "/" . $this->input->widgetName . "?" . $query;
        return $this->makeRequest($complete_url);
    }


    private function validateParams(): bool {
        if (isset($this->input->queryParams['id']) && (isset($this->input->queryParams['site']))) {
            return true;
        }
        return false;
    }

    public function fetchWidgetAssoc(): array {
        if (!$this->validateParams()) {
            throw new InvalidArgumentException("Invalid params");
        }
        $query = http_build_query($this->input->queryParams);
        return $this->fetchWidgetQuery($query);
    }

}

/**
 * Create a class CsvTestInputSource. An object of this class will be given a path to a CSV file,
 * from which it will read the test inputs. As an example, the columns of the CSV might be
 * "widget id", "site", "territory", "article_id". Each row in the file then represents a specific request.
 * CsvTestInputSource will create a new TestInput object from each row. Create a method of the reader,
 * which will return one TestInput at a time. Return null when there are no more inputs
 * (i.e. the we reached the end of the file).
 */

class CsvTestInputSource {
    /**
     * @var array
     */
    private $header;
    /**
     * @var array
     */
    private $data;

    /**
     * CsvTestInputSource constructor.
     * @param string $path
     */
    public function __construct(string $path)
    {
        $this->data = $this->readData($path);
        $this->header = array_shift($this->data);
    }

    /**
     * @param string $path
     * @return array
     */
    private function readData(string $path): array {
        $data = [];
        if (($handle = fopen($path, "r")) !== false) {
            while (($row = fgetcsv($handle, 0, ",")) !== false) {
                $data[] = $row;
            }
            fclose($handle);
        }
        return $data;
    }

    /**
     * @return TestInput|null
     */
    public function getTestInput(): ?TestInput
    {
        $row = array_shift($this->data);
        if ($row === null) {
            return null;
        }
        $labelledRow = array_combine($this->header, $row);
        $widgetName = $labelledRow['widget'];
        return new TestInput($widgetName, $labelledRow);
    }
}

/**
 * Now, you can amend your top level program (or create a new one, that's up to you).
 * Instead of manually creating each TestInput object, you will just create one CsvTestInputSource,
 * which will start creating these inputs for you, as you specify them in the CSV. The big advantage
 * of such approach is that we can have an overview of the test steps in a spreadsheet,
 * and just make the software crunch through them.
 */

function program() {
    $inputSource = new CsvTestInputSource("files/file.csv");
    $test = $inputSource->getTestInput();
    while ($test !== null){
        echo $test->widgetName;
        print_r($test->queryParams);
        $test = $inputSource->getTestInput();
    }
}
program();
/**
 * Right now, we will create two different checks (assertions), represented by two classes. One for the widget
 * title and another one checking there is an array of "deals" and another array of "contracts" in the response.
 * Each of these classes should have a method checkApiResponse which takes the (already decoded) API response as
 * a parameter. If you remember, we should have this response available as an associative array from our HawkDataAccessor class.
 *
 * So, the first assertion is represented by WidgetTitleCheck. In the checkApiResponse, you will just traverse through
 * the associative array and test whether the 'title' field is present and it's a non-empty string. Return true if the
 * test passes, or false if any of the described conditions is not met.
 */

class WidgetTitleCheck {
    public function checkApiResponse($response): bool
    {
        if (array_key_exists("title", $response)) {
            if (!empty($response["title"])) {
                return true;
            }
        }
        return false;
    }
}

/**
 * The second check is TwoListsOfProductsCheck. In this case, we will find 'deals' and 'contracts' fields,
 * and make sure they are both arrays. Again, return true or false, based on the result of the test.
 * The array of 'deals' or 'contracts' might be empty. We should test whether at least one of these arrays is
 * non-empty. If this was the case, Hawk should have fallen back to TopDeals!
 */

class TwoListsOfProductsCheck {
    private function arrayInfo(array $response, string $key): array {
        $isEmpty = false;
        $isArray = false;
        if (array_key_exists($key, $response)) {
            if (is_array($response[$key])) {
                $isArray = true;
                if (empty($response[$key])) {
                    $isEmpty = true;
                }
            }
        }
        return ["isEmpty"=>$isEmpty, "isArray"=>$isArray];
    }
    public function checkApiResponse($response): bool
    {
        $dealsInfo = $this->arrayInfo($response, "deals");
        $contractsInfo = $this->arrayInfo($response, "contracts");
        return (($dealsInfo["isArray"] && $contractsInfo["isArray"]) && !($dealsInfo["isEmpty"] && $contractsInfo["isEmpty"]));
    }
}
$response = ["deals"=>["1"], "contracts"=> ["2"]];
$test = new TwoListsOfProductsCheck();
//echo $test->checkApiResponse($response);
