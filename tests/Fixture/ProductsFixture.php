<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * ProductsFixture
 */
class ProductsFixture extends TestFixture
{
    /**
     * Init method
     *
     * @return void
     */
    public function init(): void
    {
        $this->records = [
            [
                'id' => 1,
                'name' => 'Lorem ipsum dolor sit amet',
                'description' => 'Lorem ipsum dolor sit amet',
                'pricing' => 1.5,
                'image_path' => 'Lorem ipsum dolor sit amet',
                'stock' => 1,
                'category' => 'Lorem ipsum dolor sit amet',
                'discount' => 1,
            ],
        ];
        parent::init();
    }
}
