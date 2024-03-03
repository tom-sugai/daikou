<?php
declare(strict_types=1);

namespace App\Controller;

use Cake\I18n\Time;
use Cake\I18n\FrozenTime;
use Cake\ORM\TableRegistry;

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

    public function editCart($cartId = null){
        $this->autoLayout = true;
        $this->autoRender = true;
        //$this->viewBuilder()->setLayout('otsukai_layout');
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
                return $this->redirect(['controller' => 'Carts', 'action' => 'checkCart']);
            }
            $this->Flash->error(__('The cart could not be saved. Please, try again.'));
        }
        $users = $this->Carts->Users->find('list', ['limit' => 200])->all();
        $items = $this->Carts->Items->find('list', ['limit' => 200])->all();
        $this->set(compact('cart', 'users', 'items'));   
    }


    public function changeSize($cartId = null){
        $this->autoLayout = true;
        $this->autoRender = true;
        //$this->viewBuilder()->setLayout('otsukai_layout');
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
                return $this->redirect(['controller' => 'Carts', 'action' => 'checkOrder']);
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
        $this->viewBuilder()->setLayout('otsukai_layout');
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

    public function backCart($cartId = null){
        $this->autoLayout = true;
        $this->autoRender = false;
        //$this->viewBuilder()->setLayout('otsukai_layout');
        //echo "This is Carts Controller." . "<br>";
        echo $this->loginUser->name . " is Login Now!! " . "<br>";

        $cart = $this->Carts->get($cartId);
        $cart->orderd = 0;
        $cart->created = Time::now();
        $cart->modified = Time::now();                

        // save cart record to cartsTable
        if ($this->Carts->save($cart)) {    
            $this->Flash->success(__('Here is /Carts/order --- cartId : ' . $cartId . ' was saved.'));
            return $this->redirect(['controller' => 'Carts', 'action' => 'check_order']); 
        }
        $this->Flash->error(__('The cart could not be saved. Please, try again.'));   
    }

    public function order($cartId = null){
        $this->autoLayout = true;
        $this->autoRender = false;
        //$this->viewBuilder()->setLayout('otsukai_layout');
        //echo "This is Carts Controller." . "<br>";
        //echo $this->loginUser->name . " is Login Now!! " . "<br>";

        //$cart = $this->Carts->get($cartId);
        $cart = $this->Carts->get($cartId, [
            'contain' => ['Users', 'Items' => 'Products'],
        ]);
        $cart->orderd = 1;
        $cart->created = Time::now();
        $cart->modified = Time::now();
        $this->set('cart', $cart); 

        //debug($cart->item->jancode);
        if(($cart->item->jancode - 493000) < 0){
            $this->autoRender = true;         
            if ($this->request->is(['patch', 'post', 'put'])) {
                $cart = $this->Carts->patchEntity($cart, $this->request->getData());
                $cart->created = Time::now();
                $cart->modified = Time::now();
                // save cart record to cartsTable
                if ($this->Carts->save($cart)) {    
                    $this->Flash->success(__('Here is /Carts/order --- cartId : ' . $cartId . ' was saved.'));
                    return $this->redirect(['controller' => 'Carts', 'action' => 'check_cart']); 
                }
                $this->Flash->error(__('The cart could not be saved. Please, try again.'));
            }
        } else {
            // save cart record to cartsTable
            if ($this->Carts->save($cart)) {    
                $this->Flash->success(__('Here is /Carts/order --- cartId : ' . $cartId . ' was saved.'));
                return $this->redirect(['controller' => 'Carts', 'action' => 'check_cart']); 
            }
            $this->Flash->error(__('The cart could not be saved. Please, try again.'));   
        }
        $users = $this->Carts->Users->find('list', ['limit' => 200])->all();
        $items = $this->Carts->Items->find('list', ['limit' => 200])->all();
        $this->set(compact('cart', 'users', 'items'));
    }

    public function checkCart(){
        $this->autoLayout = true;
        $this->autoRender = true;
        $this->viewBuilder()->setLayout('otsukai_layout');
        //echo "This is Carts Controller." . "<br>";
        //echo $this->loginUser->name . " is Login Now!! " . "<br>";
        
        $this->paginate = [
            'contain' => ['Users', 'Items' => 'Products'],
        ];
        //debug($this->loginUser->id);
        $carts = $this->Carts->find()->contain(['Users', 'Items' => 'Products'])->where(['Carts.orderd = ' => 0])->where(['Carts.user_id = ' => $this->loginUser->id]);
        //debug($carts);
        $carts = $this->paginate($carts);
        $this->set(compact('carts'));
    }

    public function intoCart($item_id){
        $this->autoLayout = true;
        $this->autoRender = false;
        //echo "This is Carts Controller." . "<br>";
        //echo $this->loginUser->name . " is Login Now!! " . "<br>";

        // テーブルオブジェクトを取得
        $itemsTable = TableRegistry::getTableLocator()->get('Items');        
        $item = $itemsTable->get($item_id, [
            'contain' => ['Users', 'Products'],
        ]);
        //debug($item);

        // Create Cart Entity
        $cart = $this->Carts->newEmptyEntity();
        $cart->user_id = $this->loginUser->id;
        $cart->item_id = $item_id;
        $cart->size = 1;
        $cart->orderd = 0;
        $cart->created = Time::now();
        $cart->modified = Time::now();
        //debug($cart);
        $this->set('cart', $cart); 

        //debug($item->jancode);
        if(($item->jancode - 493000) < 0){
            $this->autoRender = true;
            //$this->viewBuilder()->setLayout('default');         
            if ($this->request->is('post')) {
                $cart = $this->Carts->patchEntity($cart, $this->request->getData());
                $cart->created = Time::now();
                $cart->modified = Time::now();
                //debug($cart);
                // save cart record to cartsTable
                if ($this->Carts->save($cart)) {    
                    $this->Flash->success(__('Here is /Carts/order --- cart->id : ' . $cart->id . ' was saved.'));
                    return $this->redirect(['controller' => 'Carts', 'action' => 'check_cart']); 
                }
                $this->Flash->error(__('The cart could not be saved. Please, try again.'));
            }
        } else {
            // save cart record to cartsTable
            if ($this->Carts->save($cart)) {    
                $this->Flash->success(__('Here is /Carts/order --- cart->id : ' . $cart->id . ' was saved.'));
                return $this->redirect(['controller' => 'Carts', 'action' => 'check_cart']); 
            }
            $this->Flash->error(__('The cart could not be saved. Please, try again.'));   
        }
        $users = $this->Carts->Users->find('list', ['limit' => 200])->all();
        $items = $this->Carts->Items->find('list', ['limit' => 200])->all();
        $this->set(compact('cart', 'users', 'items'));
    

        /** 
        // save Cart Entity
        if ($this->Carts->save($cart)) {
            $this->Flash->success(__('The cart has been saved.'));
            return $this->redirect(['controller' => 'Items', 'action' => 'otsukai']);
        }
        $this->Flash->error(__('The cart could not be saved. Please, try again.'));
        */
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
