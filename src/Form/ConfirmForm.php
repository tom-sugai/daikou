<?php
namespace App\Form;

use Cake\Form\Form;
use Cake\Form\Schema;
use Cake\Validation\Validator;
use Cake\Mailer\Mailer;

class ConfirmForm extends Form
{
    protected function _buildSchema(Schema $schema): Schema
    {
        return $schema
            ->addField('name', 'text')
            ->addField('tel', 'text')
            ->addField('email', 'text')    
            ->addField('date', 'date')
            ->addField('time', 'time')
            ->addField('textarea', 'text')
            ->addField('likered', 'boolean')
            ->addField('likeblue', 'boolean')
            ->addField('answer', 'integer') 
            ->addField('banks', 'array');       
    }

    protected function _buildValidator(Validator $validator): Validator
    {
        $validator->add('name', 'length', [
            'rule' => ['minLength', 6],
            'message' => '名前は必須です'
        ])->add('email', 'format', [
                'rule' => 'email',
                'message' => '有効なメールアドレスが要求されます',
        ]);

        return $validator;
    }

    protected function _execute(array $postedData): bool
    {
        //echo "name : " . $data['confirm']['name'] . "<br/>";
        //echo "email : " . $data['confirm']['email'] . "<br/>";
        //echo "tel : " . $data['confirm']['tel'] . "<br/>";

        // set ViewVars
        // $data = $data

        //create Mailer
        $mailer = new Mailer('default');
        // メールを送信する
        // send mail
        $mailer
            ->setEmailFormat('html')
            ->setFrom('tom@svr.home.com')
            ->setTo('fumiko@svr.home.com')
            ->setSubject('お買い物リストの確認メールです')
            ->setViewVars(['postedData' => $postedData])
            ->viewBuilder()
                ->setTemplate('msgdump')
                ->setLayout('default');

        $mailer->deliver();  
        return true;
    }
}
?>