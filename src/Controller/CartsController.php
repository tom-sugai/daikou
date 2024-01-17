<?php
declare(strict_types=1);

namespace App\Controller;

use Cake\I18n\Time;
use Cake\I18n\FrozenTime;

/**
 * Carts Controller
 *
 * @property \App\Model\Table\CartsTable $Carts
 * @method \App\Model\Entity\Cart[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class CartsController extends AppController
{
    private $loginUser;

    public function initialize(): void
    {
        parent::initialize();
    }

    public function beforeFilter(\Cake\Event\EventInterface $event)
    {
        parent::beforeFilter($event);

        // loginUser --- Authentication コンポーネントで取得
        $this->loginUser = $this->Authentication->getIdentity();
        //debug($this->loginUser);

        $this->Authentication->allowUnauthenticated(['into-cart']);
    }

    public function changeSize($cartId = null){
        $this->autoLayout = true;
        $this->autoRender = true;
        //$this->viewBuilder()->setLayout('new_layout');
        echo "This is Carts Controller/chengeSize." . "<br>";
        echo $this->loginUser->name . " is Login Now!! " . "<br>";

        $cart = $this->Carts->get($cartId, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $cart = $this->Carts->patchEntity($cart, $this->request->getData());
            $cart->created = Time::now();
            $cart->modified = Time::now();
            if ($this->Carts->save($cart)) {
                $this->Flash->success(__('The cart has been saved.'));

                return $this->redirect(['controller' => 'Orders', 'action' => 'fixOrder']);
            }
            $this->Flash->error(__('The cart could not be saved. Please, try again.'));
        }
        $users = $this->Carts->Users->find('list', ['limit' => 200])->all();
        $items = $this->Carts->Items->find('list', ['limit' => 200])->all();
        $this->set(compact('cart', 'users', 'items'));   
    }

    public function checkOrder($cartId = null){
        $this->autoLayout = true;
        $this->autoRender = true;
        //$this->viewBuilder()->setLayout('new_layout');
        //echo "This is Carts Controller." . "<br>";
        //echo $this->loginUser->name . " is Login Now!! " . "<br>";
        
        $this->paginate = [
            'contain' => ['Users', 'Items' => 'Products'],
        ];
        //debug($this->loginUser->id);
        $carts = $this->Carts->find()->contain(['Users', 'Items' => 'Products'])->where(['Carts.orderd = ' => 1])->where(['Carts.user_id = ' => $this->loginUser->id]);
        //debug($carts->toArray());
        $carts = $this->paginate($carts);
        $this->set(compact('carts'));
    }

    public function order($cartId = null){
        $this->autoLayout = true;
        $this->autoRender = false;
        //$this->viewBuilder()->setLayout('new_layout');
        //echo "This is Carts Controller." . "<br>";
        echo $this->loginUser->name . " is Login Now!! " . "<br>";

        $cart = $this->Carts->get($cartId);
        $cart->orderd = 1;
        $cart->created = Time::now();
        $cart->modified = Time::now();                

        // save cart record to cartsTable
        if ($this->Carts->save($cart)) {    
            $this->Flash->success(__('Here is /Carts/order --- cartId : ' . $cartId . ' was saved.'));
            return $this->redirect(['controller' => 'Carts', 'action' => 'check_cart']); 
        }
        $this->Flash->error(__('The cart could not be saved. Please, try again.'));   
    }

    public function checkCart(){
        $this->autoLayout = true;
        $this->autoRender = true;
        //$this->viewBuilder()->setLayout('new_layout');
        //echo "This is Carts Controller." . "<br>";
        //echo $this->loginUser->name . " is Login Now!! " . "<br>";
        
        $this->paginate = [
            'contain' => ['Users', 'Items' => 'Products'],
        ];
        //debug($this->loginUser->id);
        $carts = $this->Carts->find()->contain(['Users', 'Items' => 'Products'])->where(['Carts.orderd = ' => 0])->where(['Carts.user_id = ' => $this->loginUser->id]);
        //debug($carts->toArray());
        $carts = $this->paginate($carts);
        $this->set(compact('carts'));
    }

    public function intoCart($item_id){
        $this->autoLayout = true;
        $this->autoRender = false;
        $this->viewBuilder()->setLayout('new_layout');
        //echo "This is Carts Controller." . "<br>";
        //echo $this->loginUser->name . " is Login Now!! " . "<br>";

        // Create Cart Entity
        $cart = $this->Carts->newEmptyEntity();
        $cart->user_id = $this->loginUser->id;
        $cart->item_id = $item_id;
        $cart->size = 1;
        $cart->orderd = 0; 
        $cart->created = Time::now();
        $cart->modified = Time::now();
        // save Cart Entity
        if ($this->Carts->save($cart)) {
            $this->Flash->success(__('The cart has been saved.'));
            return $this->redirect(['controller' => 'Items', 'action' => 'new-index']);
        }
        $this->Flash->error(__('The cart could not be saved. Please, try again.'));

        /** 
        $users = $this->Carts->Users->find('list', ['limit' => 200])->all();
        $items = $this->Carts->Items->find('list', ['limit' => 200])->all();
        $this->set(compact('cart', 'users', 'items'));
        */
    }

    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Users', 'Items' => 'Products'],
        ];
        $carts = $this->paginate($this->Carts);
        //debug($carts);
        $this->set(compact('carts'));
    }

    /**
     * View method
     *
     * @param string|null $id Cart id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $cart = $this->Carts->get($id, [
            'contain' => ['Users', 'Items'],
        ]);

        $this->set(compact('cart'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $cart = $this->Carts->newEmptyEntity();
        if ($this->request->is('post')) {
            $cart = $this->Carts->patchEntity($cart, $this->request->getData());
            $cart->created = Time::now();
            $cart->modified = Time::now();
            if ($this->Carts->save($cart)) {
                $this->Flash->success(__('The cart has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The cart could not be saved. Please, try again.'));
        }
        $users = $this->Carts->Users->find('list', ['limit' => 200])->all();
        $items = $this->Carts->Items->find('list', ['limit' => 200])->all();
        $this->set(compact('cart', 'users', 'items'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Cart id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $cart = $this->Carts->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $cart = $this->Carts->patchEntity($cart, $this->request->getData());
            $cart->created = Time::now();
            $cart->modified = Time::now();
            if ($this->Carts->save($cart)) {
                $this->Flash->success(__('The cart has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The cart could not be saved. Please, try again.'));
        }
        $users = $this->Carts->Users->find('list', ['limit' => 200])->all();
        $items = $this->Carts->Items->find('list', ['limit' => 200])->all();
        $this->set(compact('cart', 'users', 'items'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Cart id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $cart = $this->Carts->get($id);
        if ($this->Carts->delete($cart)) {
            $this->Flash->success(__('The cart has been deleted.'));
        } else {
            $this->Flash->error(__('The cart could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'checkCart']);
    }
}
