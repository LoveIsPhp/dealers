<?php


namespace app\modules\dealers\models;


use app\models\CarModel;
use app\modules\dealers\core\AbstractModel;

class CarModelExtension extends AbstractModel
{
    private $modelId;

    public function __construct($row)
    {
        parent::__construct($row);
    }

    public function import()
    {
        $mark = $this->currentRow['mark'];
        $markId = (new CarMarkExtension($mark))->import()->getMarkId();
        $model = $this->currentRow['model'];

        $carModel = CarModel::findOne(['car_mark_id' => $markId, 'label' => $model]);
        if ($carModel === null) {
            $carModel = new CarModel();
            $carModel->car_mark_id = $markId;
            $carModel->label = $model;
            $carModel->save();
            if (!empty(AbstractModel::$errors)) {
                AbstractModel::$errors[] = $carModel->errors;
            }
            $this->modelId = $carModel->id;
        } else {
            $this->modelId = $carModel->id;
        }
        return $this;
    }

    public function getCarModelId()
    {
        return $this->modelId;
    }
}