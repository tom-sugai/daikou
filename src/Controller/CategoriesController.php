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
use Cake\Utility\Hash;

/**
 * Categories Controller
 *
 * @property \App\Model\Table\CategoriesTable $Categories
 * @method \App\Model\Entity\Category[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class CategoriesController extends AppController
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
            $this->Authentication->addUnauthenticatedActions(['index', 'selectCsvClient']);
        }
    
        public function afterFilter(EventInterface $event)
        {
            parent::afterFilter($event);
            //debug($this->response);
        }

    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $categories = $this->paginate($this->Categories);

        $this->set(compact('categories'));
    }

    /**
     * View method
     *
     * @param string|null $id Category id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $category = $this->Categories->get($id, [
            'contain' => [],
        ]);

        $this->set(compact('category'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $category = $this->Categories->newEmptyEntity();
        if ($this->request->is('post')) {
            $category = $this->Categories->patchEntity($category, $this->request->getData());
            if ($this->Categories->save($category)) {
                $this->Flash->success(__('The category has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The category could not be saved. Please, try again.'));
        }
        $this->set(compact('category'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Category id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $category = $this->Categories->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $category = $this->Categories->patchEntity($category, $this->request->getData());
            if ($this->Categories->save($category)) {
                $this->Flash->success(__('The category has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The category could not be saved. Please, try again.'));
        }
        $this->set(compact('category'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Category id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $category = $this->Categories->get($id);
        if ($this->Categories->delete($category)) {
            $this->Flash->success(__('The category has been deleted.'));
        } else {
            $this->Flash->error(__('The category could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
    
    public function main():void
    {
        $this->autoLayout = true;
        $this->autoRender = true;
        // There is no main template.
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
        $this->setAction('cleanAndValidateCsv', $this->csvFile);
    }

    public function cleanAndValidateCsv($csvFile)
    {   
        $this ->autoLayout = false;
        $this->autoRender = true;
        echo "2. ------------------------------" . "<br>";
        echo "This is cleanAndValidateCsv() ." ."<br>";

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
        // read from 2nd data line until end.
        while(!feof($file))
        {
            $data[] = fgetcsv($file, 1000);
            //$lines++;
        }
        fclose($file);
        // remove array element top ( title line )
        $remove_top = array_shift($data);
        // remove array element end ( null line )        
        $remove_end = array_pop($data);
        // datalines after remove
        $lines = count($data);
        echo "datalines after remove top & end : $lines" . "<br>";
        // check data[], 
        // $j is line conuter. start from 1. becouse vscode editor line count start 1.
        echo "------------------------" . "<br>";
        $bad_data_list = [];
        $j = 2;
        foreach($data as $data_row)
        {
            if($data_row != null)
            {    
                // echo item list in the csv file    
                echo "$j : ";  
                for( $i=0; $i < $n; $i++){
                    echo $data_row[$i] . " | ";
                }
                echo "<br>";
                // check data[0] ---- NOT NULL & foreign key constraint to Categories_category1
                if($data_row[0] == null){
                    $bad_data_list[] =+ $j;
                    echo "No. $j data_category1 is null" . "<br>";
                }
                // check data[1] ---- NOL NULL & foreign key constraint to Categories_category2
                if($data_row[1] == null){
                    $bad_data_list[] =+ $j;
                    echo "No. $j data_category2 is null" . "<br>";
                }
               // create category3_list[] for check data_row[2] : allow null
                if($data_row[2] != null){
                    $category3_list[$j] = $data_row[2];
                    //debug($category3_list);
                }
            }
            $j++;                
        }
        // check category3 ---- allow NULL & UNIQE as data array
        debug($category3_list);
        $arr = array_count_values($category3_list);
        foreach($arr as $key => $val){
            if($val != 1){
                echo "$key is not UNIQUE !!" . "<br>"; 
            }
        }
        // echo error data info
        debug($bad_data_list); 
        // go to next action;
        if($bad_data_list == null){
            $this->setAction('csvSave', $data);
        }
        //$this->setAction('makeArray', $data);
    }

    public function makeArray($data):void
    {
        //debug($data);
        $n = count($data);
        $new_data = [];

        /** 
        for($i=0; $i <= $n - 1; $i++){
            $new_data += [
                $i => [$data[$i][0] => [ $data[$i][1] => [ $data[$i][2] => $data[$i][2] ]]]
            ];
        }
        */

        for($i=0; $i <= $n - 1; $i++){
            $new_data += [
                $i => ["大分類" => $data[$i][0], "中分類" => $data[$i][1], "小分類" => $data[$i][2]]
            ];
        }

        //debug($new_data);

        //echo $new_data[2]['食品']['野菜果物']['果物'] . "<br>";

        //$results = Hash::extract($new_data, '{n}[大分類=食品][中分類=卵牛乳乳製品].小分類');
        $results = Hash::extract($new_data, '{n}[大分類=食品]{s}.小分類');
        //$results = Hash::extract($new_data, '{n}[大分類=日用雑貨]{s}.小分類');
        debug($results);
    }

    public function csvSave($data):void
    {
            // recordCount
            $savedcsv = 0;
            // csv_row data read
            foreach ($data as $rowdata){                   
                // create Category object
                $Category = $this->Categories->newEmptyEntity();
                    // set category1-3= rowdata[0-2]
                    $Category->category1 = $rowdata[0];     // 大分類
                    $Category->category2 = $rowdata[1];     // 中分類
                    $Category->category3 = $rowdata[2];     // 小分類
                    //debug($Category);

                    // save object
                    if ($this->Categories->save($Category)) {
                        $this->Flash->success(__('The Category has been saved.'));
                        $savedcsv++;
                        //return $this->redirect(['action' => 'index']);
                    } else {
                        $this->Flash->error(__('The Category could not be saved. Please, try again.'));
                    }
            }
            echo "$savedcsv rows saveed." . "<br>";
    }

}
