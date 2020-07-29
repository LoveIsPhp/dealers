<?php


namespace app\modules\dealers\common;


use app\modules\dealers\core\AbstractData;

class Contacts extends AbstractData
{
    /** @var array */
    private $contacts = [];
    /** @var */
    private $currentRow;

    public function getPreparedData()
    {
        $this->removeHeaderColumns();
        foreach ($this->data as $row) {
            $this->setCurrentRow($row)->setContacts();
        }
        return $this->contacts;
    }

    private function setCurrentRow($row)
    {
        $this->currentRow = $row;
        return $this;
    }

    private function setContacts()
    {
        $contact = [];
        foreach ($this->bitrixUserFields as $fieldName => $fieldValue) {
            if (isset($this->currentRow[$fieldValue])) {
                if ($fieldName == 'WORK_COMPANY') {
                    $contact[$fieldName] = $this->str_substract('Accounts::::', $this->currentRow[$fieldValue]);
                } else {
                    $contact[$fieldName] = $this->currentRow[$fieldValue];
                }
            }
        }
        $this->contacts[] = $contact;
        return $this;
    }

    private function str_substract($remove, $subject){
        $strpos = strpos($subject, $remove);
        return substr($subject, 0, $strpos) . substr($subject, $strpos + strlen($remove));
    }

    private function removeHeaderColumns()
    {
        array_shift($this->data);
        return $this;
    }
}