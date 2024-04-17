<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\CsvstoreTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\CsvstoreTable Test Case
 */
class CsvstoreTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\CsvstoreTable
     */
    protected $Csvstore;

    /**
     * Fixtures
     *
     * @var array<string>
     */
    protected $fixtures = [
        'app.Csvstore',
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
        $config = $this->getTableLocator()->exists('Csvstore') ? [] : ['className' => CsvstoreTable::class];
        $this->Csvstore = $this->getTableLocator()->get('Csvstore', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    protected function tearDown(): void
    {
        unset($this->Csvstore);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @uses \App\Model\Table\CsvstoreTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     * @uses \App\Model\Table\CsvstoreTable::buildRules()
     */
    public function testBuildRules(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
