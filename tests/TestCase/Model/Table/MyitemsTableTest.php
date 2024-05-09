<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\MyitemsTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\MyitemsTable Test Case
 */
class MyitemsTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\MyitemsTable
     */
    protected $Myitems;

    /**
     * Fixtures
     *
     * @var array<string>
     */
    protected $fixtures = [
        'app.Myitems',
        'app.Users',
        'app.Products',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('Myitems') ? [] : ['className' => MyitemsTable::class];
        $this->Myitems = $this->getTableLocator()->get('Myitems', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    protected function tearDown(): void
    {
        unset($this->Myitems);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @uses \App\Model\Table\MyitemsTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     * @uses \App\Model\Table\MyitemsTable::buildRules()
     */
    public function testBuildRules(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
