<?php
namespace App\Controller\Component;

use Cake\Controller\Component;
use Cake\Controller\ComponentRegistry;
use Cake\Mailer\Mailer;

/**
 * SendMail component
 */
class SendMailComponent extends Component
{
    protected $mailer;

    /**
     * Default configuration.
     *
     * @var array
    */
    protected $_defaultConfig = [];

    public function initialize(array $config): void
    {
        $this->mailer = new Mailer('default');
    }

    public function send($message, $order)
    {
        // send mail
        $this->mailer
            ->setEmailFormat('html')
            ->setFrom('tom@svr.home.com')
            ->setTo('fumiko@svr.home.com')
            ->setSubject('お買い物リストの確認メールです')
            ->setViewVars(['order' => $order])
            ->viewBuilder()
                ->setTemplate('welcome')
                ->setLayout('default');

        $this->mailer->deliver();  
    }
}
