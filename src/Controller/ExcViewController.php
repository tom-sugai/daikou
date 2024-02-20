<?php
declare(strict_types=1);

namespace App\Controller;

class ExcViewController extends AppController
{
    private $identity;

    public function initialize(): void
    {
        parent::initialize();
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