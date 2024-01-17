<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Error\Debugger;
use Cake\ORM\TableRegistry;
use Cake\Event\EventInterface;
//use Cake\Event\Event;
use Cake\I18n\Time;
use Cake\I18n\FrozenTime;
use Cake\Http\Client;
use Cake\Filesystem\Folder;
use Cake\Filesystem\File;

class AddItemController extends AppController
{
    private $csv_array      = [];
    private $client_array   = [];
    //private $productArray   = [];
    private $itemArray      = [];
    private $clientEmail;

    public function initialize():void
    {
        parent::initialize();
        $this->loadComponent('Flash');
        $this->loadComponent('Math', [
            'precision' => 2,
            'randomGenerator' => 'srand'
        ]);
    }

    public function beforeFilter(EventInterface $event)
    {
        parent::beforeFilter($event);

        // get csv file list
        $dir = new Folder('data');
        $this->csv_array = $dir->find('.*\.csv');

        // usersテーブルのオブジェクトを取得
        $usersTable = TableRegistry::getTableLocator()->get('Users');
        // get client list
        $this->client_array = $usersTable->find()
            ->where(['OR' => ['role =' => 'client', 'role' => 'editor', 'role' => 'admin']])
            ->all()
            ->extract('email')
            ->toArray();

        // アプリケーション内のすべてのメソッドをパブリックにし、認証チェックをスキップします
        //$this->Authentication->addUnauthenticatedActions(['index','view']);
    }

    public function afterFilter(EventInterface $event)
    {
        parent::afterFilter($event);
        //debug($this->response);
    }

    public function setCsvClientList()
    {
        $this->autoLayout = true;
        $this->autoRender = true;
        $this->viewBuilder()->setLayout('default');

        // pass file list to view
        $this->set('csv_list', $this->csv_array);

        // pass client list to view
        $this->set('client_list', $this->client_array);
    }

    public function getCsvClientName()
    {
        $this->autoLayout = true;
        $this->autoRender = true;

        echo "This is getCsvClientName method !!" . "<br><br>";

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
            $csvFile =  $this->csv_array[$result1];
        }
        //debug($csvName);

        // check Client Name
        if($result2 != null){
            $this->clientEmail = $this->client_array[$result2];
            //debug($this->clientEmail);
        }

