<?php
use Migrations\AbstractMigration;

class CreateEvents extends AbstractMigration
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
        $table = $this->table('events');
        $table->addColumn('title', 'text', [
            'default' => null,
            'null' => false,
        ]);
        $table->addColumn('allday', 'integer', [
            'default' => 1,
            'limit' => 1,
            'null' => true,
        ]);
        $table->addColumn('start', 'timestamp', [
            'default' => null,
            'null' => true,
        ]);
        $table->addColumn('end', 'timestamp', [
            'default' => null,
            'null' => true,
        ]);
        $table->addColumn('user_id', 'integer', [
            'default' => null,
            'limit' => 11,
            'null' => true,
        ]);
        $table->addColumn('details', 'text', [
            'default' => null,
            'null' => true,
        ]);
        $table->addColumn('status', 'text', [
            'default' => 'Scheduled',
            'null' => true,
        ]);
        $table->addColumn('created', 'timestamp', [
            'default' => null,
            'null' => false,
        ]);
        $table->addColumn('modified', 'timestamp', [
            'default' => null,
            'null' => false,
        ]);
        $table->create();
    }
}
