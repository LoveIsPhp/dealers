<?php


namespace app\modules\dealers\models;

use app\models\EquipmentCategory;
use app\modules\dealers\core\AbstractModel;

/**
 * Class CategoryExtension
 * @package app\modules\dealers\models
 */
class CategoryExtension extends AbstractModel
{
    /** @var */
    private $name;
    /** @var */
    private $equipmentCategoryId;

    /**
     * CategoryExtension constructor.
     * @param $name
     */
    public function __construct($name)
    {
        parent::__construct([]);
        $this->name = $name;
    }

    public function import()
    {
        $equipmentCategory = EquipmentCategory::findOne(['label' => $this->name]);
        if ($this->shouldRowBeCreate($equipmentCategory)) {
            $equipmentCategory = new EquipmentCategory();
            $equipmentCategory->label = $this->name;
            $equipmentCategory->save();
            if (!empty($equipmentCategory->errors)) {
                AbstractModel::$errors[] = ['categoryName' => $this->name, 'error' => $equipmentCategory->errors];
            }
            $this->equipmentCategoryId = $equipmentCategory->id;
        } else {
            $this->equipmentCategoryId = $equipmentCategory->id;
        }
        return $this;
    }

    public function getCategoryId()
    {
        if (!empty($this->equipmentCategoryId)) {
            return $this->equipmentCategoryId;
        } else {
            return '';
        }
    }
}