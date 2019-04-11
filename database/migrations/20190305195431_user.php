<?php

use think\migration\Migrator;
use think\migration\db\Column;
use Phinx\Db\Adapter\MysqlAdapter;

class User extends Migrator
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
        $table = $this->table('user');

        $table->addColumn('name', 'string', array('limit' => 100))
            ->addColumn('salt', 'string', array('limit' => 20))
            ->addColumn('password', 'string', array('limit' => 128))
            ->addColumn('nickname', 'string', array('limit' => 100))
            ->addColumn('email', 'string', array('limit' => 100,'null'=>true))
            ->addColumn('mobile', 'string', array('limit' => 11,'null'=>true))
            ->addColumn('activation_key', 'string', array('limit' => 255,'null'=>true))
            ->addColumn('status', 'integer', array('limit' => MysqlAdapter::INT_TINY,'default' => 0,'null' => false))
            ->addColumn('register_ip', 'string', ['limit' => 15, 'comment'=>'注册IP','default'=>''])
            ->addColumn('last_login_ip', 'string', ['limit' => 15, 'comment'=>'最后登录IP','default'=>''])
            ->addColumn('last_login_time', 'integer', ['limit' => MysqlAdapter::INT_REGULAR,'default'=>0, 'comment'=>'最后登录时间'])
            ->addColumn('create_time', 'integer', ['limit' => MysqlAdapter::INT_REGULAR,'default'=>0])
            ->addColumn('update_time', 'integer', ['limit' => MysqlAdapter::INT_REGULAR,'default'=>0])
            ->addColumn('delete_time', 'integer', ['limit' => MysqlAdapter::INT_REGULAR,'default'=>null,'null' => true])
            ->addIndex(['nickname'], array('unique' => false))
            ->addIndex(['login'], array('unique' => false))
            ->addIndex(['email'], array('unique' => false))
            ->addIndex(['mobile'], array('unique' => false))
            ->create();
        $salt = random_str(20);
        $password = encrypt_password('123456', $salt);
        $defaultUser = [
            'login'=>'admin',
            'salt'=> $salt,
            'password'=> $password,
            'nickname'=> 'admin',
        ];
        $table->insert($defaultUser);
        $table->saveData();
    }
}
