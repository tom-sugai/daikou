<?php
namespace App\Form;

use Cake\Form\Form;
use Cake\Form\Schema;
use Cake\Validation\Validator;

class FileLoadForm extends Form
{
    protected function _buildSchema(Schema $schema):Schema
    {
        return $schema->addField('addToDir', 'string')
                      ->addField('csv', ['type' => 'string']);
    }

    protected function _buildValidator(Validator $validator): Validator
    {
        $validator->add('name', 'length', [
                'rule' => ['minLength', 6],
                'message' => '名前は必須です'
        ]);

        return $validator;
    }

    protected function _execute(array $data):bool
    {
        //echo "method execute exceed !!";
        // メールを送信する
        return true;
    }
}
?>