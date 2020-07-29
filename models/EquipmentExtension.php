<?php

namespace app\modules\dealers\models;

use app\modules\dealers\core\AbstractModel;
use app\models\Equipment;

class EquipmentExtension extends AbstractModel
{
    private $equipmentId;
    private $equipment;

    public function __construct($row)
    {
        parent::__construct($row);
    }

    public function import()
    {
        $equipment = Equipment::findOne(['label' => $this->currentRow['productName']]);
        if ($this->shouldRowBeCreate($equipment)) {
            $this->equipment = new Equipment();
            $this->equipment->label = $this->currentRow['productName'];
            $this->setCategoryId();
            $this->equipment->save();
            if (!empty($this->equipment->errors)) {
                AbstractModel::$errors[] = ['equipmentName' => $this->currentRow['productName'], 'error' => $this->equipment->errors];
                $this->equipmentId = $this->equipment->id;
            }
        } else {
            $this->equipmentId = $equipment->id;
        }
        return $this;
    }

    public function getEquipmentId()
    {
        return $this->equipmentId;
    }

    private function getCategoryIdByName($categoryName)
    {
        return (new CategoryExtension($categoryName))->import()->getCategoryId();
    }

    private function setCategoryId()
    {
        if (empty($this->currentRow['categoryName'])) {
            $this->equipment->category_id = null;
        } else {
            $this->equipment->category_id = $this->getCategoryIdByName($this->currentRow['categoryName']);
        }
    }

}