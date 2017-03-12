<?php
use Migrations\AbstractSeed;

/**
 * Users seed.
 */
class UsersSeed extends AbstractSeed
{
    /**
     * Run Method.
     *
     * Write your database seeder using this method.
     *
     * More information on writing seeds is available here:
     * http://docs.phinx.org/en/latest/seeding.html
     *
     * @return void
     */
    public function run()
    {
        $data = [
            [
                'name' => 'admin',
                'password' => '$2y$10$cIq0SA4hZvaAXY4h1UN1E.JYuXOw7qLNJWpUp4aGt8qGtSkHe9VxC', //初期パスワード:「admin」
                'role' => 'admin',
                'modified' => date('Y-m-d H:i:s'),
                'created' => date('Y-m-d H:i:s')
            ],
        ];

        $table = $this->table('users');
        $table->insert($data)->save();
    }
}
