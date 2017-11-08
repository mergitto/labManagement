<?php
use Migrations\AbstractMigration;

class CreateTasks extends AbstractMigration
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
        $table = $this->table('tasks');
        $table->addColumn('description', 'text', [
            'default' => null,
            'null' => true,
        ]);
        $table->addColumn('status', 'integer', [
            'default' => 0,
            'null' => true,
        ]);
        $table->addColumn('weight', 'integer', [
            'default' => null,
            'limit' => 10,
            'null' => true,
        ]);
        $table->addColumn('user_id', 'integer', [
            'default' => null,
            'limit' => 255,
            'null' => true,
        ]);
        $table->addColumn('starttime', 'timestamp', [
            'default' => null,
            'null' => true,
        ]);
        $table->addColumn('endtime', 'timestamp', [
            'default' => null,
            'null' => true,
        ]);
        $table->addColumn('modified', 'timestamp', [
            'default' => null,
            'null' => false,
        ]);
        $table->addColumn('created', 'timestamp', [
            'default' => null,
            'null' => false,
        ]);
        $table->create();
    }
}
