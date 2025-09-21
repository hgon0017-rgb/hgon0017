<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * OrdersFixture
 */
class OrdersFixture extends TestFixture
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
                'user_id' => 1,
                'subtotal' => 1.5,
                'shipping' => 1.5,
                'discount' => 1.5,
                'total' => 1.5,
                'status' => 'Lorem ipsum dolor sit amet',
                'created' => '2025-09-21 15:09:08',
                'modified' => '2025-09-21 15:09:08',
            ],
        ];
        parent::init();
    }
}
