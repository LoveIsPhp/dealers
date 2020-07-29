<?php


namespace app\modules\dealers\core;


interface ServiceInterface
{
    public function export(AbstractExport $export);//getting data from a file
    public function prepare(AbstractPreparation $preparation,AbstractData $abstractData);//preparing data for import
    public function import(AbstractImport $import);//for saving data in a database
}