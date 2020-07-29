<?php


namespace app\modules\dealers\common;

use app\models\ClientEquipment;
use app\modules\dealers\core\AbstractData;

class Actives extends AbstractData
{
    /** @var array */
    private $actives = [];
    /** @var */
    private $currentRow;
    /** @var int */
    private $productName = 16;
    /** @var int */
    private $categoryName = 17;
    /** @var int */
    private $client = 22;
    /** @var int */
    private $carStateNumber = 32;
    /** @var int */
    private $model = 39;
    /** @var int */
    private $mark = 37;
    /** @var int */
    private $status = 5;
    /** @var int */
    private $id_auto_graph = 8;
    /** @var int */
    private $serial_number = 24;
    /** @var int */
    private $imei = 26;
    /** @var int */
    private $start_at = 28;
//    private $installation_at = ;
    /** @var int */
    private $availability = 27;
    /** @var int */
    private $date_of_last_calibration = 1;
    /** @var int */
    private $active_number = 2;
    /** @var int */
    private $external_id = 3;
    /** @var int */
    private $status_subscribtion = 4;
    /** @var int */
    private $soft_group = 6;
    /** @var int */
    private $server = 7;
    /** @var int */
    private $sim1 = 9;
    /** @var int */
    private $password = 10;
    /** @var int */
    private $sim2 = 11;
    /** @var int */
    private $sms_password = 12;
    /** @var int */
    private $iccid1 = 13;
    /** @var int */
    private $lock_password = 14;
    /** @var int */
    private $iccid2 = 15;
    /** @var int */
    private $driver_card = 29;
    /** @var int */
    private $comment = 31;
    /** @var int */
    private $lls = 41;
    /** @var int  */
    private $vin = 34;
    /** @var int  */
    private $extra_desc = 40;
    /** @var int  */
    private $tank_capacity = 42;
    /** @var int  */
    private $dut = 43;

    public function getPreparedData()
    {
        $this->removeHeaderColumns();
        foreach ($this->data as $row) {
            $this->setCurrentRow($row)->setActives();
        }
        return $this->actives;
    }

    private function setCurrentRow($row)
    {
        $this->currentRow = $row;
        return $this;
    }

