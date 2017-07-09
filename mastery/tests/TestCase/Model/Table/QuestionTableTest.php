<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\QuestionTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\QuestionTable Test Case
 */
class QuestionTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\QuestionTable
     */
    public $Question;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.question',
        'app.quiz'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('Question') ? [] : ['className' => QuestionTable::class];
        $this->Question = TableRegistry::get('Question', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Question);

        parent::tearDown();
    }

    /**
     * Test initialize method
     *
     * @return void
     */
    public function testInitialize()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test validationDefault method
     *
     * @return void
     */
    public function testValidationDefault()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     */
    public function testBuildRules()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
