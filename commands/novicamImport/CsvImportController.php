<?php

namespace app\commands\novicamImport;

use app\modules\catalog\models\Category;
use app\modules\catalog\models\Images;
use app\modules\catalog\models\Product;
use app\modules\catalog\models\ProductOptions;
use app\modules\catalog\models\ProductVariant;
use yii\console\Controller;
use yii\console\ExitCode;

/**
 * @param $categoriesBase Category[]
 * */
class CsvImportController extends Controller
{
    const DESCRIPTION_OPTION = 'Полное описание';
    const IMPORT_FOLDER    = 'novicamImport/';
    const IMAGES_FOLDER    = 'images/novicam/';

    protected $catalogFileName = 'novi_trade.csv';
    protected $categoriesBase  = [];
    protected $categories      = [];
    protected $imageFolder = '';

    public function actionIndex()
    {
        \Yii::setAlias('@novicamImport', '@runtime/' . static::IMPORT_FOLDER);
        \Yii::setAlias('@novicamImages', '@app/web/' . static::IMAGES_FOLDER);

        $this->imageFolder = \Yii::getAlias('@novicamImages');

        if (!file_exists($this->imageFolder) || !is_dir($this->imageFolder)) {
            mkdir($this->imageFolder, 0777, true);
        }

        if ((new UploadCatalogs($this->catalogFileName))->upload()) {
            print "\nstart parse\n";
        } else {
            print "\nupload error\n";
        }

        $pathToFile = \Yii::getAlias('@novicamImport') . $this->catalogFileName;

        if (($handle = fopen($pathToFile, 'r')) === false) {
            print "\nИмпорт товаров завершён с ошибкой\n";
        }

        $i = 0;

        while (($row = fgetcsv($handle, 10000, ";")) !== false) {
            if ($i !== 0) {
                /** Импортируем товар */
                $this->importProduct($row);
            }

            $i++;
        }

        fclose($handle);

        print "\nИмпорт товаров завершён\n";
        print "\nВсего товаров импортировано - $i\n";

        return ExitCode::OK;
    }

    /**
     * @param ProductVariant $variant
     * @param array $images
     */
    protected function importImages($variant, $images)
    {
        $general = 1;

        $images = explode(',', $images);

        foreach ($images as $image) {
            $image = trim($image);
            $image = str_replace('/cache/', '/', $image);
            $image = str_replace('-500x500.', '.', $image);

            $path = md5($variant->alias);

            $subFolder = substr($path, 0, 2);

            if (!file_exists($this->imageFolder . $subFolder) || !is_dir($this->imageFolder . $subFolder)) {
                mkdir($this->imageFolder . $subFolder, 0777, true);
            }

            $path = $subFolder . "/$path" . strrchr($image, '.');

            $imageBase = Images::find()->findByPath("/images/novicam/$path")->findByVariant($variant->id)->one();

            if (!$imageBase) {
                file_put_contents(
                    $this->imageFolder . $path,
                    file_get_contents($image)
                );

                $imageBase = new Images([
                    'entity'      => 'ProductVariant',
                    'entity_id'   => $variant->id,
                    'general'     => $general,
                    'sort'        => 100,
                    'path'        => "/images/novicam/$path",
                    'title'       => $variant->title,
                ]);
            }

            $imageBase->status = Images::STATUS_ACTIVE;
            $imageBase->save();
            $general = null;
        }
    }

    /**
     * Импорт товаров
     *
     * @param array $product
     */
    protected function importProduct($product)
    {
        $productBase = Product::find()->findByImportPath($product[11])->one();

        if (!$productBase) {
            print 0;
            return;
        }
        print 1;

        $variantBase =  ProductVariant::find()->findByProduct($productBase->id)->one();

        $this->checkOptions($variantBase, $product[8]);

        if (empty($product[9])) {
            return;
        }

        /** Импортируем картинки */
        $this->importImages($variantBase, $product[9]);
    }

    /**
     * @param ProductVariant $variantBase
     * @param array $attributes
     */
    protected function checkOptions($variantBase, $attributes)
    {
        if (empty($attributes)) {
            return;
        }

        $attributes = iconv('cp1251', 'UTF8', $attributes);
        $attributes = explode("\n", $attributes);

        $previewIndex = 0;

        foreach ($attributes as $i => $attribute) {
            if (!strpos($attribute, '|')) {
                $attributes[$previewIndex] = $attributes[$previewIndex] . "\n<br />$attribute";

                unset($attributes[$i]);
            } else {
                $previewIndex = $i;
            }
        }

        $toImport = [];

        foreach ($attributes as $i => $attribute) {
            $attribute = explode('|', $attribute);
            $value = array_pop($attribute);

            $toImport[end($attribute)] = $value;
        }

        foreach ($toImport as $keyOption => $valueOption) {
            if ($keyOption === static::DESCRIPTION_OPTION) {
                $variantBase->description = $valueOption;
                $variantBase->save();

                continue;
            }

            $alias = \app\helpers\Transliteration::transliteration($keyOption);
            $option = ProductOptions::find()->findByVariant($variantBase->id)->findByAlias($alias)->one();

            if (!$option) {
                $this->createOption($variantBase->id, $keyOption, $alias, $valueOption);
            } else {
                $this->updateOption($option);
            }
        }
    }

    /**
     * @param int $variantID
     * @param string $title
     * @param string $alias
     * @param string $value
     */
    protected function createOption($variantID, $title, $alias, $value)
    {
        if (strlen($value) > 250) {
            return;
        }

        $option = new ProductOptions([
            'title'      => $title,
            'alias'      => $alias,
            'sort'       => 100,
            'status'     => ProductOptions::STATUS_ACTIVE,
            'variant_id' => $variantID,
            'value'      => $value,
        ]);

        $option->save();
    }

    /**
     * @param ProductOptions $option
     */
    protected function updateOption($option)
    {
        $option->status = ProductOptions::STATUS_ACTIVE;
        $option->save();
    }
}
