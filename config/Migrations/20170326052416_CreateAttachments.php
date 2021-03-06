<?php
use Migrations\AbstractMigration;

class CreateAttachments extends AbstractMigration
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
        $table = $this->table('attachments');
        $table->addColumn('title', 'text', [
            'default' => null,
            'null' => true,
        ]);
        $table->addColumn('file', 'text', [
            'default' => null,
            'null' => true,
        ]);
        $table->addColumn('tmp_file_name', 'text', [
            'default' => null,
            'null' => true,
        ]);
        $table->addColumn('file_dir', 'text', [
            'default' => null,
            'null' => true,
        ]);
        $table->addColumn('url', 'text', [
            'default' => null,
            'null' => true,
        ]);
        $table->addColumn('user_id', 'integer', [
            'default' => null,
            'limit' => 11,
            'null' => true,
        ]);
        $table->addColumn('event_id', 'integer', [
            'default' => null,
            'limit' => 11,
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
