<?php

use think\migration\Migrator;
use think\migration\db\Column;
use Phinx\Db\Adapter\MysqlAdapter;

class AuthRule extends Migrator
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
        $table = $this->table('auth_rule');
        $table->addColumn('name', 'char', array('limit'=>80))
            ->addColumn('title', 'char', array('limit' => 20))
            ->addColumn('status', 'integer', array('limit' => MysqlAdapter::INT_TINY,'default' => 1,'null' => false))
            ->addColumn('condition', 'char', array('limit' => 100,'null'=>true))
            ->addIndex(array('name'), array('unique'=>true))
            ->create();
    }
}
