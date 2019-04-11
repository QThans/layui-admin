<?php

use think\migration\Migrator;
use think\migration\db\Column;
use Phinx\Db\Adapter\MysqlAdapter;

class AuthGroupAccess extends Migrator
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
        $table = $this->table('auth_group_access');
        $table->addColumn('user_id', 'integer', array('limit' => MysqlAdapter::INT_REGULAR,'default' => 0,'null' => false))
            ->addColumn('group_id', 'char', array('limit' => 100))
            ->addIndex(['user_id'], array('unique' => false))
            ->addIndex(['group_id'], array('unique' => false))
            ->addIndex(['user_id','group_id'], array('unique' => true,'name'=>'uid_group_id'))
            ->create();
    }

}
