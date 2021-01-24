<?php


namespace main\checks;


use main\checks\errors\TestException;

class TwoListsOfProductsCheck implements HawkCheck {
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
    public function checkApiResponse($response): ?bool
    {
        $dealsInfo = $this->arrayInfo($response, "deals");
        $contractsInfo = $this->arrayInfo($response, "contracts");
        if (($dealsInfo["isArray"] && $contractsInfo["isArray"]) && !($dealsInfo["isEmpty"] && $contractsInfo["isEmpty"])) {
            return true;
        }
        throw new TestException("Failed");
    }
}