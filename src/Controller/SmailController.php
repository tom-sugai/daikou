<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\ORM\TableRegistry;
use Cake\Mailer\Email;
use Cake\Mailer\Transport\DebugTransport;
use Cake\Mailer\TransportFactory;

class SmailController extends AppController 

{
    public function index(){
        $this->autoRender = false;
        echo "Here is EmailController";

        // prepare contents which will send by email
        $ordersTable = TableRegistry::getTableLocator()->get('Orders');
        $order = $ordersTable->get(30, ['contain' => ['Users', 'Details' => 'Products']]);
        debug($order);

        // load from config/app_loca.php
        // 一度dropしないと設定できない
        //Email::dropTransport('debug');
        TransportFactory::drop('debug');

        /** 
        // create DebugTransport
        $email = new Email();
        // create DebugTransport
        $transport = new DebugTransport();
        // set Transport
        $email->setTransport($transport);
        */ 

        // set Transport
        TransportFactory::getConfig('default');

        // create Email
        $email = new Email();

        // send mail
        $result = $email
            ->setTemplate('welcome', 'default') // 'view template' 'layout template'
            //->viewBuilder()->setTemplate('default', 'default')
            ->emailFormat('html')
            ->setTo('fumiko@svr.home.com')
            ->setFrom('tom@fmva52.home.com')
            ->setSubject('Mail test from Smail controller!!')
            ->viewVars(['order' => $order])
            ->send();
        //debug($result);

        // Subjects samples
        /** 
        $result = $email->setFrom(['me@example.com' => 'My Site'])
            ->setTo('you@example.com')
            ->addTo('fumiko@example.com', 'Junji Example')
            ->setCc('seiichi@example.com')
            ->addCc('keito@example.com')
            ->setBcc('yumi@example.com')
            ->addBcc('keiko@example.com')
            ->setSubject('About')
            ->send('Hello Everybody !!');
        debug($result);
        */

    }
}
?>
