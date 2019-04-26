<?php

use Phinx\Db\Adapter\MysqlAdapter;
use think\migration\Migrator;
use think\migration\db\Column;

class Menu extends Migrator
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
        $table = $this->table('menu');

        $table->addColumn('name', 'string', array('limit' => 100))
            ->addColumn('parent_id', 'integer', ['limit' => MysqlAdapter::INT_REGULAR, 'default' => 0])
            ->addColumn('order', 'integer', ['limit' => MysqlAdapter::BLOB_REGULAR, 'default' => 1000])
            ->addColumn('icon', 'string', array('limit' => 100))
            ->addColumn('uri', 'string', array('limit' => 100, 'default' => ''))
            ->addColumn('permission', 'string', array('limit' => 100, 'default' => ''))
            ->addColumn('status', 'integer', array('limit' => MysqlAdapter::INT_TINY, 'default' => 0, 'null' => false))
            ->addColumn('create_time', 'integer', ['limit' => MysqlAdapter::INT_REGULAR, 'default' => 0])
            ->addColumn('update_time', 'integer', ['limit' => MysqlAdapter::INT_REGULAR, 'default' => 0])
            ->addColumn('delete_time', 'integer', ['limit' => MysqlAdapter::INT_REGULAR, 'default' => null, 'null' => true])
            ->addIndex(['parent_id'], array('unique' => false))
            ->create();
        $default[] = [
            'name' => '系统管理',
            'parent_id' => 0,
            'order' => 1,
            'icon' => 'layui-icon-set',
            'uri' => '',
            'create_time' => time(),
            'update_time' => time(),
        ];
        $default[] = [
            'name' => '菜单管理',
            'parent_id' => 1,
            'order' => 2,
            'icon' => '',
            'uri' => 'admin/menu',
            'create_time' => time(),
            'update_time' => time(),
        ];
        $default[] = [
            'name' => '权限管理',
            'parent_id' => 1,
            'order' => 3,
            'icon' => '',
            'uri' => 'admin/permission',
            'create_time' => time(),
            'update_time' => time(),
        ];
        $default[] = [
            'name' => '用户管理',
            'parent_id' => 0,
            'order' => 4,
            'icon' => 'layui-icon-user',
            'uri' => '',
            'create_time' => time(),
            'update_time' => time(),
        ];
        $default[] = [
            'name' => '管理员',
            'parent_id' => 4,
            'order' => 5,
            'icon' => '',
            'uri' => 'admin/auth/user',
            'create_time' => time(),
            'update_time' => time(),
        ];
        $default[] = [
            'name' => '用户列表',
            'parent_id' => 4,
            'order' => 6,
            'icon' => '',
            'uri' => 'admin/user',
            'create_time' => time(),
            'update_time' => time(),
        ];
        $table->insert($default);
        $table->saveData();
    }
}
