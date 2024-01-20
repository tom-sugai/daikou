<?php
namespace App\Controller\Component;

use Cake\Controller\Component;
use Cake\Controller\ComponentRegistry;
use Cake\Mailer\Email;
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
        //$this->email = new Email('default');
        $this->mailer = new Mailer('default');
    }

    public function send($message, $order)
    {
        //debug($this->mailer);
        // send mail
        $this->mailer
            ->setEmailFormat('html')
            ->setTo('fumiko@svr.home.com')
            ->setFrom('tom@svr.home.com')
            ->setSubject('Mail test from Smail controller!!')
            ->setViewVars(['order' => $order])
            ->viewBuilder()
                ->setTemplate('welcome')
                ->setLayout('default');
    
        $this->mailer->deliver();

        /** 
        $this->email
            ->setTemplate('welcome', 'default')
            ->emailFormat('html')
            //->to('fumiko@svr.home.com')
            ->to($order->user->email)
            ->from(['tom@svr.home.com' => 'CakePHP'])
            ->subject('Thank you mail !!')
            ->viewVars(['order' => $order])
            ->send($message);
        */    
    }
}
