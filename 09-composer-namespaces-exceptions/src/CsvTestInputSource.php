<?php


namespace main;


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