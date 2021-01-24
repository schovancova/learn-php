<?php


namespace main;


class TestStep
{
    private $check;
    private $input;

    public function __construct(TestInput $input, $check)
    {
        $this->input = $input;
        $this->check = $check;
    }

    /**
     * @return mixed
     */
    public function getCheck()
    {
        return $this->check;
    }

    /**
     * @return TestInput
     */
    public function getInput(): TestInput
    {
        return $this->input;
    }

}