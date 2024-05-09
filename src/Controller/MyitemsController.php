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
use Cake\Http\Client;
use Cake\Filesystem\Folder;
use Cake\Filesystem\File;

/**
 * Myitems Controller
 *
 * @property \App\Model\Table\MyitemsTable $Myitems
 * @method \App\Model\Entity\Myitem[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class MyitemsController extends AppController
{
    public function myItemList()
    {
        $this->paginate = [
            'contain' => ['Users', 'Products'],
        ];
        $myitems = $this->paginate($this->Myitems);

        $this->set(compact('myitems'));        
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
        $myitems = $this->paginate($this->Myitems);

        $this->set(compact('myitems'));
    }

    /**
     * View method
     *
     * @param string|null $id Myitem id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $myitem = $this->Myitems->get($id, [
            'contain' => ['Users', 'Products'],
        ]);

        $this->set(compact('myitem'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $myitem = $this->Myitems->newEmptyEntity();
        if ($this->request->is('post')) {
            $myitem = $this->Myitems->patchEntity($myitem, $this->request->getData());
            $myitem->created = Time::now();
            $myitem->modified = Time::now();
            debug($myitem->create);
            if ($this->Myitems->save($myitem)) {
                $this->Flash->success(__('The myitem has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The myitem could not be saved. Please, try again.'));
        }
        $users = $this->Myitems->Users->find('list', ['limit' => 200])->all();
        $products = $this->Myitems->Products->find('list', ['limit' => 200])->all();
        $this->set(compact('myitem', 'users', 'products'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Myitem id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $myitem = $this->Myitems->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $myitem = $this->Myitems->patchEntity($myitem, $this->request->getData());
            $myitem->created = Time::now();
            $myitem->modified = Time::now();
            debug($myitem);
            if ($this->Myitems->save($myitem)) {
                $this->Flash->success(__('The myitem has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The myitem could not be saved. Please, try again.'));
        }
        $users = $this->Myitems->Users->find('list', ['limit' => 200])->all();
        $products = $this->Myitems->Products->find('list', ['limit' => 200])->all();
        $this->set(compact('myitem', 'users', 'products'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Myitem id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $myitem = $this->Myitems->get($id);
        if ($this->Myitems->delete($myitem)) {
            $this->Flash->success(__('The myitem has been deleted.'));
        } else {
            $this->Flash->error(__('The myitem could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
