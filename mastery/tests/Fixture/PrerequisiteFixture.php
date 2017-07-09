<?php
namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * PrerequisiteFixture
 *
 */
class PrerequisiteFixture extends TestFixture
{

    /**
     * Table name
     *
     * @var string
     */
    public $table = 'prerequisite';

    /**
     * Fields
     *
     * @var array
     */
    // @codingStandardsIgnoreStart
    public $fields = [
        'id' => ['type' => 'integer', 'length' => 10, 'unsigned' => true, 'null' => false, 'default' => null, 'comment' => '', 'autoIncrement' => true, 'precision' => null],
        'pre_id' => ['type' => 'integer', 'length' => 10, 'unsigned' => true, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'quiz_id' => ['type' => 'integer', 'length' => 10, 'unsigned' => true, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        '_indexes' => [
            'pre_ind' => ['type' => 'index', 'columns' => ['pre_id'], 'length' => []],
            'quiz_ind' => ['type' => 'index', 'columns' => ['quiz_id'], 'length' => []],
        ],
        '_constraints' => [
            'primary' => ['type' => 'primary', 'columns' => ['id'], 'length' => []],
            'fk_pre' => ['type' => 'foreign', 'columns' => ['pre_id'], 'references' => ['quiz', 'id'], 'update' => 'cascade', 'delete' => 'cascade', 'length' => []],
            'fk_quiz3' => ['type' => 'foreign', 'columns' => ['quiz_id'], 'references' => ['quiz', 'id'], 'update' => 'cascade', 'delete' => 'cascade', 'length' => []],
        ],
        '_options' => [
            'engine' => 'InnoDB',
            'collation' => 'latin1_swedish_ci'
        ],
    ];
    // @codingStandardsIgnoreEnd

    /**
     * Records
     *
     * @var array
     */
    public $records = [
        [
            'id' => 1,
            'pre_id' => 1,
            'quiz_id' => 1
        ],
    ];
}
