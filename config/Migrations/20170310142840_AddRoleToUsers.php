<?php
use Migrations\AbstractMigration;

class AddRoleToUsers extends AbstractMigration
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
        $table->addColumn('role', 'text', [
            'default' => null,
            'null' => true,
        ]);
        $table->update();
    }
}
