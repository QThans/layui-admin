<?php

use Phinx\Db\Adapter\MysqlAdapter;
use think\facade\App;
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
            ->addColumn('type', 'integer', ['limit' => MysqlAdapter::INT_TINY, 'comment' => '0 系统配置 1应用  2支付 3 其他', 'default' => 0])
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
        $table = $this->table('menu');

        $default = App::getInstance()->config->get('database.default');

        $config = App::getInstance()->config->get("database.connections.{$default}");

        $row = $this->fetchRow("SELECT * FROM `" . $config['prefix'] . "menu` ORDER BY ID DESC LIMIT 1;");
        $id = $row['id']+1;
        $data[] = [
            'id'          => $id,
            'name'        => '维护',
            'parent_id'   => 0,
            'icon'        => 'layui-icon-component',
            'order'       => 10000,
            'uri'         => '',
            'create_time' => time(),
            'update_time' => time(),
        ];
        $data[] = [
            'id'          => $id+1,
            'name'        => '开发配置',
            'parent_id'   => $id,
            'icon'        => '',
            'order'       => 1000,
            'uri'         => '',
            'create_time' => time(),
            'update_time' => time(),
        ];
        $data[] = [
            'id'          => $id+2,
            'name'        => '配置分类',
            'parent_id'   => $id+1,
            'icon'        => '',
            'order'       => 1000,
            'uri'         => '/admin/system/config_tab',
            'create_time' => time(),
            'update_time' => time(),
        ];
        $row = $this->fetchRow("SELECT * FROM `".$config['prefix']."menu` WHERE `name` = '系统管理' LIMIT 1;");
        $data[] = [
            'name'        => '系统配置',
            'parent_id'   => $row['id'],
            'icon'        => '',
            'order'       => 1000,
            'uri'         => '/admin/system/config_tab/setting/0',
            'create_time' => time(),
            'update_time' => time(),
        ];
        $data[] = [
            'name'        => '应用配置',
            'parent_id'   => $row['id'],
            'icon'        => '',
            'order'       => 1000,
            'uri'         => '/admin/system/config_tab/setting/1',
            'create_time' => time(),
            'update_time' => time(),
        ];
        $data[] = [
            'name'        => '支付配置',
            'parent_id'   => $row['id'],
            'icon'        => '',
            'order'       => 1000,
            'uri'         => '/admin/system/config_tab/setting/2',
            'create_time' => time(),
            'update_time' => time(),
        ];
        $data[] = [
            'name'        => '其他配置',
            'parent_id'   => $row['id'],
            'icon'        => '',
            'order'       => 1000,
            'uri'         => '/admin/system/config_tab/setting/3',
            'create_time' => time(),
            'update_time' => time(),
        ];
        $table->insert($data);
        $table->saveData();
    }
}
