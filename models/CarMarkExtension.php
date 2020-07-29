<?php


namespace app\modules\dealers\models;


use app\models\CarMark;
use app\modules\dealers\core\AbstractModel;

class CarMarkExtension extends AbstractModel
{
    private $mark;
    private $markId;

    public function __construct($mark)
    {
        parent::__construct([]);
        $this->mark = $mark;
    }

    public function import()
    {
        $carMark = CarMark::findOne(['label' => $this->mark]);
        if ($carMark === null) {
            $carMark = new CarMark();
            $carMark->label = $this->mark;
            $carMark->save();
            if ($carMark->id) {
                $this->markId = $carMark->id;
            }
        } else {
            $this->markId = $carMark->id;
        }
        return $this;
    }

    public function getMarkId()
    {
        return $this->markId;
    }
}