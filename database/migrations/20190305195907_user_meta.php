<?php

use think\migration\Migrator;
use think\migration\db\Column;
use Phinx\Db\Adapter\MysqlAdapter;

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
        $table->addColumn('uid', 'integer', array('limit' => MysqlAdapter::INT_REGULAR))
            ->addColumn('key', 'string', array('limit' => 255))
            ->addColumn('value', 'text', array('limit' => MysqlAdapter::TEXT_LONG,'null'=>true))
            ->addIndex(['uid'], array('unique' => false))
            ->addIndex(['key'], array('unique' => false))
            ->create();
    }
}
