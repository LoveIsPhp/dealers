<?php


namespace app\modules\dealers\models;


use app\models\ClientEquipment;
use app\modules\dealers\core\AbstractModel;

class ClientEquipmentExtension extends AbstractModel
{
    /** @var */
    private $equipmentId;
    /** @var */
    private $clientCarId;
    /** @var */
    private $clientEquipment;

    public function __construct($row, $equipmentId, $clientCarId)
    {
        parent::__construct($row);
        $this->equipmentId = $equipmentId;
        $this->clientCarId = $clientCarId;
    }

    public function import()
    {
        $this->clientEquipment = new ClientEquipment();
        $this->clientEquipment->client_car_id = (int)$this->clientCarId;
        $this->clientEquipment->equipment_id = (int)$this->equipmentId;
        $this->clientEquipment->id_auto_graph = $this->currentRow['id_auto_graph'];
        $this->clientEquipment->active_number = $this->currentRow['active_number'];
        $this->clientEquipment->external_id = $this->currentRow['external_id'];
        $this->clientEquipment->serial_number = $this->currentRow['serial_number'];
        $this->clientEquipment->imei = $this->currentRow['imei'];
        $this->clientEquipment->start_at = date('Y-m-d h:m:s', strtotime($this->currentRow['start_at']));
        $this->clientEquipment->installation_at = $this->currentRow['installation_at'];
        $this->clientEquipment->availability = $this->currentRow['availability'];
        $this->clientEquipment->status_subscribtion = $this->currentRow['status_subscribtion'];
        $this->clientEquipment->date_of_last_calibration =  date('Y-m-d h:m:s', strtotime($this->currentRow['date_of_last_calibration']));
        $this->clientEquipment->soft_group =  $this->currentRow['soft_group'];
        $this->clientEquipment->server =  $this->currentRow['server'];
        $this->clientEquipment->sim1 =  $this->currentRow['sim1'];
        $this->clientEquipment->password =  $this->currentRow['password'];
        $this->clientEquipment->sim2 =  $this->currentRow['sim2'];
        $this->clientEquipment->sms_password =  $this->currentRow['sms_password'];
        $this->clientEquipment->iccid1 =  $this->currentRow['iccid1'];
        $this->clientEquipment->lock_password =  $this->currentRow['lock_password'];
        $this->clientEquipment->iccid2 =  $this->currentRow['iccid2'];
        $this->clientEquipment->driver_card =  $this->currentRow['driver_card'];
        $this->clientEquipment->comment =  $this->currentRow['comment'];
        $this->clientEquipment->lls =  $this->currentRow['lls'];
        $this->clientEquipment->save();
        if ($this->clientEquipment->errors){
            AbstractModel::$errors[] = $this->clientEquipment->errors;
        }
    }

//    private function setStatus()
//    {
//        if (!empty($this->currentRow['']))
//            $this->clientEquipment->status = $this->currentRow[''];
//    }
}