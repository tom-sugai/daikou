<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * Details Controller
 *
 * @property \App\Model\Table\DetailsTable $Details
 * @method \App\Model\Entity\Detail[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class DetailsController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Items'],
        ];
        $details = $this->paginate($this->Details);

        $this->set(compact('details'));
    }

    /**
     * View method
     *
     * @param string|null $id Detail id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $detail = $this->Details->get($id, [
            'contain' => ['Items', 'Orders'],
        ]);

        $this->set(compact('detail'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $detail = $this->Details->newEmptyEntity();
        if ($this->request->is('post')) {
            $detail = $this->Details->patchEntity($detail, $this->request->getData());
            if ($this->Details->save($detail)) {
                $this->Flash->success(__('The detail has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The detail could not be saved. Please, try again.'));
        }
        $items = $this->Details->Items->find('list', ['limit' => 200])->all();
        $this->set(compact('detail', 'items'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Detail id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $detail = $this->Details->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $detail = $this->Details->patchEntity($detail, $this->request->getData());
            if ($this->Details->save($detail)) {
                $this->Flash->success(__('The detail has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The detail could not be saved. Please, try again.'));
        }
        $items = $this->Details->Items->find('list', ['limit' => 200])->all();
        $this->set(compact('detail', 'items'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Detail id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $detail = $this->Details->get($id);
        if ($this->Details->delete($detail)) {
            $this->Flash->success(__('The detail has been deleted.'));
        } else {
            $this->Flash->error(__('The detail could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