        // go to next action;
        $this->setAction('readCsvFile', $csvFile);   
    }

    public function readCsvFile($csvFile)
    {
        $this->autoLayout = true;
        $this->autoRender = true;

        echo "This is readCsvFile method !!" ." <br><br>";

        // 商品リスト（csv file: /webroot/data/）を読み込んで配列(items)に格納
        // $file-path ='data/file-name.csv'
        $csv_path = "data/" . $csvFile;
        $file = fopen($csv_path, 'r');
        $jancodeList = [];
        $idx = 0;
        while(feof($file) == False) {
            $jancodeList[$idx] = fgetcsv($file, 100);
            $idx++;
        }
        $this->set('jancodeList', $jancodeList);
        $this->setAction('checkExistProductsTable', $jancodeList);
    }

    public function checkExistProductsTable($jancodeList)
    {
        $this->autoLayout = false;
        $this->autoRender = false;

        // テーブルオブジェクトを取得
        $productsTable = TableRegistry::getTableLocator()->get('Products');
        // exist in the Products Table ? search jancode !
        $jancodeList2 =[];
        $idx = 0;
        foreach ($jancodeList as $jancode){
            $jcode = $jancode[4];
            $query = $productsTable->find();
            $result = $query->where(['jancode = ' => $jcode])->toArray();
            //debug($result);
            if ($result == null){
                //debug($jcode);
                // if not exist in the Products Table ---> add $jcode to $jancodeList2[$idx]
                $jancodeList2[$idx] =  $jcode;
                //debug($jancodeList2[$idx]);
                $idx++;
            }
        }
        //debug($jancodeList2);
        if($jancodeList2 != null){   // there are some items that did'nt enter in the Products table.
            echo "These jancode items are not exist in the Products table. !!" . "<br>";
            echo "Please enter these jancode items to the Products table !!" . "<br><br>";
            $this->setAction('echoProductList', $jancodeList2);
        } else {
            echo "There are all items in the Products table. !!" . "<br><br>";
            $this->setAction('checkExistItemsTable', $jancodeList);       
        }   
    }

    public function echoProductList($jancodeList2){
        $this->autoLayout = true;
        $this->autoRender = true;
        $this->set('jancodeList2', $jancodeList2);
    }

    public function checkExistItemsTable($jancodeList)  //for test
    {
        $this->autoLayout = false;
        $this->autoRender = false;

        // テーブルオブジェクトを取得
        $usersTable = TableRegistry::getTableLocator()->get('Users');
        $itemsTable = TableRegistry::getTableLocator()->get('Items');

        // Client objectを取得する
        $client = $usersTable->find()->where(['email = ' => $this->clientEmail])->toArray();
        // user_id = $client[0]['id']

        // exist in the Items Table ? search jancode and user_id !!
        $jancodeList2 =[];
        $idx = 0;
        foreach ($jancodeList as $jancode){   //for test
            $jcode = $jancode[4];
            $query = $itemsTable->find();
            $result = $query->where(['jancode = ' => $jcode])->where(['user_id =' => $client[0]['id']])->toArray();
            //debug($result);
            if ($result == null){
                // if not exist in the Items Table ---> add $jcode to $jancodeList2[$idx]
                $jancodeList2[$idx] =  $jcode;
                $idx++;
            }
        }
        //debug($jancodeList2);
        if($jancodeList2 != null){
            $this->setAction('buildItemArray', $jancodeList2);            
        }
        echo "The AddItem process completed !!" . "<br><br>";    
    }

    public function buildItemArray($jancodeList2)
    {
        $this->autoLayout = true;
        $this->autoRender = true;

        echo "This is buldItemArray() method !!" . "<br><br>";

        // テーブルオブジェクトを取得
        $usersTable = TableRegistry::getTableLocator()->get('Users');
        // Client objectを取得する
        $client = $usersTable->find()->where(['email = ' => $this->clientEmail])->toArray();
        // user_id = $client[0]['id']

        // Product テーブルからjancodeをキーにして商品情報を検索し、 private $itemArray = [] に格納する
        // 検索した商品情報を AddItemContoroller 内で共有する
        // productsテーブルのオブジェクトを取得
        $productsTable = TableRegistry::getTableLocator()->get('Products');

        // set $itemArray
        $itemArray = $this->itemArray;
        // $itemArray のインデックスの初期値
        $idx = 0;

        foreach ($jancodeList2 as $jcode){
            // $jancodeList2 から $jcode を取り出してProduct テーブルを検索する
            // 検索結果から user_id, product_id, janCode、store を、配列 $itemArray へ格納する

            // get products object from Products table
            $product = $productsTable->find()
                ->where(['jancode =' => $jcode])
                ->all()
                ->toArray();
            //debug($product);
            if($product != null){
                // Query Success
                // user_id
                $itemArray[$idx]['user_id'] = $client[0]['id'];
                // product_id
                $itemArray[$idx]['product_id'] = $product[0]['id'];
                // jancode
                $itemArray[$idx]['jancode'] = $product[0]['jancode'];
                // store empty
                $itemArray[$idx]['store'] = null;
                //debug($itemArray[$idx]);
            } else {
                echo $jcode . " : " . "Can not get Item Info from Products Table" . "<br>";
            }
            $idx++;
        }
        //debug($itemArray);

        // go echo_item_list
        $this->setAction('echoItemList', $itemArray);
        // go storItem()
        $this->setAction('storeItem', $itemArray);
    }

    public function echoItemList($itemArray){
        $this->autoLayout = true;
        $this->autoRender = true;
        $this->set('itemArray', $itemArray);
    }

    public function storeItem($itemArray)
    {
        $this->autoLayout = false;
        $this->autoRender = false;

        echo "This is storeItem() method !!" . "<br><br>";

        // テーブルオブジェクトを取得
        $itemsTable = TableRegistry::getTableLocator()->get('Items');

        // set item properties 
        foreach($itemArray as $item){
            // check exist using jancode
            $query = $itemsTable->find();
            // exist check for each item in the Items table using jancode and user_id
            $result = $query->where(['user_id =' => $item['user_id']])->where(['jancode = ' => $item['jancode']])->toArray();
            if ($result == null){   // not exist
                // create empty Entity
                $itemObj = $itemsTable->newEmptyEntity();
                // set $item properties
                $itemObj->user_id = $item['user_id'];
                $itemObj->product_id = $item['product_id'];
                $itemObj->jancode = $item['jancode'];
                $itemObj->store = $item['store'];
                $itemObj->created = Time::now();
                $itemObj->modified = Time::now();                
                // save $itemObj
                if ($itemsTable->save($itemObj)) {
                    //$this->Flash->success(__('The item has been saved.'));
                    echo $itemObj->jancode . " : " . "The item has been saved." . "<br/>";
                    echo "-------------------------------------------------" . "<br/>";                    
                } else {
                    //$this->Flash->error(__('The item could not be saved. Please, try again.'));
                    echo "The item could not be saved. Please Please, try again." . "<br/>";
                }
            } else {
                echo "Record exist!!" . "<br/>";
                echo "-------------------------------------------------" . "<br/>";  
            }
        }
    }


}