<?php


namespace app\modules\dealers\models;


use app\models\ClientCar;
use app\modules\dealers\core\AbstractModel;

class ClientCarExtension extends AbstractModel
{
    private $clientId;
    /** @var */
    private $clientCarId;
    /** @var */
    private $carStateNumber;

    /**
     * ClientCarExtension constructor.
     * @param $row
     * @param $clientId
     */
    public function __construct($row, $clientId)
    {
        parent::__construct($row);
        $this->clientId = $clientId;
        $this->carStateNumber = $this->currentRow['carStateNumber'];
    }

    /**
     * @return $this
     */
    public function import()
    {
        $client_id = $this->clientId;
        $car_model_id = (new CarModelExtension($this->currentRow))->import()->getCarModelId();
        $car_state_number = $this->carStateNumber;
        $clientCar = ClientCar::findOne(['client_id' => $client_id, 'car_model_id' => $car_model_id, 'car_state_number' => $car_state_number]);
        if ($clientCar === null) {
            $clientCar = new ClientCar();
            $clientCar->client_id = $client_id;
            $clientCar->car_model_id = $car_model_id;
            $clientCar->car_state_number = $car_state_number;
            $clientCar->vin = $this->currentRow['vin'];
            $clientCar->extra_desc = $this->currentRow['extra_desc'];
            $clientCar->tank_capacity = $this->currentRow['tank_capacity'];
            $clientCar->dut = $this->currentRow['dut'];
            $clientCar->save();
            if (!empty($clientCar->errors)) {
                AbstractModel::$errors[] = $clientCar->errors;
            }
            $this->clientCarId = $clientCar->id;
        } else {
            $this->clientCarId = $clientCar->id;
        }
        return $this;
    }

    /**
     * @return mixed
     */
    public function getClientCarId()
    {
        return $this->clientCarId;
    }
}