<?php


namespace app\modules\dealers\core;


use yii\base\Exception;
use Yii;
use yii\helpers\FileHelper;

/**
 * Class AbstractExport
 * @package app\modules\dealers\core
 */
abstract class AbstractExport
{
    /** @var */
    private $filePath;
    /** @var  */
    private $fileContent;

    /**
     * AbstractExport constructor.
     * @param $filePath
     * @throws Exception
     */
    public function __construct($filePath)
    {
        $this->setFilePath($filePath)->setFileContent();
    }

    /**
     * @return mixed
     */
    public function getFileContent()
    {
        return $this->fileContent;
    }

    /**
     * @param $string
     * @return $this
     * @throws Exception
     */
    private function setFilePath($string)
    {
        //когда обращаемся через консоль
        if (Yii::$app instanceof \yii\console\Application) {
            $string = FileHelper::normalizePath($string);
            $path = $string;
            if (file_exists($path)) { //Если файл существует
                $this->filePath = $path; //Записываем путь к файлу в переменную
            } else { //Если файл не найден то вызываем исключение
                throw new Exception("Файл " . $path . " не найден");
            }
        }
        return $this;
    }

    /**
     * @return $this
     */
    private function setFileContent()
    {
        $handle = fopen($this->filePath, "r"); //Открываем csv для чтения
        $array_line_full = array(); //Массив будет хранить данные из csv
        //Проходим весь csv-файл, и читаем построчно. 3-ий параметр разделитель поля
        while (($line = fgetcsv($handle, 0, ";")) !== FALSE) {
            $line = array_map(function ($val) {
                return iconv('cp1251', 'utf-8', $val);
            }, $line);
            $array_line_full[] = $line; //Записываем строчки в массив
        }
        fclose($handle); //Закрываем файл
        $this->fileContent = $array_line_full; //Возвращаем прочтенные данные
        return $this;
    }
}