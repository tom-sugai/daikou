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

class EditCsvController extends AppController
{
    private $csv_list      = [];
    private $client_list   = [];
    private $productArray   = [];
    private $itemArray      = [];

    public function initialize():void
    {
        parent::initialize();
        $this->loadComponent('Flash');
    }

    public function beforeFilter(EventInterface $event)
    {
        parent::beforeFilter($event);

        // get csv file list
        $dir = new Folder('data');
        $this->csv_list = $dir->find('.*\.csv');
        
        // usersテーブルのオブジェクトを取得
        $usersTable = TableRegistry::getTableLocator()->get('Users');

        // get client list
        $this->client_list = $usersTable->find()
            ->where(['OR' => ['role =' => 'client', 'role' => 'editor', 'role' => 'admin']])
            ->all()
            ->extract('email')
            ->toArray();

        // アプリケーション内のメソッドの認証チェックをスキップします
        $this->Authentication->addUnauthenticatedActions(['index','setListCsvClient']);
    }

    public function afterFilter(EventInterface $event)
    {
        parent::afterFilter($event);
        //debug($this->response);
    }

    public function index()
    {
        $this->autoLayout = true;
        $this->autoRender = false;
        $this->viewBuilder()->setLayout('default');

        echo "hello From EditCsv/index()" . "<br>";
    }

    public function setListCsvClient(){
        $this->autoLayout = true;
        $this->autoRender = true;
        $this->viewBuilder()->setLayout('default');
        echo "0. ------------------------------" . "<br>";
        echo "This is setListCsvClient() method !!" . "<br>";

        // pass file list to view
        $this->set('csv_list', $this->csv_list);

        // pass client list to view
        $this->set('client_list', $this->client_list);
    }

    public function getNameCsvClient(){
        $this->autoLayout = true;
        $this->autoRender = true;
        echo "1. ------------------------------" . "<br>";
        echo "This is getCsvFile() method !!" . "<br>";
    
        // select csv file & Client Name
        $result1 = "";
        $result2 = "";
        // get Form
        if ($this->request->isPost()){
            $result1 = $this->request->getData('select-1');
            $result2 = $this->request->getData('select-2');
        }
        $this->set('result1', $result1);
        $this->set('result2', $result2);
        // check csv name
        if($result1 != null){
            $csvFile =  $this->csv_list[$result1];
            echo $csvFile . "<br>";
        }
        // check Client Name
        if($result2 != null){
            $clientEmail = $this->client_list[$result2];
            echo $clientEmail . "<br>";
        }
        //go to checkCsv()
        $this->setAction('checkCsv', $csvFile);  
    }

    public function checkCsv($csvFile)
    {   
        $this ->autoLayout = false;
        $this->autoRender = true;
        echo "2. ------------------------------" . "<br>";
        echo "This is checkCsv() ." ."<br>";

        // prepare variables
        $data = [];
        //$lines = 0;

        // open csv file
        $file = fopen("data/$csvFile",'r');
        // read 1st title line
        $data[] = fgetcsv($file,1000);
        //debug($data);
        // check n : number of columns in this csv file
        $n = count($data[0]);  
        echo $n . " columns in this csv file <br>";

        //print_r($data);
        for($i=0; $i<$n; $i++){
             $element = $data[0][$i];
             echo "$i : $element , ";
        }
        echo "<br>";
        echo "format : kind of code such as jancode," . " text : code(numeric)" . "<br>";

        // read from 2nd data line until end.
        while(!feof($file))
        {
            $data[] = fgetcsv($file, 1000);
            //$lines++;
        }
        fclose($file);

        // remove array element top ( title line )
        $remove_top = array_shift($data);

        // check data[], jancode column of eache line in $ary_line[4]
        // $j is line conuter. start from 1. becouse vscode editor line count start 1.
        echo "------------------------" . "<br>";
        $j = 1;
        foreach($data as $ary_line)
        {
            $j++;
            if($ary_line != null)
            {    
                for( $i=0; $i < $n; $i++){
                    echo $ary_line[$i] . " | ";
                }
                echo "<br>";
                

                // check jancode ketasuu
                //　正規表現の判定関数を記述する : $ary_line[4] != "13桁の数字"
                $str = $ary_line[4];
                //$pattern = "/[0-9]{13}/";
                $pattern = "/[0-9]{8,13}/";
                if(!preg_match( $pattern, $str, $result )){
                    echo "line No. : $j is bad data : " . $str . "<br>";
                }
            }                
        }
        echo "find last data(= blank line). line No. $j is null(on line order csv file)" . "<br>";
        $k = $j - 2;
        echo "There are $k data lines in this csv file." . "<br>";

        // go to next action;
        //$this->setAction('readJancodeCsv', $csvFile); 
    }


}