<?php

namespace app\commands\novicamImport;

use app\modules\catalog\models\Category;
use app\modules\catalog\models\Images;
use app\modules\catalog\models\Product;
use app\modules\catalog\models\Product2category;
use app\modules\catalog\models\ProductOptions;
use app\modules\catalog\models\ProductVariant;
use yii\console\Controller;
use yii\console\ExitCode;

/**
 * @param $categoriesBase Category[]
 * */
class XmlImportController extends Controller
{
    const DISABLE_CATEGORY = 'Архив';
    const TRADE_CATALOG    = 1;
    const IMPORT_FOLDER    = 'novicamImport/';
    const IMAGES_FOLDER    = 'images/novicam/';

    protected $catalogFileName = 'novi_trade.xml';
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

//        if ((new UploadCatalogs($this->catalogFileName))->upload()) {
//            print "\nstart parse\n";
//        } else {
//            print "\nupload error\n";
//        }

        $content = simplexml_load_file(\Yii::getAlias('@novicamImport') . $this->catalogFileName);

        $content = json_encode($content);
        $content = json_decode($content, true);

        $this->disableCatalog();

        $this->categoriesBase = Category::find()->indexBy('relation_path')->all();

        /** Импортируем категории */
        $this->importCategories($content['channel']['item']);

        /** Импортируем товары */
        $this->importProducts($content['channel']['item']);

