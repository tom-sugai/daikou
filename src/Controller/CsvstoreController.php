<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * Csvstore Controller
 *
 * @property \App\Model\Table\CsvstoreTable $Csvstore
 * @method \App\Model\Entity\Csvstore[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class CsvstoreController extends AppController
{
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
        $csvstore = $this->paginate($this->Csvstore);

        $this->set(compact('csvstore'));
    }

    /**
     * View method
     *
     * @param string|null $id Csvstore id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $csvstore = $this->Csvstore->get($id, [
            'contain' => ['Users', 'Products'],
        ]);

        $this->set(compact('csvstore'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $csvstore = $this->Csvstore->newEmptyEntity();
        if ($this->request->is('post')) {
            $csvstore = $this->Csvstore->patchEntity($csvstore, $this->request->getData());
            if ($this->Csvstore->save($csvstore)) {
                $this->Flash->success(__('The csvstore has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The csvstore could not be saved. Please, try again.'));
        }
        $users = $this->Csvstore->Users->find('list', ['limit' => 200])->all();
        $products = $this->Csvstore->Products->find('list', ['limit' => 200])->all();
        $this->set(compact('csvstore', 'users', 'products'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Csvstore id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $csvstore = $this->Csvstore->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $csvstore = $this->Csvstore->patchEntity($csvstore, $this->request->getData());
            if ($this->Csvstore->save($csvstore)) {
                $this->Flash->success(__('The csvstore has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The csvstore could not be saved. Please, try again.'));
        }
        $users = $this->Csvstore->Users->find('list', ['limit' => 200])->all();
        $products = $this->Csvstore->Products->find('list', ['limit' => 200])->all();
        $this->set(compact('csvstore', 'users', 'products'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Csvstore id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $csvstore = $this->Csvstore->get($id);
        if ($this->Csvstore->delete($csvstore)) {
            $this->Flash->success(__('The csvstore has been deleted.'));
        } else {
            $this->Flash->error(__('The csvstore could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
