<?php
namespace App\Form;

use Cake\Form\Form;
use Cake\Form\Schema;
use Cake\Validation\Validator;
use Cake\Mailer\Email;

class ContactForm extends Form
{
    protected function _buildSchema(Schema $schema): Schema
    {
        return $schema->addField('name', 'string')
            ->addField('email', ['type' => 'string'])    
            ->addField('body', ['type' => 'text']);
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

    protected function _execute(array $data): bool
    {
        //echo "name : " . $data['name'] . "<br/>";
        //echo "email : " . $data['email'] . "<br/>";
        //echo "body : " . $data['body'] . "<br/>";

        // メールを送信する

        $info_email = new Email('default');
        $info_email
            ->setFrom(['tom@svr.home.com'=>'事務局'])
            ->setTo('tom@svr.home.com')
            ->setSubject('ご意見・ご要望がありました。')
            ->send('お客様のお名前：'.$data['name'].' 様'."\n\n".'メールアドレス：'."\n".$data['email']."\n\n".'内容：'."\n".$data['body']);


        $thank_email = new Email('default');
        $thank_email
            ->setFrom(['tom@svr.home.com'=>'事務局'])
            ->setTo($data['email'])
            ->setSubject('ご意見・ご要望をありがとうございます！')
            ->send($data['name'].' 様'."\n\n".
                    '貴重なご意見・ご要望をいただきまして、誠にありがとうございます！'."\n".
                    'サービス改善のヒントとして役立てるほか、必要があればお客様に折り返しメールを差し上げることもございます。'."\n\n".
                    'お客様のお名前：'.$data['name']."\n\n".'メールアドレス：'."\n".$data['email']."\n\n".'内容：'."\n".$data['body']);
        return true;
    }
}
?>