        return ExitCode::OK;
    }

    /**
     * @param ProductVariant $variant
     * @param array $images
     */
    protected function importImages($variant, $images)
    {
        $general = 1;

        foreach ($images as $image) {
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
     * @param array $productsImport
     *
     * @throws \yii\db\Exception
     */
    protected function importProducts($productsImport)
    {
        \Yii::$app->db->createCommand()->truncateTable('product2category')->execute();

        $count = 0;

        foreach ($productsImport as $product) {

            $productBase = $this->getProduct($product);
            $variantBase = $this->getVariant($productBase->id, $product);

            $this->checkOptions($variantBase, $product);

            if (!is_array($product['product_type'])) {
                $product['product_type'] = [$product['product_type']];
            }

            $this->setProductToCategoryRelations($productBase->id, $product['product_type']);
            $count++;

            if (empty($product['image_link'])) {
                continue;
            }

            /** Импортируем картинки */
            $this->importImages($variantBase, $product['image_link']);
        }

        print "\nИмпорт товаров завершён\n";
        print "\nВсего товаров импортировано - $count\n";
    }

    /**
     * @param ProductVariant $variantBase
     * @param array $product
     */
    protected function checkOptions($variantBase, $product)
    {
        if (!empty($product['brand'])) {
            $option = ProductOptions::find()->findByVariant($variantBase->id)->findByAlias('brand')->one();

            if (!$option) {
                $this->createOption($variantBase->id, 'Бренд', 'brand', $product['brand']);
            } else {
                $option->status = ProductOptions::STATUS_ACTIVE;
                $option->save();
            }
        }

        if (!empty($product['art'])) {
            $option = ProductOptions::find()->findByVariant($variantBase->id)->findByAlias('art')->one();

            if (!$option) {
                $this->createOption($variantBase->id, 'Артикул', 'art', $product['art']);
            } else {
                $option->status = ProductOptions::STATUS_ACTIVE;
                $option->save();
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
     * @param array $product
     *
     * @return \app\modules\catalog\models\Product|null
     */
    protected function getProduct($product)
    {
        $productBase = Product::find()->findByImportPath($product['link'])->one();

        if (!$productBase) {
            $productBase = $this->createProduct($product);
        } else {
            $this->updateProduct($productBase, $product);
        }

        return $productBase;
    }

    /**
     * @param $productID
     * @param $product
     *
     * @return \app\modules\catalog\models\ProductVariant|null
     */
    protected function getVariant($productID, $product)
    {
        $variantBase = ProductVariant::find()->findByProduct($productID)->one();

        if (!$variantBase) {
            $variantBase = $this->createVariant($productID, $product);
        } else {
            $this->updateVariant($variantBase, $product);
        }

        return $variantBase;
    }

    /**
     * Деактивируем каталог
     */
    protected function disableCatalog()
    {
        Category::updateAll(['status' => Category::STATUS_DELETE]);
        Product::updateAll(['status' => Product::STATUS_DELETE]);
        ProductVariant::updateAll(['status' => ProductVariant::STATUS_DELETE]);
        ProductOptions::updateAll(['status' => ProductOptions::STATUS_DELETE]);
        Images::updateAll(['status' => Images::STATUS_DELETE]);
    }

    /**
     * @param int $productID
     * @param array $productType
     */
    protected function setProductToCategoryRelations($productID, $productType)
    {
        foreach ($productType as $category) {

            if ($category == static::DISABLE_CATEGORY) {
                continue;
            }

            $product2category = Product2category::find()
                ->findUnique(
                    $this->categoriesBase[$category]->id,
                    $productID
                )->one();

            if (!$product2category) {
                $product2category = new Product2category([
                    'category_id' => $this->categoriesBase[$category]->id,
                    'product_id'  => $productID,
                    'sort'        => 100,
                ]);
                $product2category->save();
            }
        }
    }

    /**
     * @param Product $productBase
     * @param array $product
     */
    protected function updateProduct($productBase, $product)
    {
        $productBase->status = Product::STATUS_ACTIVE;
        $productBase->price = $product['price'];

        $productBase->save();
    }

    /**
     * @param array $product
     *
     * @return \app\modules\catalog\models\Product|null
     */
    protected function createProduct($product)
    {
        $productInsert = new Product([
            'catalog_id'  => static::TRADE_CATALOG,
            'title'       => $product['title'],
            'alias'       => \app\helpers\Transliteration::transliteration($product['title']),
            'sort'        => 100,
            'status'      => Product::STATUS_ACTIVE,
            'price'       => $product['price'],
            'import_path' => $product['link'],
        ]);

        $save = $productInsert->save();

        return $save ? $productInsert : null;
    }

    /**
     * @param ProductVariant $variantBase
     * @param array $product
     */
    protected function updateVariant($variantBase, $product)
    {
        $variantBase->status = ProductVariant::STATUS_ACTIVE;
        $variantBase->price = $product['price'];

        $variantBase->save();
    }

    /**
     * @param int $productID
     * @param array $product
     *
     * @return \app\modules\catalog\models\ProductVariant|null
     */
    protected function createVariant($productID, $product)
    {
        $variantInsert = new ProductVariant([
            'product_id'  => $productID,
            'title'       => $product['title'],
            'alias'       => \app\helpers\Transliteration::transliteration($product['title']),
            'sort'        => 100,
            'status'      => ProductVariant::STATUS_ACTIVE,
            'price'       => $product['price'],
        ]);

        $save = $variantInsert->save();

        return $save ? $variantInsert : null;
    }

    /**
     * Импорт категорий
     *
     * @param array $productsImport
     */
    protected function importCategories($productsImport)
    {
        $categories = [];

        foreach ($productsImport as $product) {

            if (!is_array($product['product_type'])) {
                $product['product_type'] = [$product['product_type']];
            }

            foreach ($product['product_type'] as $item) {

                if ($item == static::DISABLE_CATEGORY) {
                    continue;
                }

                $items = explode(', ', $item);

                $categories[$item] = [
                    'baseID' => null,
                    'item'   => $item,
                    'items'  => $items,
                    'title'  => end($items),
                    'level'  => count($items),
                ];

                $this->findCategory($categories[$item]);
            }
        }

        print "\nИмпорт категорий завершён\n";
    }

    /**
     * Ищем категорию, и если не находим, то создаём новую
     *
     * @param array $category
     *
     * @return \app\modules\catalog\models\Category
     */
    protected function findCategory($category)
    {
        if (!empty($this->categoriesBase[$category['item']])) {

            $category = $this->categoriesBase[$category['item']];
            $this->categoriesBase[$category->relation_path]->status = Category::STATUS_ACTIVE;
            $this->categoriesBase[$category->relation_path]->save();
        } else {

            $category['parent_id'] = 0;

            if ($category['level'] > 1) {

                array_pop($category['items']);
                $items = $category['items'];

                $parentCategory = [
                    'baseID'    => null,
                    'item'      => implode(', ', $items),
                    'items'     => $items,
                    'title'     => end($items),
                    'level'     => count($items),
                    'parent_id' => 0,
                ];

                $parent = $this->findCategory($parentCategory);
                $category['parent_id'] = $parent ? $parent->id : 0;
            }

            if ($categoryBase = $this->createCategory($category)) {
                $category = $this->categoriesBase[$category['item']] = $categoryBase;
            }
        }

        return $category;
    }

    /**
     * Создаём категорию
     *
     * @param array $category
     *
     * @return \app\modules\catalog\models\Category|null
     */
    protected function createCategory($category)
    {
        $categoryInsert = new Category([
            'catalog_id'        => static::TRADE_CATALOG,
            'title'             => $category['title'],
            'alias'             => \app\helpers\Transliteration::transliteration($category['title']),
            'relation_path'     => $category['item'],
            'sort'              => 100,
            'parent_id'         => $category['parent_id'],
            'level'             => $category['level'],
            'status'            => Category::STATUS_ACTIVE,
            'description_short' => null,
            'description'       => null,
        ]);

        $save = $categoryInsert->save();

        return $save ? $categoryInsert : null;
    }
}
