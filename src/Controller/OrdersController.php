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
        //debug($this->loginUser);
        $this->Authentication->allowUnauthenticated(['order']);
    }

    public function confirmOrder($id = null){
        $this->autoLayout = true;
        $this->autoRender = true;
        $this->viewBuilder()->setLayout('otsukai_layout');

        $order = $this->Orders->get($id, [
            'contain' => ['Users' => 'Accounts', 'Details' => 'Products']]);
        //debug($order);
        $this->set(compact('order'));
        $this->set('details', $order->details);

        // put here Event dispatch program
        $message = "Thank you for Order from shop";
        $event = new Event('Notification.E-Mail',$this,['message' => $message, 'order' => $order]);
        //debug($event);
        $this->getEventManager()->dispatch($event);
        echo "Order completed !! from Order/confirmOrder ";      
    }

    public function fixOrder(){

        function deliveryDate()
        {
            //echo "Time Calculation" . "<br>";
            //echo time() . "<br>";
            $dt = getdate();
            //var_dump($dt);
            //echo "<br>" . "\$dt[0] : " . $dt[0] . "<br><br>";
            //echo "today is : " . date("Y/m/d(D)", $dt[0]) . "<br>";
            //echo "dt['wday'] : " . $dt['wday'] . "<br>";
            //$days = 5 - $dt['wday'];

            $deliveryDate = "";
            switch(5 - $dt['wday']):
                case -1:
                    //来週の金曜日
                    $next_week_fri_timestamp = $dt[0] + (60 * 60 * 24) * 6;
                    $fmt = "Y年m月d日(D)";
                    //echo "next week Friday is : " . date($fmt, $next_week_fri_timestamp) . "<br>";
                    $deliveryDate =  date($fmt, $next_week_fri_timestamp);
                    break;
                case  0:
                    //来週の金曜日
                    $next_week_fri_timestamp = $dt[0] + (60 * 60 * 24) * 7;
                    $fmt = "Y年m月d日(D)";
                    //echo "next week Friday is : " . date($fmt, $next_week_fri_timestamp) . "<br>";
                    $deliveryDate =  date($fmt, $next_week_fri_timestamp);
                    break;
                default:
                    //今週の金曜日
                    $next_fri_timestamp = $dt[0] + (60 * 60 * 24) * (5 - $dt['wday']);
                    $fmt = "Y年m月d日(D)";
                    //echo "next Friday is : " . date($fmt, $next_fri_timestamp) . "<br>";
                    $deliveryDate =  date($fmt, $next_fri_timestamp);
            endswitch;

            return $deliveryDate;

        };

        $this->autoLayout = true;
        $this->autoRender = true;
        $this->viewBuilder()->setLayout('otsukai_layout');
        //echo "This is Orders/fixOrder Controller/Action." . "<br>";
        //echo $this->loginUser->name . " is Login Now!! " . "<br>";

        // Preparation Display orderd Products
        $this->paginate = [
            'contain' => ['Users', 'Products'],
        ];

        $userId = $this->loginUser->id;
        $cartsTable = TableRegistry::getTableLocator()->get('Carts');
        $query = $cartsTable->find()->contain(['Users', 'Products'])
            ->where(['Carts.user_id' => $userId])
            ->where(['Carts.orderd' => 1]);
        //debug($query->toArray());
        $carts = $this->paginate($query);
        $this->set(compact('carts'));

        //---------------------------------------------------

        $usersTable = TableRegistry::getTableLocator()->get('Users');
        $user = $usersTable->get($this->loginUser->id, [
            'contain' => ['Accounts'],
        ]);
        $account = $user->account;
        //debug($account);
        $this->set('account', $account);

        // step1 check orderdItems and make detail entity list
         $orderdProducts= $query->toArray();  
        //debug($orderdProducts);

        // prepare Details Table
        $detailsTable = TableRegistry::getTableLocator()->get('Details');
        
        // Create detail entity Array
        $details = [];
        //$ndx = 0;
        foreach($orderdProducts as $orderdProduct){
            // make empty Entity
            $detail = $detailsTable->newEmptyEntity();
            // set detail entity properties
            //$detail->order_id = $order->id; 
            $detail->product_id = $orderdProduct->product_id;
            $detail->size = $orderdProduct->size;
            $detail->note1 = $orderdProduct->note1;
            $detail->note2 = $orderdProduct->note2;
            $detail->note3 = $orderdProduct->note3;
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
        // set for Note2 deliveryData
        $deliveryDate = deliveryDate();
        $this->set('deliveryDate', $deliveryDate);

        // Save order with some related details using details[] array automatecalyly. 
        // and save with Note1,Note2, Note3 fileds from input form(Order)
        if ($this->request->is('post')) {
            $order = $this->Orders->patchEntity($order, $this->request->getData());
            //debug($order);
            // save order to ordersTable              
            if ($this->Orders->save($order)) {;
                // $orderのidが確定
                // その後、$details[]の中の配列要素$detailのfileｄ($order_id)に値が挿入される
                //debug($order); 
                // clean carts table( delete orderd cart record from carts table ) 
                foreach($orderdProducts as $orderdProduct){
                    $cartsTable->delete($orderdProduct);
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
