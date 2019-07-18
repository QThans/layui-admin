<?php

use think\migration\Migrator;
use Phinx\Db\Adapter\MysqlAdapter;

class Admins extends Migrator
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
        $table = $this->table('admins');
        $table->addColumn('name', 'string', ['limit' => 100])
            ->addColumn('salt', 'string', ['limit' => 20])
            ->addColumn('password', 'string', ['limit' => 128])
            ->addColumn('nickname', 'string', ['limit' => 100])
            ->addColumn('avatar', 'string', ['limit' => 255, 'default' => ''])
            ->addColumn('email', 'string', ['limit' => 100, 'null' => true])
            ->addColumn('mobile', 'string', ['limit' => 11, 'null' => true])
            ->addColumn('activation_key', 'string', ['limit' => 255, 'null' => true])
            ->addColumn('status', 'integer', ['limit' => MysqlAdapter::INT_TINY, 'default' => 0, 'null' => false])
            ->addColumn('register_ip', 'string', ['limit' => 15, 'comment' => '注册IP', 'default' => ''])
            ->addColumn('last_login_ip', 'string', ['limit' => 15, 'comment' => '最后登录IP', 'default' => ''])
            ->addColumn('last_login_time', 'integer', ['limit' => MysqlAdapter::INT_REGULAR, 'default' => 0, 'comment' => '最后登录时间'])
            ->addColumn('create_time', 'integer', ['limit' => MysqlAdapter::INT_REGULAR, 'default' => 0])
            ->addColumn('update_time', 'integer', ['limit' => MysqlAdapter::INT_REGULAR, 'default' => 0])
            ->addColumn('delete_time', 'integer', ['limit' => MysqlAdapter::INT_REGULAR, 'default' => null, 'null' => true])
            ->addIndex(['nickname'], ['unique' => false])
            ->addIndex(['name'], ['unique' => false])
            ->addIndex(['email'], ['unique' => false])
            ->addIndex(['mobile'], ['unique' => false])
            ->create();
        $salt = random_str(20);
        $password = encrypt_password('123456', $salt);
        $default = [
            'name'        => 'admin',
            'salt'        => $salt,
            'password'    => $password,
            'nickname'    => 'admin',
            'create_time' => time(),
            'update_time' => time(),
        ];
        $table->insert($default);
        $table->saveData();
    }
}
