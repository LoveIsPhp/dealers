<?php


namespace app\modules\dealers\core;


abstract class AbstractData implements DataInterface
{
    /** @var */
    protected $data;
    /** @var array */
    protected $bitrixUserFields = [
        'NAME' => 1,
        'LAST_NAME' => 2,
        'WORK_COMPANY' => 3,
        'PERSONAL_PHONE' => 4,
        'PERSONAL_MOBILE' => 5,
        'UF_PHONE_INNER' => 6,
        'EMAIL' => 7,
        'PERSONAL_PROFESSION' => 11,
        'UF_DEPARTMENT' => 13,
        'PERSONAL_STREET' => 20,
        'PERSONAL_CITY' => 22,
        'PERSONAL_STATE' => 23,
        'PERSONAL_ZIP' => 24,
        'PERSONAL_COUNTRY' => 25,
        'PERSONAL_PHOTO' => 26
    ];

    public function setData($data)
    {
        $this->data = $data;
        return $this;
    }

    abstract public function getPreparedData();
}