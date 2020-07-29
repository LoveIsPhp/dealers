<?php


namespace app\modules\dealers\common;


use app\modules\dealers\core\AbstractRequest;

class Request extends AbstractRequest
{
    /** @var */
    private $bitrix_client_id;
    /** @var */
    private $requestResult;

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * @param $name
     * @return $this
     */
    public function setCompanyData($name)
    {
        if ($this->isCompanyInBitrix($name)) {
            $this->setBitrixClientId(json_decode($this->requestResult)->result[0]->ID);
        } else {
            $this->createCompanyInBitrix($name)->setBitrixClientId(json_decode($this->requestResult)->result);
        }
        return $this;
    }

    /**
     * @return mixed
     */
    public function getBitrixClientId()
    {
        return $this->bitrix_client_id;
    }

    /**
     * @param $id
     * @return $this
     */
    private function setBitrixClientId($id)
    {
        $this->bitrix_client_id = $id;
        return $this;
    }

    /**
     * @param $name
     * @return bool
     */
    private function isCompanyInBitrix($name)
    {
        $this->bitrix->call("crm.company.list",
            [
                "filter" => ['TITLE' => $name],
                'select' => ['id']
            ]
        );
        $this->requestResult = $this->bitrix->getRawResponse();
        if (isset(json_decode($this->requestResult)->result[0])) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * @param $name
     * @return $this
     */
    private function createCompanyInBitrix($name)
    {
        $this->bitrix->call("crm.company.add",
            [
                'fields' => [
                    "TITLE" => $name,
                    "COMPANY_TYPE" => "CUSTOMER",
                ],
                'params' => [

                ]
            ]
        );
        $this->requestResult = $this->bitrix->getRawResponse();
        return $this;
    }
}