<?php

use Phinx\Db\Adapter\MysqlAdapter;
use think\migration\Migrator;
use think\migration\db\Column;

class Config extends Migrator
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
        $table = $this->table('system_config');
        $table->addColumn('config_tab_id', 'string', ['limit' => MysqlAdapter::INT_TINY, 'comment' => '配置分类ID'])
            ->addColumn('name', 'string', ['limit' => 100, 'comment' => '配置名称'])
            ->addColumn('alias', 'string', ['limit' => 100, 'comment' => '配置别名'])
            ->addColumn('tips', 'string', ['limit' => 255, 'comment' => '配置说明'])
            ->addColumn('rule', 'string', ['limit' => 255, 'comment' => '验证规则'])
            ->addColumn('weight', 'integer', ['limit' => MysqlAdapter::INT_MEDIUM, 'default' => 1000])
            ->addColumn('type', 'string', ['limit' => 20, 'comment' => '配置类型'])
            ->addColumn('parameter', 'string', ['limit' => 500, 'comment' => '参数', 'default' => null, 'null' => true])
            ->addColumn('value', 'string', ['limit' => 500, 'comment' => '配置值', 'default' => null, 'null' => true])
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
