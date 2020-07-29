<?php


namespace app\modules\dealers\core;

use app\modules\dealers\common\Actives;

abstract class AbstractImportModule implements ServiceInterface
{
    /** @var */
    private $fileContent;
    /** @var */
    private $preparedData;

    public function export(AbstractExport $export)
    {
        $this->fileContent = $export->getFileContent();
        return $this;
    }

    public function prepare(AbstractPreparation $preparation,AbstractData $abstractData)
    {
        $data = $this->fileContent;
        if (!empty($data)) {
            $this->preparedData = $preparation->setData($data)->prepareData($abstractData)->getPreparedData();
        }
        return $this;
    }

    public function import(AbstractImport $import)
    {
        $import->setData($this->preparedData)->import();
    }
}