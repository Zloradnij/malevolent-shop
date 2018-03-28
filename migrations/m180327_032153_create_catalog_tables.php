<?php

use yii\db\Migration;

/**
 * Handles the creation of tables catalog module.
 */
class m180327_032153_create_catalog_tables extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $tableOptions = null;

        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';
        }

        $this->createTable('catalog', [
            'id'          => $this->primaryKey(),
            'title'       => $this->string(200)->notNull(),
            'alias'       => $this->string(200)->notNull(),
            'sort'        => $this->integer(10)->null()->unsigned(),
            'status'      => $this->tinyInteger(2)->notNull(),
            'description' => $this->text()->null(),
        ], $tableOptions);

        $this->insert('catalog', [
            'title'       => 'Торговый каталог',
            'alias'       => 'Trade Directory',
            'sort'        => 100,
            'status'      => 10,
            'description' => 'Каталог, который будет участвовать в продаже',
        ]);

        $this->createTable('category', [
            'id'                => $this->primaryKey(),
            'catalog_id'        => $this->integer(10)->unsigned(),
            'title'             => $this->string(250)->notNull(),
            'alias'             => $this->string(250)->notNull(),
            'sort'              => $this->integer(10)->null()->unsigned(),
            'parent_id'         => $this->integer(11)->null()->unsigned(),
            'level'             => $this->integer(10)->defaultValue(1)->null()->unsigned(),
            'status'            => $this->tinyInteger(2)->notNull(),
            'description_short' => $this->text()->null(),
            'description'       => $this->text()->null(),
        ], $tableOptions);

        $this->createIndex('idx-category-catalog_id', 'category', 'catalog_id');

        $this->createTable('product', [
            'id'                => $this->primaryKey(),
            'catalog_id'        => $this->integer(10)->unsigned(),
            'title'             => $this->string(250)->notNull(),
            'alias'             => $this->string(250)->notNull(),
            'sort'              => $this->integer(10)->null()->unsigned(),
            'status'            => $this->tinyInteger(2)->notNull(),
            'price'             => $this->float(2)->defaultValue(0),
            'description_short' => $this->text()->null(),
            'description'       => $this->text()->null(),
        ], $tableOptions);

        $this->createIndex('idx-product-catalog_id', 'product', 'catalog_id');

        $this->createTable('product_variant', [
            'id'                => $this->primaryKey(),
            'title'             => $this->string(250)->notNull(),
            'alias'             => $this->string(250)->notNull(),
            'sort'              => $this->integer(10)->null()->unsigned(),
            'status'            => $this->tinyInteger(2)->notNull(),
            'product_id'        => $this->integer(10)->notNull()->unsigned(),
            'price'             => $this->float(2)->defaultValue(0),
            'description_short' => $this->text()->null(),
            'description'       => $this->text()->null(),
        ], $tableOptions);

        $this->createIndex('idx-product_variant-product_id', 'product_variant', 'product_id');

        $this->createTable('product2category', [
            'id'          => $this->primaryKey(),
            'category_id' => $this->integer(10)->notNull()->unsigned(),
            'product_id'  => $this->integer(10)->notNull()->unsigned(),
            'sort'        => $this->integer(10)->null()->unsigned(),
        ], $tableOptions);

        $this->createIndex('idx-product2category-category_id', 'product2category', 'category_id');
        $this->createIndex('idx-product2category-product_id', 'product2category', 'product_id');

        $this->createTable('images', [
            'id'          => $this->primaryKey(),
            'entity'      => $this->string(50)->notNull(),
            'entity_id'   => $this->integer(12)->notNull()->unsigned(),
            'general'     => $this->tinyInteger(1)->null()->unsigned(),
            'sort'        => $this->integer(10)->null()->unsigned(),
            'status'      => $this->tinyInteger(2)->notNull(),
            'path'        => $this->string(250)->null(),
            'title'       => $this->string(250)->null(),
            'description' => $this->text()->null(),
        ], $tableOptions);

        $this->createIndex('idx-images-entity_id', 'images', 'entity_id');

        $this->createTable('catalog_settings', [
            'id'          => $this->primaryKey(),
            'title'       => $this->string(250)->notNull(),
            'alias'       => $this->string(100)->notNull(),
            'value'       => $this->string(250)->notNull(),
            'description' => $this->text()->null(),
            'status'      => $this->tinyInteger(2)->notNull(),
        ], $tableOptions);

        $this->insert('catalog_settings', [
            'title'       => 'Продавать варианты товара',
            'alias'       => 'saleVariants',
            'value'       => '0',
            'description' => '',
            'status'      => 10,
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('catalog_settings');
        $this->dropTable('images');
        $this->dropTable('product2category');
        $this->dropTable('product_variant');
        $this->dropTable('product');
        $this->dropTable('category');
        $this->dropTable('catalog');
    }
}
