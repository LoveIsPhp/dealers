<?php


namespace app\modules\dealers\common;

use app\modules\dealers\core\AbstractModel;
use app\modules\dealers\helper\ProgressBarTrait;
use app\modules\dealers\models\ClientEquipmentExtension;
use app\modules\dealers\models\ClientExtension;
use app\modules\dealers\models\EquipmentExtension;
use app\modules\dealers\core\AbstractImport;
use app\modules\dealers\models\ClientCarExtension;

class ImportActives extends AbstractImport
{
    use ProgressBarTrait;
    private $errors = [];

    public function import()
    {
        if (!empty($this->data)) {
            $this->startProgressBarByUsingArray($this->data);
            foreach ($this->data as $row) {
                $this->updateProgressBar();
                $equipmentId = (new EquipmentExtension($row))->import()->getEquipmentId();
                $clientCarId = (new ClientExtension($row))->import()->getClientCarId();
                if (!empty($clientCarId) and (isset($row['carStateNumber']) and !empty($row['carStateNumber'])) and !empty($equipmentId)) {
                    (new ClientEquipmentExtension($row, $equipmentId, $clientCarId))->import();
                }
                if (!empty(AbstractModel::$errors)) var_dump(AbstractModel::$errors);
            }
            $this->finishProgressBar();

        }
        if (!empty($this->errors)) {
            var_dump($this->errors);
            die();
        }
    }
}