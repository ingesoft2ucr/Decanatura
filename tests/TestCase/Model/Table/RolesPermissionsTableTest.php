<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\RolesPermissionsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\RolesPermissionsTable Test Case
 */
class RolesPermissionsTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\RolesPermissionsTable
     */
    public $RolesPermissions;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.roles_permissions'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('RolesPermissions') ? [] : ['className' => RolesPermissionsTable::class];
        $this->RolesPermissions = TableRegistry::get('RolesPermissions', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->RolesPermissions);

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
}
