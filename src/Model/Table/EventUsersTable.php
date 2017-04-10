<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use Cake\Localized\Validation\FrValidation;

class EventUsersTable extends Table
{
    public function initialize(array $config)
    {
        $this->belongsTo('Events');
        $this->belongsTo('Users');
    }
}
?>
