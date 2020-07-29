<?php


namespace app\modules\dealers\core;


abstract class AbstractPreparation
{
    protected $data;

    /** @var */
    protected $preparedData;

    /**
     * @return mixed
     */
    public function getPreparedData()
    {
        return $this->preparedData;
    }

    public function setData(array $data)
    {
        if (!empty($data)) {
            $this->data = $data;
        }
        return $this;
    }

    /**
     * @return $this
     */
    public function prepareData(AbstractData $dataObject)
    {
        $this->preparedData = $dataObject->setData($this->data)->getPreparedData();
        return $this;
    }
}