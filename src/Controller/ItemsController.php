<?php
declare(strict_types=1);

namespace App\Controller;

use App\Controller\AppController;
use Cake\Error\Debugger;
use Cake\ORM\TableRegistry;
use Cake\Event\EventInterface;
use Cake\Event\Event;
use Cake\I18n\Time;
use Cake\I18n\FrozenTime;

/**
 * Items Controller
 *
 * @property \App\Model\Table\ItemsTable $Items
 * @method \App\Model\Entity\Item[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class ItemsController extends AppController
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

        $this->Authentication->allowUnauthenticated(['new-index']);
    }

    public function newIndex(){
        $this->autoLayout = true;
        $this->autoRender = true;
        $this->viewBuilder()->setLayout('new_layout');

        $this->paginate = [
            'contain' => ['Users', 'Products'],
            'limit' => 10
        ];

        // productsテーブルのオブジェクトを取得
        $productsTable = TableRegistry::getTableLocator()->get('Products');
        // create category_list
        $category_list = array_values(array_unique($productsTable->find()->all()->extract('category')->toArray()));
        $this->set('category_list', $category_list);
        //debug($category_list);

        $result = "";
        if ($this->request->isPost()){
            //$result = $this->request->data['select-1']; <-- old expression
            $result = $this->request->getData('select-1');
            //debug($result);
        }
        //debug($category_list[$result]);
        //debug($this->loginUser);
        if ( $result == null) {
            //$items = $this->Items->find('all');
            $items = $this->Items->find()->contain(['Products'])->where(['Items.user_id = ' => $this->loginUser->id]);
            //debug($items->toArray());
        }   else {
            $items = $this->Items->find()->contain(['Products'])->where(['Items.user_id =' => $this->loginUser->id])->where(['category =' => $category_list[$result]]);
            //debug($items->toArray());
        }
        $this->set('items', $this->paginate($items));
    }

    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Users', 'Products'],
        ];
        $items = $this->paginate($this->Items);

        $this->set(compact('items'));
    }

    /**
     * View method
     *
     * @param string|null $id Item id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $item = $this->Items->get($id, [
            'contain' => ['Users', 'Products'],
        ]);

        $this->set(compact('item'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $item = $this->Items->newEmptyEntity();
        if ($this->request->is('post')) {
            $item = $this->Items->patchEntity($item, $this->request->getData());
            if ($this->Items->save($item)) {
                $this->Flash->success(__('The item has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The item could not be saved. Please, try again.'));
        }
        $users = $this->Items->Users->find('list', ['limit' => 200])->all();
        $products = $this->Items->Products->find('list', ['limit' => 200])->all();
        $this->set(compact('item', 'users', 'products'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Item id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $item = $this->Items->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $item = $this->Items->patchEntity($item, $this->request->getData());
            if ($this->Items->save($item)) {
                $this->Flash->success(__('The item has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The item could not be saved. Please, try again.'));
        }
        $users = $this->Items->Users->find('list', ['limit' => 200])->all();
        $products = $this->Items->Products->find('list', ['limit' => 200])->all();
        $this->set(compact('item', 'users', 'products'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Item id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $item = $this->Items->get($id);
        if ($this->Items->delete($item)) {
            $this->Flash->success(__('The item has been deleted.'));
        } else {
            $this->Flash->error(__('The item could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