    private function setActives()
    {
        if (isset($this->currentRow[$this->productName]) and isset($this->currentRow[$this->categoryName])) {
            $productName = $this->currentRow[$this->productName];
            $categoryName = $this->currentRow[$this->categoryName];
            $client = $this->currentRow[$this->client];
            if (!empty($this->currentRow[$this->carStateNumber])) {
                $carStateNumber = $this->currentRow[$this->carStateNumber];
                if (!isset($this->currentRow[$this->model]) or empty($this->currentRow[$this->model])) {
                    $model = 'Другое';
                } else {
                    $model = $this->currentRow[$this->model];
                }

                if (!isset($this->currentRow[$this->mark]) or empty($this->currentRow[$this->mark])) {
                    $mark = 'Неопределено';
                } else {
                    $mark = $this->currentRow[$this->mark];
                }

                if (!isset($this->currentRow[$this->status]) or empty($this->currentRow[$this->status])) {
                    $status = null;
                } else {
                    switch ($this->currentRow[$this->status]) {
                        case 'Отключен':
                            $status = ClientEquipment::STATUS_DISABLED;
                            break;
                        case 'Активный':
                            $status = ClientEquipment::STATUS_ACTIVE;
                            break;
                        case 'Приостановлен':
                            $status = ClientEquipment::STATUS_HOLD;
                            break;
                        default:
                            $status = null;
                    }
                }

                if (!isset($this->currentRow[$this->status]) or empty($this->currentRow[$this->status])) {
                    $id_auto_graph = null;
                } else {
                    $id_auto_graph = $this->currentRow[$this->id_auto_graph];
                }

                if (!isset($this->currentRow[$this->serial_number]) or empty($this->currentRow[$this->serial_number])) {
                    $serial_number = null;
                } else {
                    $serial_number = $this->currentRow[$this->serial_number];
                }

                if (!isset($this->currentRow[$this->imei]) or empty($this->currentRow[$this->imei])) {
                    $imei = null;
                } else {
                    $imei = $this->currentRow[$this->imei];
                }

                if (!isset($this->currentRow[$this->start_at]) or empty($this->currentRow[$this->start_at])) {
                    $start_at = null;
                } else {
                    $start_at = $this->currentRow[$this->start_at];
                }

                if (!isset($this->currentRow[$this->availability]) or empty($this->currentRow[$this->availability])) {
                    $availability = null;
                } else {
                    $availability = $this->currentRow[$this->availability];
                }

                if (!isset($this->currentRow[$this->date_of_last_calibration]) or empty($this->currentRow[$this->date_of_last_calibration])) {
                    $date_of_last_calibration = null;
                } else {
                    $date_of_last_calibration = $this->currentRow[$this->date_of_last_calibration];
                }

                if (!isset($this->currentRow[$this->active_number]) or empty($this->currentRow[$this->active_number])) {
                    $active_number = null;
                } else {
                    $active_number = $this->currentRow[$this->active_number];
                }

                if (!isset($this->currentRow[$this->external_id]) or empty($this->currentRow[$this->external_id])) {
                    $external_id = null;
                } else {
                    $external_id = $this->currentRow[$this->external_id];
                }

                if (!isset($this->currentRow[$this->status_subscribtion]) or empty($this->currentRow[$this->status_subscribtion])) {
                    $status_subscribtion = null;
                } else {
                    $status_subscribtion = $this->currentRow[$this->status_subscribtion];
                }

                if (!isset($this->currentRow[$this->soft_group]) or empty($this->currentRow[$this->soft_group])) {
                    $soft_group = null;
                } else {
                    $soft_group = $this->currentRow[$this->soft_group];
                }

                if (!isset($this->currentRow[$this->server]) or empty($this->currentRow[$this->server])) {
                    $server = null;
                } else {
                    $server = $this->currentRow[$this->server];
                }

                if (!isset($this->currentRow[$this->sim1]) or empty($this->currentRow[$this->sim1])) {
                    $sim1 = null;
                } else {
                    $sim1 = $this->currentRow[$this->sim1];
                }

                if (!isset($this->currentRow[$this->password]) or empty($this->currentRow[$this->password])) {
                    $password = null;
                } else {
                    $password = $this->currentRow[$this->password];
                }

                if (!isset($this->currentRow[$this->sim2]) or empty($this->currentRow[$this->sim2])) {
                    $sim2 = null;
                } else {
                    $sim2 = $this->currentRow[$this->sim2];
                }

                if (!isset($this->currentRow[$this->sms_password]) or empty($this->currentRow[$this->sms_password])) {
                    $sms_password = null;
                } else {
                    $sms_password = $this->currentRow[$this->sms_password];
                }

                if (!isset($this->currentRow[$this->iccid1]) or empty($this->currentRow[$this->iccid1])) {
                    $iccid1 = null;
                } else {
                    $iccid1 = $this->currentRow[$this->iccid1];
                }

                if (!isset($this->currentRow[$this->lock_password]) or empty($this->currentRow[$this->lock_password])) {
                    $lock_password = null;
                } else {
                    $lock_password = $this->currentRow[$this->lock_password];
                }

                if (!isset($this->currentRow[$this->iccid2]) or empty($this->currentRow[$this->iccid2])) {
                    $iccid2 = null;
                } else {
                    $iccid2 = $this->currentRow[$this->iccid2];
                }

                if (!isset($this->currentRow[$this->driver_card]) or empty($this->currentRow[$this->driver_card])) {
                    $driver_card = null;
                } else {
                    $driver_card = $this->currentRow[$this->driver_card];
                }

                if (!isset($this->currentRow[$this->comment]) or empty($this->currentRow[$this->comment])) {
                    $comment = null;
                } else {
                    $comment = $this->currentRow[$this->comment];
                }

                if (!isset($this->currentRow[$this->lls]) or empty($this->currentRow[$this->lls])) {
                    $lls = null;
                } else {
                    $lls = $this->currentRow[$this->lls];
                }

                if (!isset($this->currentRow[$this->vin]) or empty($this->currentRow[$this->vin])) {
                    $vin = null;
                } else {
                    $vin = $this->currentRow[$this->vin];
                }

                if (!isset($this->currentRow[$this->extra_desc]) or empty($this->currentRow[$this->extra_desc])) {
                    $extra_desc = null;
                } else {
                    $extra_desc = $this->currentRow[$this->extra_desc];
                }

                if (!isset($this->currentRow[$this->tank_capacity]) or empty($this->currentRow[$this->tank_capacity])) {
                    $tank_capacity = null;
                } else {
                    $tank_capacity = $this->currentRow[$this->tank_capacity];
                }

                if (!isset($this->currentRow[$this->dut]) or empty($this->currentRow[$this->dut])) {
                    $dut = null;
                } else {
                    $dut = $this->currentRow[$this->dut];
                }

                $this->actives[] = [
                    'productName' => $productName,
                    'categoryName' => $categoryName,
                    'client' => $this->str_substract('Accounts::::', $client),
                    'carStateNumber' => $carStateNumber,
                    'model' => $model,
                    'mark' => $mark,
                    'status' => $status,
                    'id_auto_graph' => $id_auto_graph,
                    'installation_at' => null,
                    'serial_number' => $serial_number,
                    'imei' => $imei,
                    'start_at' => $start_at,
                    'availability' => $availability,
                    'date_of_last_calibration' => $date_of_last_calibration,
                    'active_number' => $active_number,
                    'external_id' => $external_id,
                    'status_subscribtion' => $status_subscribtion,
                    'soft_group' => $soft_group,
                    'server' => $server,
                    'sim1' => $sim1,
                    'password' => $password,
                    'sim2' => $sim2,
                    'sms_password' => $sms_password,
                    'iccid1' => $iccid1,
                    'lock_password' => $lock_password,
                    'iccid2' => $iccid2,
                    'driver_card' => $driver_card,
                    'comment' => $comment,
                    'lls' => $lls,
                    'vin' => $vin,
                    'extra_desc' => $extra_desc,
                    'tank_capacity' => $tank_capacity,
                    'dut' => $dut,
                ];
            } else {
                $this->actives[] = [
                    'productName' => $productName,
                    'categoryName' => $categoryName,
                    'client' => $this->str_substract('Accounts::::', $client),
                ];
            }
        }
    }

    private function removeHeaderColumns()
    {
        array_shift($this->data);
    }

    private function str_substract($remove, $subject)
    {
        $strpos = strpos($subject, $remove);
        return substr($subject, 0, $strpos) . substr($subject, $strpos + strlen($remove));
    }
}