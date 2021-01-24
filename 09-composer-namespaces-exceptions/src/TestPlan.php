<?php


namespace main;


use main\checks\errors\TestException;

class TestPlan
{
    static function run() {
        $testInputSource = new CsvTestInputSource("path");
        $csvInput = $testInputSource->getTestInput(); // returns TestInput instance
        while ($csvInput !== null) {
            $dataAccessor = new HawkDataAccessorRedo($csvInput);
            $steps = TestGenerator::getSteps($csvInput); // array of TestStep
            foreach ($steps as $step) {
                $resp = $dataAccessor->fetchWidgetAssoc();
                $check = $step->getCheck();
                try {
                    $check->checkApiResponse($resp);
                    echo "Test passed";
                } catch (TestException $ex) {
                    echo "Test failed";
                }
            }
            $csvInput = $testInputSource->getTestInput(); // keep getting new TestInput instance
        }
    }

}