<?php
use Migrations\AbstractMigration;

class AddTaskModalFlagToUsers extends AbstractMigration
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
        $table->addColumn('task_modal_flg', 'integer', [
            'default' => 0,
            'limit' => 11,
            'null' => true,
        ]);
        $table->update();
    }
}
