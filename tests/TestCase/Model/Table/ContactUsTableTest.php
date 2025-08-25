<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\ContactUsTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\ContactUsTable Test Case
 */
class ContactUsTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\ContactUsTable
     */
    protected $ContactUs;

    /**
     * Fixtures
     *
     * @var list<string>
     */
    protected array $fixtures = [
        'app.ContactUs',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('ContactUs') ? [] : ['className' => ContactUsTable::class];
        $this->ContactUs = $this->getTableLocator()->get('ContactUs', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    protected function tearDown(): void
    {
        unset($this->ContactUs);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @link \App\Model\Table\ContactUsTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
