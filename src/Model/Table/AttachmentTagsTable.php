<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use Cake\Localized\Validation\FrValidation;

class AttachmentTagsTable extends Table
{
    public function initialize(array $config)
    {
        $this->belongsTo('Attachments');
        $this->belongsTo('Tags');
    }
}
?>
