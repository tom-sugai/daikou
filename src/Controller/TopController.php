<?php
declare(strict_types=1);

namespace App\Controller;

class TopController extends AppController
{
    public function beforeFilter(\Cake\Event\EventInterface $event)
    {
        parent::beforeFilter($event);
        $this->Authentication->allowUnauthenticated(['index']);
    }
 
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $this->autoLayout = true;
        $this->autoRender = true;
        $this->viewBuilder()->setLayout('new_layout');
        
        $msg = "Message from TopCntroller!!";
        $this->set('msg', $msg);

        /**  
        // Authentication コンポーネントで取得
        $user = $this->Authentication->getIdentity();
        $username = $user->name;
        $this->set(compact('username'));
        $userid = $user->id;
        $this->set(compact('userid'));
        
        
            
        debug($user);
        debug($user->name);
        debug($user->email);
    
        echo '<h1>2. request で取得</h1>';
        $user = $this->request->getAttribute('identity');
        debug($user);
        debug($user->name);
        debug($user->email);
        */
    }

}