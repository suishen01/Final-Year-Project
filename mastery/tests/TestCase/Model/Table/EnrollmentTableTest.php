<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\EnrollmentTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\EnrollmentTable Test Case
 */
class EnrollmentTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\EnrollmentTable
     */
    public $Enrollment;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.enrollment',
        'app.users',
        'app.marks',
        'app.courses',
        'app.tests',
        'app.prerequisites'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('Enrollment') ? [] : ['className' => EnrollmentTable::class];
        $this->Enrollment = TableRegistry::get('Enrollment', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Enrollment);

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
