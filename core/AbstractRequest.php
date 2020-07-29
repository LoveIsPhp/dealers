<?php


namespace app\modules\dealers\core;


use app\exceptions\SearchException;
use app\models\bitrix24\RefreshToken;
use app\models\bitrix24\Sender;
use app\models\dealer\Dealer;
use Bitrix24\Bitrix24;

class AbstractRequest
{
    /** @var */
    protected $bitrix;
    /** @var */
    private $sender;
    /** @var */
    private $dealer;

    public function __construct()
    {
        $this->setBitrix();
    }

    private function setBitrix()
    {
        $this->sender = new Sender();

        if (!$this->dealer = Dealer::find()->where(['bitrix_crm_domain' => 'demo-dealer.bitrix24.ru'])->one()) {
            throw new SearchException('Not found dealer_crm_domain');
        }
        (new RefreshToken($this->sender, $this->dealer))->run();

        $this->bitrix = new Bitrix24();
        $setting = $this->dealer->dealerApplicationSetting;
        $scope = explode(',', $setting->application_scope);
        $this->bitrix->setApplicationScope($scope);
        $this->bitrix->setApplicationId($setting->application_id);
        $this->bitrix->setApplicationSecret($setting->application_secret);

        $this->bitrix->setDomain($this->dealer->bitrix_crm_domain);
        $this->bitrix->setMemberId($this->dealer->member_id);
        $this->bitrix->setAccessToken($this->dealer->auth_id);
        $this->bitrix->setRefreshToken($this->dealer->refresh_id);
    }
}