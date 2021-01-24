<?php


namespace main;


use InvalidArgumentException;

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