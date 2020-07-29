<?php

namespace app\modules\dealers\core;


abstract class AbstractModel
{
    protected $currentRow;
    public static $errors = [];

    public function __construct($row)
    {
        $this->setRow($row);
    }

    protected function setRow(array $rowData)
    {
        if (!empty($rowData)) {
            $this->currentRow = $rowData;
        }
        return $this;
    }

    protected function shouldRowBeCreate($findOne)
    {
        return ($findOne === null) ? true : false;
    }

    abstract public function import();
}