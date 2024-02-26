<?php
declare(strict_types=1);

namespace App\Controller;

use App\Controller\AppController;
use Cake\Core\Configure;
use App\Form\ConfirmForm;

class ExcViewController extends AppController
{
    private $identity;
    private $text1 = null;
    private $confirmConst = [];

    public function initialize(): void
    {
        parent::initialize();
        $this->text1 = Configure::read('text1');
        $this ->confirmConst['name'] = Configure::read('name');
        $this ->confirmConst['tel'] = Configure::read('tel');
        $this ->confirmConst['email'] = Configure::read('email');
        $this ->confirmConst['date'] = Configure::read('date');
        $this ->confirmConst['time'] = Configure::read('time');
        $this ->confirmConst['textarea'] = Configure::read('textarea');
        $this ->confirmConst['likered'] = Configure::read('likered');
        $this ->confirmConst['likeblue'] = Configure::read('likeblue');
        $this ->confirmConst['answer'] = Configure::read('answer');
        $this ->confirmConst['banks'] = Configure::read('banks');
        //debug($this->confirmConst);
        $this->set('text1', $this->text1);
        $this->set('confirmConst', $this->confirmConst);
    }

    public function beforeFilter(\Cake\Event\EventInterface $event)
    {
        parent::beforeFilter($event);

        // loginUser --- Authentication コンポーネントで取得
        $this->identity = $this->Authentication->getIdentity();
        //$this->set('loginUser', $this->identity->name);
        //debug($this->identity);
        //$this->Authentication->allowUnauthenticated(['index']);
    }

    public function index()
    {
        $message = "This is ExcViewController.php.";
        $this->set('message', $message);
        echo $this->text1 . "<---- out by echo" . "<br>";

    }

    public function confirmForm()
    {
        $this->autoLayout = true;
        $this->autoRender = true;

        $confirmForm = new ConfirmForm();
        //debug($confirmForm);
        if ($this->request->is('post')) {
            if ($confirmForm->execute($this->request->getData())) {
                $this->Flash->success('すぐにご連絡いたします。');
            } else {
                $this->Flash->error('フォーム送信に問題がありました。');
            }
        }
        //debug($confirmForm);
        $this->set(compact('confirmForm'));
    }

    public function sendForm()
    {
        $this->autoLayout = true;
        $this->autoRender = true;


    }

    public function showTable()
    {
        $this->autoLayout = true;
        $this->autoRender = true;

    }

    public function receiveCakeForm()
    {
        $this->autoLayout = true;
        $this->autoRender = true;

        $str = $this->request->getData('text-1');
        echo "Your input is " . $str . "<br>";
        $telno = $this->request->getData('telno');
        echo "Your telno is " . $telno . "<br>";
        $email = $this->request->getData('email');
        echo "Your Email is " . $email . "<br>";

        $dt = $this->request->getData('date');
        echo "Today is " . $dt . "<br>";
        $time = $this->request->getData('time');
        echo "Now time is " . $time . "<br>";

        $message = $this->request->getData('textarea');
        echo "Your message is " . "\"" . $message . "\"" . "<br>";

        if($_POST['check-1'] !== 'off')
        { $red = "yes";} else { $red = "no";}
        echo "like red ? " . $red . "<br>";

        if($_POST['check-2'] !== 'off')
        { $blue = "yes";} else { $blue = "no";}
        echo "like blue ? " . $blue . "<br>";        

        echo "choice-1 : " . $_POST['anser'] . "<br>";
        echo "choice-2 : " . $_POST['account'] . "<br>";

        if($_POST['select-1']){
            $banks = $_POST['select-1'];  // $bank is array which allow for mulitiple select
            foreach($banks as $bank){
                echo "selected bank code : " . $bank . "<br>"; 
            }    
        } else {
            echo "Please select bank!!" . "<br";
        }       
        
        
    }

    public function receiveHtmlForm()
    {
        $str = $_POST['text-1'];
        echo "Your input is " . $str . "<br>";
        $telno = $_POST['telno'];
        echo "Your telno is " . $telno . "<br>";
        $email = $_POST['email'];
        echo "Your Email is " . $email . "<br>";

        $dt = $_POST['date'];
        echo "Today is " . $dt . "<br>";
        $time = $_POST['time'];
        echo "Now time is " . $time . "<br>";

        $message = $_POST['textarea'];
        echo "Your message is " . "\"" . $message . "\"" . "<br>";

        if($_POST['check-1'] !== 'off')
        { $red = "yes";} else { $red = "no";}
        echo "like red ? " . $red . "<br>";

        if($_POST['check-2'] !== 'off')
        { $blue = "yes";} else { $blue = "no";}
        echo "like blue ? " . $blue . "<br>";        

        echo "choice-1 : " . $_POST['anser'] . "<br>";
        echo "choice-2 : " . $_POST['account'] . "<br>";

        if($_POST['select-1']){
            $banks = $_POST['select-1'];  // $bank is array which allow for mulitiple select
            foreach($banks as $bank){
                echo "selected bank code : " . $bank . "<br>"; 
            }    
        } else {
            echo "Please select bank!!" . "<br";
        }       
    }
}