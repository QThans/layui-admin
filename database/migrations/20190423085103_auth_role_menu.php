<?php

use Phinx\Db\Adapter\MysqlAdapter;
use think\migration\Migrator;
use think\migration\db\Column;

class AuthRoleMenu extends Migrator
{
    /**
     * Change Method.
     *
     * Write your reversible migrations using this method.
     *
     * More information on writing migrations is available here:
     * http://docs.phinx.org/en/latest/migrations.html#the-abstractmigration-class
     *
     * The following commands can be used in this method and Phinx will
     * automatically reverse them when rolling back:
     *
     *    createTable
     *    renameTable
     *    addColumn
     *    renameColumn
     *    addIndex
     *    addForeignKey
     *
     * Remember to call "create()" or "update()" and NOT "save()" when working
     * with the Table class.
     */
    public function change()
    {
        $table = $this->table('auth_role_menu',array('id'=>false));

        $table->addColumn('role_id', 'integer', array('limit' => MysqlAdapter::INT_REGULAR))
            ->addColumn('menu_id', 'integer', array('limit' => MysqlAdapter::INT_REGULAR))
            ->addColumn('create_time', 'integer', ['limit' => MysqlAdapter::INT_REGULAR,'default'=>0])
            ->addColumn('update_time', 'integer', ['limit' => MysqlAdapter::INT_REGULAR,'default'=>0])
            ->addIndex(['role_id'], array('unique' => false))
            ->addIndex(['menu_id'], array('unique' => false))
            ->create();
    }
}
