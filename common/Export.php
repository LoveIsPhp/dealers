<?php

namespace app\modules\dealers\common;

use app\modules\dealers\core\AbstractExport;

class Export extends AbstractExport
{
    public function __construct($filePath)
    {
        parent::__construct($filePath);
    }
}