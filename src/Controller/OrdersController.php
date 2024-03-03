<?php
declare(strict_types=1);

namespace App\Controller;

use App\Controller\AppController;
use Cake\Error\Debugger;
use Cake\ORM\TableRegistry;
use Cake\Event\EventInterface;
use Cake\Event\Event;
use Cake\Event\EventManager;
use App\Event\NotificationListener;
use Cake\I18n\Time;
use Cake\I18n\FrozenTime;
use Cake\Core\Configure;

/**
 * Orders Controller
 *
 * @property \App\Model\Table\OrdersTable $Orders
 * @method \App\Model\Entity\Order[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class OrdersController extends AppController
{
    private $loginUser;

    public function initialize(): void
    {
        parent::initialize();
        $this->Notification = new NotificationListener();
        EventManager::instance()->on($this->Notification);
    }

    public function beforeFilter(\Cake\Event\EventInterface $event)
    {
        parent::beforeFilter($event);

        // loginUser --- Authentication コンポーネントで取得
        $this->loginUser = $this->Authentication->getIdentity();
        $this->Authentication->allowUnauthenticated(['order']);
    }

    public function confirmOrder($id = null){
        $this->autoLayout = true;
        $this->autoRender = true;
        $this->viewBuilder()->setLayout('otsukai_layout');

        $order = $this->Orders->get($id, [
            'contain' => ['Users', 'Details' => ['Items' => 'Products']],
        ]);
        //debug($order);
        $this->set(compact('order'));
        $this->set('details', $order->details);
        
        // put here Event dispatch program
        $message = "Thank you for Order from shop";
        $event = new Event('Notification.E-Mail',$this,['message' => $message, 'order' => $order]);
        //debug($event);
        $this->getEventManager()->dispatch($event);        
    }

    public function fixOrder(){
        $this->autoLayout = true;
        $this->autoRender = true;
        $this->viewBuilder()->setLayout('otsukai_layout');
        //echo "This is Orders/fixOrder Controller/Action." . "<br>";
        //echo $this->loginUser->name . " is Login Now!! " . "<br>";

        // Preparation Display orderd Items
        $this->paginate = [
            'contain' => ['Users', 'Items' => 'Products'],
        ];

        $userId = $this->loginUser->id;
        $cartsTable = TableRegistry::getTableLocator()->get('Carts');
        $query = $cartsTable->find()->contain(['Users', 'Items' => 'Products'])
            ->where(['Carts.user_id' => $userId])
            ->where(['Carts.orderd' => 1]);
        //debug($query->toArray());
        $carts = $this->paginate($query);
        $this->set(compact('carts'));

        // step1 check orderdItems and make detail entity list
         $orderdItems= $query->toArray();  
        //debug($orderdItems);

        // prepare Details Table
        $detailsTable = TableRegistry::getTableLocator()->get('Details');
        
        // Create detail entity Array
        $details = [];
        //$ndx = 0;
        foreach($orderdItems as $orderdItem){
            // make empty Entity
            $detail = $detailsTable->newEmptyEntity();
            // set detail entity properties
            //$detail->order_id = $order->id; 
            $detail->item_id = $orderdItem->item_id;
            $detail->size = $orderdItem->size;
            $detail->note1 = $orderdItem->note1;
            $detail->note2 = $orderdItem->note2;
            $detail->note3 = $orderdItem->note3;
            $detail->created = Time::now();
            $detail->modified = Time::now();   
            // set entity(detail) to Array(detailes[ndx])
            $details[] = $detail;
            // increment ndx
            //$ndx++;
        }

        // step2 create and save Orders object with details
        $order = $this->Orders->newEmptyEntity();
        $order->user_id = $userId;
        $order->details = $details; 
        $order->created = Time::now();
        $order->modified = Time::now(); 
        //debug($order);

        // set for orders Form which is to input Oders fields Note1, Note2, Note3
        $this->set('order',$order);

        // Save order with some related details using details[] array automatecalyly. 
        // and save with Note1,Note2, Note3 fileds from input form(Order)
        if ($this->request->is('post')) {
            $order = $this->Orders->patchEntity($order, $this->request->getData());
            // save order to ordersTable              
            if ($this->Orders->save($order)) {;
                // $orderのidが確定
                // その後、$details[]の中の配列要素$detailのfileｄ($order_id)に値が挿入される
                //debug($order);
                // clean carts table( delete orderd cart record from carts table ) 
                foreach($orderdItems as $orderItem){
                    $cartsTable->delete($orderItem);
                }
                return $this->redirect(['action' => 'confirm-order', $order->id]);
            } else {
                $this->Flash->error(__( 'The order could not be saved. Please, try again.'));
            }
        }
    }

    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Users'],
        ];
        $orders = $this->paginate($this->Orders);
        $this->set(compact('orders'));
    }

    /**
     * View method
     *
     * @param string|null $id Order id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $order = $this->Orders->get($id, [
            'contain' => ['Users', 'Details'],
        ]);
        $this->set(compact('order'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $order = $this->Orders->newEmptyEntity();
        if ($this->request->is('post')) {
            $order = $this->Orders->patchEntity($order, $this->request->getData());
            if ($this->Orders->save($order)) {
                $this->Flash->success(__('The order has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The order could not be saved. Please, try again.'));
        }
        $users = $this->Orders->Users->find('list', ['limit' => 200])->all();
        $this->set(compact('order', 'users'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Order id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $order = $this->Orders->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $order = $this->Orders->patchEntity($order, $this->request->getData());
            if ($this->Orders->save($order)) {
                $this->Flash->success(__('The order has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The order could not be saved. Please, try again.'));
        }
        $users = $this->Orders->Users->find('list', ['limit' => 200])->all();
        $this->set(compact('order', 'users'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Order id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $order = $this->Orders->get($id);
        if ($this->Orders->delete($order)) {
            $this->Flash->success(__('The order has been deleted.'));
        } else {
            $this->Flash->error(__('The order could not be deleted. Please, try again.'));
        }
        return $this->redirect(['action' => 'index']);
    }
}
