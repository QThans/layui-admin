<?php

use Phinx\Db\Adapter\MysqlAdapter;
use think\migration\Migrator;
use think\migration\db\Column;

class AuthRole extends Migrator
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
        $table = $this->table('auth_role');

        $table->addColumn('name', 'string', array('limit' => 100))
            ->addColumn('alias', 'string', array('limit' => 20))
            ->addColumn('status', 'integer', array('limit' => MysqlAdapter::INT_TINY,'default' => 0,'null' => false))
            ->addColumn('create_time', 'integer', ['limit' => MysqlAdapter::INT_REGULAR,'default'=>0])
            ->addColumn('update_time', 'integer', ['limit' => MysqlAdapter::INT_REGULAR,'default'=>0])
            ->addColumn('delete_time', 'integer', ['limit' => MysqlAdapter::INT_REGULAR,'default'=>null,'null' => true])
            ->addIndex(['name'], array('unique' => false))
            ->addIndex(['alias'], array('unique' => false))
            ->create();
        $defaultUser = [
            'name'=>'Administrator',
            'alias'=> 'administrator',
            'create_time'=> time(),
            'update_time'=> time(),
        ];
        $table->insert($defaultUser);
        $table->saveData();
    }
}
