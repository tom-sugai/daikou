<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\CsvstoresTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\CsvstoresTable Test Case
 */
class CsvstoresTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\CsvstoresTable
     */
    protected $Csvstores;

    /**
     * Fixtures
     *
     * @var array<string>
     */
    protected $fixtures = [
        'app.Csvstores',
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
        $config = $this->getTableLocator()->exists('Csvstores') ? [] : ['className' => CsvstoresTable::class];
        $this->Csvstores = $this->getTableLocator()->get('Csvstores', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    protected function tearDown(): void
    {
        unset($this->Csvstores);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @uses \App\Model\Table\CsvstoresTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     * @uses \App\Model\Table\CsvstoresTable::buildRules()
     */
    public function testBuildRules(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
