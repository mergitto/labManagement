<?php
use Migrations\AbstractMigration;

class AddNicknameToUsers extends AbstractMigration
{
    /**
     * Change Method.
     *
     * More information on this method is available here:
     * http://docs.phinx.org/en/latest/migrations.html#the-change-method
     * @return void
     */
    public function change()
    {
        $table = $this->table('users');
        $table->addColumn('nickname', 'text', [
            'default' => "No nameさん",
            'null' => false,
        ]);
        $table->update();
    }
}
