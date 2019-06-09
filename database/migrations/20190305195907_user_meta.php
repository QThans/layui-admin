<?php

use Phinx\Db\Adapter\MysqlAdapter;
use think\migration\Migrator;

class UserMeta extends Migrator
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
        $table = $this->table('user_meta');
        $table->addColumn('user_id', 'integer', ['limit' => MysqlAdapter::INT_REGULAR])
            ->addColumn('key', 'string', ['limit' => 255])
            ->addColumn('value', 'text', ['limit' => MysqlAdapter::TEXT_LONG, 'null'=>true])
            ->addColumn('create_time', 'integer', ['limit' => MysqlAdapter::INT_REGULAR, 'default'=>0])
            ->addColumn('update_time', 'integer', ['limit' => MysqlAdapter::INT_REGULAR, 'default'=>0])
            ->addColumn('delete_time', 'integer', ['limit' => MysqlAdapter::INT_REGULAR, 'default'=>null, 'null' => true])
            ->addIndex(['user_id'], ['unique' => false])
            ->addIndex(['key'], ['unique' => false])
            ->create();
    }
}
