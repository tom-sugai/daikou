<?php
declare(strict_types=1);

namespace App\Controller;

use App\Controller\AppController;
//use Cake\Controller\ComponentRegistry;
//use App\Controller\Component\MathComponent;
use Cake\Event\EventInterface;
use Cake\Event\Event;
use Cake\Event\EventManager;
use App\Event\NotificationListener;
use Cake\ORM\TableRegistry;

class TomCompoTestController extends AppController
{

    public function initialize(): void
    {
        parent::initialize();

        $this->Notification = new NotificationListener();
        EventManager::instance()->on($this->Notification);
        //EventManager::instance()->attach($this->Notification); // nothing attach method *** BUG
    }

    public function beforeFilter(\Cake\Event\EventInterface $event)
    {
        parent::beforeFilter($event);

        $this->Authentication->allowUnauthenticated(['index']);
    }

    public function index(){
        $this->autoLayout = true;
        $this->autoRender = false;

        echo "This is TomCompoTest/index() method." . "<br>";

        /**  
        // コントローラーのアクションの中でComponentを使う
        $this->loadComponent('Math');
        $amount1 = 10;
        $amount2 = 70;
        $val = $this->Math->doComplexOperation($amount1, $amount2);
        echo $val . "<br/>";
        */

        
        // exec MathComponent using Event Notification.Math
        $amount1 = 10;
        $amount2 = 50;
        $event = new Event('Notification.Math',$this,['amount1' => $amount1, 'amount2' => $amount2]);
        debug($event);
        $this->getEventManager()->dispatch($event);
        debug($this->getEventManager());
        
        
        // prepar Oders object
        $id = 24;
        $ordersTable = TableRegistry::getTableLocator()->get('Orders');
        $order = $ordersTable->get($id, ['contain' => ['Users', 'Details' => ['Items' => 'Products']]]);
        debug($order);
        
        // put here Event dispatch program
        $message = "Thank you for Order from shop";
        $event = new Event('Notification.E-Mail', $this, ['message' => $message, 'order' => $order]);
        debug($event);
        $this->getEventManager()->dispatch($event);
        //debug($this->getEventManager());
           
    }

}    