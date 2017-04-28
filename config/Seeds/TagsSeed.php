<?php
use Migrations\AbstractSeed;

/**
 * Tags seed.
 */
class TagsSeed extends AbstractSeed
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
                'category' => 'HTML',
                'user_id' => 1,
                'modified' => date('Y-m-d H:i:s'),
                'created' => date('Y-m-d H:i:s')
            ],
            [
                'category' => 'PHP',
                'user_id' => 1,
                'modified' => date('Y-m-d H:i:s'),
                'created' => date('Y-m-d H:i:s')
            ],
            [
                'category' => 'SQL',
                'user_id' => 1,
                'modified' => date('Y-m-d H:i:s'),
                'created' => date('Y-m-d H:i:s')
            ],
            [
                'category' => 'CSS',
                'user_id' => 1,
                'modified' => date('Y-m-d H:i:s'),
                'created' => date('Y-m-d H:i:s')
            ],
            [
                'category' => 'JavaScript',
                'user_id' => 1,
                'modified' => date('Y-m-d H:i:s'),
                'created' => date('Y-m-d H:i:s')
            ],
            [
                'category' => 'jQuery',
                'user_id' => 1,
                'modified' => date('Y-m-d H:i:s'),
                'created' => date('Y-m-d H:i:s')
            ],
            [
                'category' => 'アルゴリズム',
                'user_id' => 1,
                'modified' => date('Y-m-d H:i:s'),
                'created' => date('Y-m-d H:i:s')
            ],
            [
                'category' => 'その他',
                'user_id' => 1,
                'modified' => date('Y-m-d H:i:s'),
                'created' => date('Y-m-d H:i:s')
            ]
        ];

        $table = $this->table('tags');
        $table->insert($data)->save();
    }
}
