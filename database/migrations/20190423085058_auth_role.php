<?php

use Phinx\Db\Adapter\MysqlAdapter;
use think\migration\Migrator;

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

        $table->addColumn('name', 'string', ['limit' => 100])
            ->addColumn('alias', 'string', ['limit' => 20])
            ->addColumn('status', 'integer', ['limit' => MysqlAdapter::INT_TINY, 'default' => 0, 'null' => false])
            ->addColumn('create_time', 'integer', ['limit' => MysqlAdapter::INT_REGULAR, 'default'=>0])
            ->addColumn('update_time', 'integer', ['limit' => MysqlAdapter::INT_REGULAR, 'default'=>0])
            ->addColumn('delete_time', 'integer', ['limit' => MysqlAdapter::INT_REGULAR, 'default'=>null, 'null' => true])
            ->addIndex(['name'], ['unique' => false])
            ->addIndex(['alias'], ['unique' => false])
            ->create();
        $default = [
            'name'       => 'Administrator',
            'alias'      => 'administrator',
            'create_time'=> time(),
            'update_time'=> time(),
        ];
        $table->insert($default);
        $table->saveData();
    }
}
