<?php


namespace app\modules\dealers\common;

use app\models\bitrix24\Sender;
use app\models\dealer\Dealer;
use app\modules\dealers\core\AbstractImport;
use app\exceptions\SearchException;
use app\models\bitrix24\RefreshToken;
use app\modules\dealers\helper\ProgressBarTrait;
use Bitrix24\Bitrix24;
use Yii;

class ImportContacts extends AbstractImport
{
    use ProgressBarTrait;
    /** @var */
    private $sender;
    /** @var */
    private $dealer;

    public function import()
    {
        if (!empty($this->data)) {
            $this->startProgressBarByUsingArray($this->data);
            foreach ($this->data as $row) {
                $this->updateProgressBar();
                $this->currentRow = $row;
                $this->setRequest();
            }
            $this->finishProgressBar();
        }
    }

    public function setRequest()
    {
        $this->sender = new Sender();

        if (!$this->dealer = Dealer::find()->where(['bitrix_crm_domain' => 'demo-dealer.bitrix24.ru'])->one()) {
            throw new SearchException('Not found dealer_crm_domain');
        }
        (new RefreshToken($this->sender, $this->dealer))->run();

        $obB24App = new Bitrix24();
        $setting = $this->dealer->dealerApplicationSetting;
        $scope = explode(',', $setting->application_scope);
        $obB24App->setApplicationScope($scope);
        $obB24App->setApplicationId($setting->application_id);
        $obB24App->setApplicationSecret($setting->application_secret);

        $obB24App->setDomain($this->dealer->bitrix_crm_domain);
        $obB24App->setMemberId($this->dealer->member_id);
        $obB24App->setAccessToken($this->dealer->auth_id);
        $obB24App->setRefreshToken($this->dealer->refresh_id);


        $obB24App->call("crm.contact.add", ['fields' => $this->currentRow]);
        if (!empty($this->currentRow['WORK_COMPANY'])) {
            $userId = json_decode($obB24App->getRawResponse())->result;
            $obB24App->call("crm.company.list",
                [
                    "filter" => ['TITLE' => $this->currentRow['WORK_COMPANY']],
                    'select' => ['id']
                ]
            );
            $result = $obB24App->getRawResponse();
            if (isset(json_decode($result)->result[0])) {
                $companyId = json_decode($result)->result[0]->ID;

                $obB24App->call("crm.contact.company.add", [
                    'id' => $userId,
                    'fields' => [
                        'COMPANY_ID' => $companyId,
                    ]
                ]);
            }
        }
    }
}