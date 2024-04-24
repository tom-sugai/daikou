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
 * Csvstore Controller
 *
 * @property \App\Model\Table\CsvstoreTable $Csvstore
 * @method \App\Model\Entity\Csvstore[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class CsvstoreController extends AppController
{
    // Csv files list form webroot/Data 
    private $csv_list;
    // User email address list from Users table     
    private $client_list;
    // selected csv file name in the Form    
    private $csvFile;
    // selected client name in the Form
    private $clientEmail;
    private $clientId;

    // for test
    private $family;

    //private $productArray   = [];
    //private $itemArray      = [];

    public function initialize():void
    {
        parent::initialize();
        $this->loadComponent('Flash');
    }

    public function beforeFilter(EventInterface $event)
    {
        parent::beforeFilter($event);

        //initialize array
        $this->csv_list = [];
        $this->client_list = [];

        // get csv file list
        $dir = new Folder('data');
        $this->csv_list = $dir->find('.*\.csv');
        
        // usersテーブルのオブジェクトを取得
        //$usersTable = TableRegistry::getTableLocator()->get('Users');
        $usersTable = $this->loadModel('Users');
        // get client list
        $this->client_list = $usersTable->find()
            ->where(['OR' => ['role =' => 'client', 'role' => 'editor', 'role' => 'admin']])
            ->all()
            ->extract('email')
            ->toArray();

        // for test
        //$this->csvFile = 'xxxx';
        //$this->clientEmail = 'zzzz';

        // アプリケーション内のメソッドの認証チェックをスキップします
        $this->Authentication->addUnauthenticatedActions(['index','setListCsvClient']);
    }

    public function afterFilter(EventInterface $event)
    {
        parent::afterFilter($event);
        //debug($this->response);
    }

    public function main():void
    {
        $this->autoLayout = true;
        $this->autoRender = true;

        $this->setAction('selectCsvClient');
    }

    /**
     * select Csv file and Client name from Form 
     * this method kick Form
     */
    public function selectCsvClient()
    {
        $this->set('csv_list', $this->csv_list);
        $this->set('client_list', $this->client_list);
    }

    /**
     * call from Form(setListCsvClient()) action
     * get selected Csv file name & set Class constant
     */
    public function getCsvClient():void
    {
        $this->autoLayout = true;
        $this->autoRender = true;
        echo "1. ------------------------------" . "<br>";
        echo "This is getCsvFile() method !!" . "<br>";
    
        // get selected csv file & Client Name

        // set selected value to result
        $result1 = "";
        $result2 = "";
        // get value from Form
        if ($this->request->isPost()){
            $result1 = $this->request->getData('select-1');
            $result2 = $this->request->getData('select-2');
        }
        // pass to view for confirm
        $this->set('result1', $result1);
        $this->set('result2', $result2);
        // check csv name
        if($result1 != null){
            //debug($this->csv_list);
            $this->csvFile =  $this->csv_list[$result1];
            echo $this->csvFile . "<br>";
        }
        // check Client Name
        if($result2 != null){
            //debug($this->client_list);
            $this->clientEmail = $this->client_list[$result2];
            echo $this->clientEmail . "<br>";
        }

        //go to checkCsv()
        $this->setAction('checkCsv', $this->csvFile);
    }

    public function checkCsv($csvFile)
    {   
        $this ->autoLayout = false;
        $this->autoRender = true;
        echo "2. ------------------------------" . "<br>";
        echo "This is checkCsv() ." ."<br>";

        // prepare variables
        $data = [];
        // open csv file
        $file = fopen("data/$csvFile",'r');
        // read 1st title line
        $data[] = fgetcsv($file,1000);
        // check n : number of columns in this csv file
        $n = count($data[0]);  
        echo $n . " columns in this csv file <br>";
        // first line's title print
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
                /** 
                // echo item list in the csv file
                echo "$j : ";  
                for( $i=0; $i < $n; $i++){
                    echo $ary_line[$i] . " | ";
                }
                echo "<br>";
                */
                
                // check jancode columns
                //　正規表現の判定関数を記述する : $ary_line[4] != "13桁の数字"
                $str = $ary_line[4];
                //$pattern = "/[0-9]{13}/";
                $pattern = "/[0-9]{8,13}/";
                if(!preg_match( $pattern, $str, $result )){
                    echo "line No. : $j is bad data : " . $str . "<br>";
                    // set line-no to bad_data_list(array) 
                }
            }                
        }
        echo "find last data(= blank line). line No. $j is null(on line order csv file)" . "<br>";
        $k = $j - 2;
        echo "There are $k data lines in this csv file." . "<br>";
        // remove bad data from data array using bad_data_list

        // go to next action;
        $this->setAction('checkExistDb', $data); // change pass parameter to $data
    }

    /**
     * parameter $data pass from checkCsv()
     */
    public function checkExistDb($data)
    {
        $this->autoLayout = true;
        $this->autoRender = true;
        echo "4. ------------------------------" . "<br>";
        echo "This is checkExistDb() ." ."<br>";

        // remove last blank line
        $remove_last = array_pop($data);
        //debug($data);
        // テーブルオブジェクトを取得
        $productsTable = $this->loadModel('Products');
        $usersTable = $this->loadModel('Users');
        // get user_id from $this->clientEmail
        $user = $usersTable->find()
            ->where(['email = ' => $this->clientEmail])
            ->first();
        // exist? in the Products Table
        $unExistList =[];
        $lineno = 1;
        // search jancode & create unExistList[]
        foreach ($data as $rowdata){
            //debug($rowdata);
            $jancode = $rowdata[4];
            //debug($jancode);
            $result = $productsTable->find()
                ->where(['jancode = ' => $jancode])
                ->first();
            //debug($result);

            if ($result != null){
                echo "lineNo : $lineno ---- $jancode exist" . "<br>";

                // create Csvstore object
                $csvstore = $this->Csvstore->newEmptyEntity();
                    // set user_id
                    $csvstore->user_id = $user->id;
                    // set csv name
                    $csvstore->csvname = $this->csvFile;
                    // set flag 1 to Csvstore->existpdb and set lineno, codeformat
                    $csvstore->existpdb = 1;
                    $csvstore->lineno = $lineno;
                    $csvstore->codeformat = $rowdata[3];
                    // set jancode to Csvstore->code
                    $csvstore->code = $jancode;
                    // set product_id to Csvstore->product_id
                    $csvstore->product_id = $result->id;
                    //debug($csvstore->code);
                // save object
                //if ($this->request->is('post')) {
                //    $csvstore = $this->Csvstore->patchEntity($csvstore, $this->request->getData());
                    if ($this->Csvstore->save($csvstore)) {
                        $this->Flash->success(__('The csvstore has been saved.'));
        
                        //return $this->redirect(['action' => 'index']);
                    } else {
                        $this->Flash->error(__('The csvstore could not be saved. Please, try again.'));
                    }
                //}
            } else { 
                // if did'nt exist in the Products Table ---> add $jancode to $unExistList[]
                $unExistList[] =  $jancode;
            }
            $lineno++;
        }

        // go to next step
        if($unExistList != null){
            //$this->setAction('buildProductArray', $unExistList);            
        }

        echo "New Product is Nothing!!" . "<br>";
        $this->render();
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
