<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\commands\novicamImport;


class UploadCatalogs
{
    const IMPORT_URL =  'http://www.novicam.ru/';
    const IMPORT_FOLDER =  'novicamImport/';

    private $fileName =  '';

    /**
     * UploadCatalogs constructor.
     *
     * @param string $fileName
     */
    public function __construct($fileName)
    {
        $this->fileName = $fileName;

        \Yii::setAlias('@novicamImport', '@runtime/' . static::IMPORT_FOLDER);

        $this->createFolder();
    }

    public function upload()
    {
        $filePath = \Yii::getAlias('@novicamImport') . $this->fileName;

        $result = file_put_contents(
            $filePath,
            file_get_contents(static::IMPORT_URL . $this->fileName)
        );

        if (empty($result)) {
            print "\nПри обновлении файла каьалога произошла ошибка\n";
        } else {
            print "\nФайл каталога обновлён\n";
        }

        return !empty($result);
    }

    protected function createFolder()
    {
        if (!file_exists(\Yii::getAlias('@novicamImport')) || !is_dir(\Yii::getAlias('@novicamImport'))) {
            mkdir(\Yii::getAlias('@novicamImport'), 0777, true);
        }
    }
}
