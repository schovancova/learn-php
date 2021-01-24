<?php


namespace main;


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