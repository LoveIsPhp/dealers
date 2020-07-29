<?php


namespace app\modules\dealers\models;


use app\models\Client;
use app\models\ClientCar;
use app\models\dealer\Dealer;
use app\modules\dealers\common\Request;
use app\modules\dealers\core\AbstractModel;

class ClientExtension extends AbstractModel
{
    private $clientId;
    private $clientCarId;

    public function __construct($row)
    {
        parent::__construct($row);
    }

    public function import()
    {
        $name = $this->currentRow['client'];
        if (!empty($name)) {
            $client = Client::findOne(['name' => $name]);
            if ($client === null) {
                $bitrix_client_id = (new Request())->setCompanyData($name)->getBitrixClientId();
                $dealer_id = $this->getDealerId();
                $client = new Client();
                $client->name = $name;
                $client->bitrix_client_id = $bitrix_client_id;
                $client->dealer_id = $dealer_id;
                $client->save();
                if (!empty($client->errors) and isset($this->currentRow['carStateNumber'])) {
                    AbstractModel::$errors[] = $client->errors;
                    $this->clientCarId = (new ClientCarExtension($this->currentRow, $client->id))->import()->getClientCarId();
                    $this->clientId = $client->id;
                }
            } else {
                if (isset($this->currentRow['carStateNumber'])) {
                    $this->clientId = $client->id;
                    $clientCarId = ClientCar::find()->select(['id'])->where(['client_id' => $client->id])->andWhere(['car_state_number' => $this->currentRow['carStateNumber']])->asArray()->all();
                   if (!empty($clientCarId)){
                       $this->clientCarId = $clientCarId;
                   }
                }
            }
        }
        return $this;
    }

    public function getClientCarId()
    {
        return $this->clientCarId;
    }

    public function getClientId()
    {
        return $this->clientId;
    }

    public function getDealerId()
    {
        $dealer = Dealer::find()->select(['id'])->where(['bitrix_crm_domain' => 'demo-dealer.bitrix24.ru'])->one();
        return $dealer->id;
    }
}