<?php

namespace app\modules\dealers\helper;

use yii\helpers\Console;

trait ProgressBarTrait
{
    /** @var */
    protected $count;
    /** @var int */
    protected $counter = 1;

    /**
     * @param $array
     * @return $this
     */
    protected function startProgressBarByUsingArray($array)
    {
        $this->setCount($array);
        Console::startProgress(0, $this->count);
        //return $this;
    }

    /**
     * @return $this
     */
    protected function updateProgressBar()
    {
        usleep(100);
        Console::updateProgress($this->counter, $this->count);
        $this->counter++;
        //return $this;
    }

    /**
     * @return $this
     */
    protected function finishProgressBar()
    {
        Console::endProgress();
        //return $this;
    }

    /**
     * @param $array
     * @return bool
     */
    protected function setCount($array)
    {
        if (empty($array)) {
            return false;
        } else {
            $this->count = count($array);
            return true;
        }
    }
}