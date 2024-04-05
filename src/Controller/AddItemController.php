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
    private $loginUser;
    private $csv_array      = [];
    private $client_array   = [];
    //private $productArray   = [];
    private $itemArray      = [];
    private $clientEmail;
    private $mycategory;

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

        // loginUser --- Authentication コンポーネントで取得
        $this->loginUser = $this->Authentication->getIdentity();

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

    public function setCsvListClientList()
    {
        $this->autoLayout = true;
        $this->autoRender = true;
        $this->viewBuilder()->setLayout('default');

        // pass file list to view
        $this->set('csv_list', $this->csv_array);

        // pass client list to view
        $this->set('client_list', $this->client_array);
    }

    public function getCsvFileClientName()
    {
        $this->autoLayout = true;
        $this->autoRender = true;

        echo "This is getCsvFileClientName method !!" . "<br><br>";

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
        //debug($csvFile);

        // check Client Name
        if($result2 != null){
            $this->clientEmail = $this->client_array[$result2];
            //debug($this->clientEmail);
        }

        //debug($this->loginUser->name);
        $userName = $this->loginUser->name;
        echo "login user : $userName" . "<br><br>";

        // extract csvFile name without .csv extension
        // $mycategory = csvFile name;
        // $csvfilename = "台所用品.csv"; forrtest
        $mycategory = str_replace( '.csv', '', $csvFile);
        echo "mycategory is $mycategory " . "<br><br>";
 
        // go to next action
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
        $header_line = fgetcsv($file, 1000);  // skip header line
        $itemList = [];
        $count = 0;
        while(feof($file) == False) {
            $itemList[$count] = fgetcsv($file, 1000);
            $count++;
        }
        $rt = array_pop($itemList); // remove last line ( is blank line)
        //debug($itemList);
        $this->set('itemList', $itemList);
        $this->setAction('checkExistProductsTable', $itemList);
    }

    public function checkExistProductsTable($itemList)
    {
        $this->autoLayout = false;
        $this->autoRender = false;
        echo "This is checkExistProductsTable." . "<br><br>";

        // テーブルオブジェクトを取得
        $productsTable = TableRegistry::getTableLocator()->get('Products');
        // exist in the Products Table ? search jancode !
        $existItemOnProductsTable = [];
        $notExistItemOnProductsTable =[];
        foreach ($itemList as $itemLine){
            $jcode = $itemLine[4];
            $query = $productsTable->find();
            $result = $query->where(['jancode = ' => $jcode])->toArray();
            //debug($result);
            if ($result == null){
                // if not exist in the Products Table ---> add $jcode to $itemList2[$count]
                $notExistItemOnProductsTable[] +=  $jcode;
            } else {
                // exist on ProductsTable
                $existItemOnProductsTable[] += $jcode;
            }
        }

        echo "These Products didn't exist in the Products table." . "<br>";
        //debug($notExistItemOnProductsTable);

        echo "These Products exist in the Products table. !!" . "<br>";
        //debug($existItemOnProductsTable);

        // pass $notExistItemProductsList to AddProduct Controller
        $session = $this->getRequest()->getSession();
        $session->write('notExistItemOnProductsTable', $notExistItemOnProductsTable);
        // check
        //$notExistList = $session->read('notExistItemOnProductsTable');
        //debug($notExistList);

        // entry $notExistItemOnProductsTable to Products Controller
        $this->redirect(
            ['controller' => 'AddProduct', 'action' => 'passTest']
        );

        //debug($itemList);
        //$this->setAction('checkExistItemsTable', $itemList);
        // where go to next step ??   
}

    public function checkExistItemsTable($itemList)  //for test
    {
        $this->autoLayout = false;
        $this->autoRender = false;
        echo "This is checkExistItemsTable." . "<br><br>";

        //debug($itemList);
        // テーブルオブジェクトを取得
        $usersTable = TableRegistry::getTableLocator()->get('Users');
        $itemsTable = TableRegistry::getTableLocator()->get('Items');

        // Client objectを取得する
        $client = $usersTable->find()->where(['email = ' => $this->clientEmail])->toArray();
        // user_id = $client[0]['id']

        // exist in the Items Table ? search jancode and user_id !!
        $existItemOnItemsTable = [];
        $notExistItemOnItemsTable = [];

        foreach ($itemList as $itemLine){   //for test
            //debug($jcode);
            $jcode = $itemLine[4];
            $query = $itemsTable->find();
            $result = $query->where(['jancode = ' => $jcode])->where(['user_id =' => $client[0]['id']])->toArray();
            //debug($result);
            if ($result == null){
                // if not exist in the Items Table ---> add $jcode to $notExistItemOnItemsTable[$idx]
                $notExistItemOnItemsTable[] +=  $jcode;
                //$idx++;
            } else {
                $existItemOnItemsTable[] += $jcode;
            }

        }
        //debug($notExistItemOnItemsTable);
        echo "These Items didn't exist in the Items table. !!" . "<br><br>";
        debug($notExistItemOnItemsTable);
             
        echo "These Items exist in the Items table. !!" . "<br><br>";
        debug($existItemOnItemsTable);
       
        $this->setAction('buildItemArray', $notExistItemOnItemsTable);
    }

    public function buildItemArray($notExistItemOnItemsTable)
    {
        $this->autoLayout = true;
        $this->autoRender = false;

        echo "This is buldItemArray() method" . "<br><br>";

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

        foreach ($notExistItemOnItemsTable as $jcode){
            // $notExistItemOnItemsTable から $jcode を取り出してProduct テーブルを検索する
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
                // mycategory
                $itemArray[$idx]['mycategory'] = null;
                // mystore
                $itemArray[$idx]['mystore'] = null;                
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
                $itemObj->store = $item['mycategory'];
                $itemObj->store = $item['mystore'];
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