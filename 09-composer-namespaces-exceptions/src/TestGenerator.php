<?php


namespace main;


use main\checks\TwoListsOfProductsCheck;
use main\checks\WidgetTitleCheck;

class TestGenerator
{
    /**
     * @param TestInput $input
     * @return array
     */
    static function getSteps(TestInput $input): array {
        $checks = [TwoListsOfProductsCheck::class, WidgetTitleCheck::class];
        $result = [];
        foreach ($checks as $check) {
            $result[] = new TestStep($input, $check);
        }
        return $result;
    }
}