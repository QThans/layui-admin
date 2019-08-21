<?php

use Phinx\Db\Adapter\MysqlAdapter;
use think\migration\Migrator;

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

        $table->addColumn('name', 'string', ['limit' => 100])
            ->addColumn('parent_id', 'integer', ['limit' => MysqlAdapter::INT_REGULAR, 'default' => 0])
            ->addColumn('order', 'integer', ['limit' => MysqlAdapter::BLOB_REGULAR, 'default' => 1000])
            ->addColumn('icon', 'string', ['limit' => 100])
            ->addColumn('uri', 'string', ['limit' => 100, 'default' => ''])
            ->addColumn('permission', 'string', ['limit' => 100, 'default' => ''])
            ->addColumn('status', 'integer', ['limit' => MysqlAdapter::INT_TINY, 'default' => 0, 'null' => false])
            ->addColumn('create_time', 'integer', ['limit' => MysqlAdapter::INT_REGULAR, 'default' => 0])
            ->addColumn('update_time', 'integer', ['limit' => MysqlAdapter::INT_REGULAR, 'default' => 0])
            ->addColumn('delete_time', 'integer', ['limit' => MysqlAdapter::INT_REGULAR, 'default' => null, 'null' => true])
            ->addIndex(['parent_id'], ['unique' => false])
            ->create();
        $default[] = [
            'name'        => '系统管理',
            'parent_id'   => 0,
            'order'       => 1,
            'icon'        => 'layui-icon-set',
            'uri'         => '',
            'create_time' => time(),
            'update_time' => time(),
        ];
        $default[] = [
            'name'        => '菜单管理',
            'parent_id'   => 1,
            'order'       => 2,
            'icon'        => '',
            'uri'         => '/admin/menu',
            'create_time' => time(),
            'update_time' => time(),
        ];
        $default[] = [
            'name'        => '权限管理',
            'parent_id'   => 1,
            'order'       => 3,
            'icon'        => '',
            'uri'         => '/admin/permission',
            'create_time' => time(),
            'update_time' => time(),
        ];
        $default[] = [
            'name'        => '权限组',
            'parent_id'   => 1,
            'order'       => 4,
            'icon'        => '',
            'uri'         => '/admin/role',
            'create_time' => time(),
            'update_time' => time(),
        ];
        $default[] = [
            'name'        => '用户管理',
            'parent_id'   => 0,
            'order'       => 5,
            'icon'        => 'layui-icon-user',
            'uri'         => '',
            'create_time' => time(),
            'update_time' => time(),
        ];
        $default[] = [
            'name'        => '本站管理员',
            'parent_id'   => 5,
            'order'       => 6,
            'icon'        => '',
            'uri'         => '/admin/auth/admins',
            'create_time' => time(),
            'update_time' => time(),
        ];
        $table->insert($default);
        $table->saveData();
    }
}
