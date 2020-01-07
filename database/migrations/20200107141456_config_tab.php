<?php

use Phinx\Db\Adapter\MysqlAdapter;
use think\migration\Migrator;
use think\migration\db\Column;

class ConfigTab extends Migrator
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
        $table = $this->table('system_config_tab');
        $table->addColumn('name', 'string', ['limit' => 20, 'comment' => '配置分类名称'])
            ->addColumn('alias', 'string', ['limit' => 20, 'comment' => '配置分类别名'])
            ->addColumn('status', 'integer', ['limit' => MysqlAdapter::INT_TINY, 'comment' => '状态，1-禁用，0-正常', 'default' => 0])
            ->addColumn(
                'create_time',
                'integer',
                ['limit' => MysqlAdapter::INT_REGULAR, 'default' => 0]
            )
            ->addColumn(
                'update_time',
                'integer',
                ['limit' => MysqlAdapter::INT_REGULAR, 'default' => 0]
            )
            ->addIndex(['alias'], ['unique' => false])
            ->create();
    }
}
