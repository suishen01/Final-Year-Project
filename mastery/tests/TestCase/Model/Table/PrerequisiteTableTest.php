<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\PrerequisiteTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\PrerequisiteTable Test Case
 */
class PrerequisiteTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\PrerequisiteTable
     */
    public $Prerequisite;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.prerequisite',
        'app.quiz',
        'app.course',
        'app.enrollment',
        'app.user',
        'app.marks',
        'app.question'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('Prerequisite') ? [] : ['className' => PrerequisiteTable::class];
        $this->Prerequisite = TableRegistry::get('Prerequisite', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Prerequisite);

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
