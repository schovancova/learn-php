<?php


namespace main\checks;


use main\checks\errors\TestException;

class WidgetTitleCheck implements HawkCheck {
    public function checkApiResponse($response): ?bool
    {
        if (array_key_exists("title", $response)) {
            if (!empty($response["title"])) {
                return true;
            }
        }
        throw new TestException("Failed");
    }
}