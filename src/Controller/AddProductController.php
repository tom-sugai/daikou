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

class AddProductController extends AppController
{
    private $csv_array      = [];
    private $client_array   = [];
    private $productArray   = [];
    private $itemArray      = [];

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

    public function doComponent(){
        $amount = $this->Math->doComplexOperation(20, 20);
        //debug($amount);
        $this->set('amount', $amount);

    }

    public function setListCsvClient(){
        $this->autoLayout = true;
        $this->autoRender = true;
        $this->viewBuilder()->setLayout('default');
        echo "0. ------------------------------" . "<br>";
        echo "This is setListCsvClient() method !!" . "<br>";

        // pass file list to view
        $this->set('csv_list', $this->csv_array);

        // pass client list to view
        $this->set('client_list', $this->client_array);
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
            $csvFile =  $this->csv_array[$result1];
            echo $csvFile . "<br>";
        }
        // check Client Name
        if($result2 != null){
            $clientEmail = $this->client_array[$result2];
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
        
        // close csv file
        fclose($file);

        // remove array element top ( title line )
        $remove_top = array_shift($data);

        // check data[], jancode column of eache line in $ary_line[4]
        // $j is line conuter. start from 1. becouse vscode editor line count start 1.
        $j = 1;
        foreach($data as $ary_line)
        {
            $j++;
            if($ary_line != null)
            {
                /** 
                echo "------------------------" . "<br>";
                for( $i=0; $i < $n; $i++)
                {
                    echo $ary_line[$i] . " | ";   
                }
                echo "<br>";
                */
                // check jancode ketasuu
                //　正規表現の判定関数を記述する : $ary_line[4] != "13桁の数字"
                $str = $ary_line[4];
                //$pattern = "/[0-9]{13}/";
                $pattern = "/[0-9]{8,13}/";
                if(!preg_match( $pattern, $str, $result )) 
                {
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

    public function readJancodeCsv($csvFile){
        $this->autoLayout = true;
        $this->autoRender = false;
        echo "3. ------------------------------" . "<br>";
        echo "This is readJancodeCsv()." ."<br>";

        $msg = "Create jan-code-list array for next step checkExistDb().";
        $this->set('msg', $msg);

        // csv file: /webroot/data/csvFile を読み込む
        // set $file-path ='data/file-name.csv'
        $csv_path ="data/" . $csvFile;
        // open csv file
        $file = fopen($csv_path, 'r');

        // prepar array data[]
        $data = [];
        //read csv line to data[]
        while(feof($file) == False) {
            $data[] = fgetcsv($file, 1000);
        }
        // remove array element top & tail
        $remove_top = array_shift($data);
        $remove_last = array_pop($data);
        // lines is  csv line number 
        $lines = count($data);
        $this->set('lines', $lines);
        $this->set('data', $data);

        // create jancodelist array
        $jancodeList = [];
        // extract jancode from $data[4]
        foreach($data as $rowData){
            $jancodeList[] = $rowData[4];
        }
        //$this->render();
        $this->setAction('checkExistDb', $jancodeList);
    }

    public function checkExistDb($jancodeList)
    {
        $this->autoLayout = true;
        $this->autoRender = true;
        echo "4. ------------------------------" . "<br>";
        echo "This is checkExistDb() ." ."<br>";

        // テーブルオブジェクトを取得
        $productsTable = TableRegistry::getTableLocator()->get('Products');

        // exist in the Products Table
        // prepar variables
        $unExistList =[];
        $lineno = 1;
        // search jancode & create unExistList[]
        foreach ($jancodeList as $jancode){
            //$jcode = $jancode[4];
            $query = $productsTable->find();
            $result = $query->where(['jancode = ' => $jancode])->toArray();
            //debug($result);
            if ($result == null){
                // if did'nt exist in the Products Table ---> add $jcode to $unExistList[]
                $unExistList[] =  $jancode;
            } else {
                echo "lineNo : $lineno ---- $jancode exist" . "<br>"; 
            }
            $lineno++;
        }
        //debug($unExistList);
        // go to next step
        if($unExistList != null){
            $this->setAction('buildProductArray', $unExistList);            
        }

        echo "New Product is Nothing!!" . "<br>";
        $this->render();
    }

    public function passTest(){
        // pass notExistItemOnProductsTable array via session from AddItemController(line:148)/checkExistProductsTable() .... 
        echo "5. ------------------------------" . "<br>";
        echo "This is AddProduct/passTest()." . "<br>";

        $session = $this->getRequest()->getSession();
        $unExistList = $session->read('notExistItemOnProductsTable');
        //debug($unExistList);
        $this->set('unExistList', $unExistList);
        if($unExistList != null){
            $this->setAction('buildProductArray', $unExistList);
        } else {
            echo "すべてのアイテムがProductsテーブルに登録されています";
            $this->redirect(
                ['controller' => 'AddItem', 'action' => 'returnFromAddProduct']
            );
        }
    }

    public function buildProductArray($unExistList){
        $this->autoLayout = true;
        $this->autoRender = true;
        echo "6. ------------------------------" . "<br>";
        echo "This is buildProductArray." . "<br>";

        // Yahooサイトから商品情報を検索して private $productArray = [] に格納する
        // 検索した商品情報を AddItemContoroller 内で共有する

        //$productArray = [];
        // $productArray のインデックスの初期値
        $idx = 0;
        //create http-client instance
        $http = new Client();
        foreach ($unExistList as $jancode){
            // $unExistList から $jancode を取り出してYahooで検索、結果のイメージ、janCode、商品名を、配列 $productArray へ格納する  
            // call ShoppingWebService with $jancode[4] (= jancode).
            $jcode = $jancode;
            $appId = 'dj00aiZpPTY0eUxBNDFjUVpvYiZzPWNvbnN1bWVyc2VjcmV0Jng9ODc-';    
            $response = $http->get('https://shopping.yahooapis.jp/ShoppingWebService/V3/itemSearch?appid=' . $appId . '&jan_code=' . $jcode . '&results=1');    
            if($response->getStatusCode() == 200){
                // change response to responseArray ( $response->getJson() )
                $responseArray = $response->getJson();
                //debug($responseArray);
                if($responseArray['hits'] != null)
                {
                    // Request Success 
                    // get & copy janCode, name, brand, category_name, image url, site url
                    // janCode : $responseArray['hits'][0]['janCode']
                    $productArray[$idx]['jancode'] = $responseArray['hits'][0]['janCode'];
                    // itemName : $responseArray['hits'][0]['name']
                    $productArray[$idx]['pname'] = $responseArray['hits'][0]['name'];
                    // itemBrand
                    $productArray[$idx]['brand'] = $responseArray['hits'][0]['brand']['name'];
                    // ctegories
                    $productArray[$idx]['category'] = $responseArray['hits'][0]['parentGenreCategories'][0]['name'];
                    // itemImage : $responseArray['hits'][0]['image']['medium']
                    $productArray[$idx]['image'] = $responseArray['hits'][0]['image']['medium'];
                    // url
                    $productArray[$idx]['site'] = $responseArray['hits'][0]['url'];
                    // store empty
                    $productArray[$idx]['store'] = null;
                    //debug($productArray[$idx]);   
                }   else {
                     // Request failure, did'nt exist $responseArray['hits'] == null
                    // set null to all fileds without jancode
                    $productArray[$idx]['jancode'] = $jcode;
                    // itemName
                    $productArray[$idx]['pname'] = 'notfound';
                    // itemBrand
                    $productArray[$idx]['brand'] = null;
                    // ctegories
                    $productArray[$idx]['category'] = null;
                    // itemImage
                    $productArray[$idx]['image'] = null;
                    // url
                    $productArray[$idx]['site'] = null;
                    // store empty
                    $productArray[$idx]['store'] = null;
                    //echo "skip data : " . $jcode . "<br/>";
                    
                }
            } else {
                echo "error code : " . $response->getStatusCode() . "  jancode = " . $jcode ."<br>";
                echo "Can not get Item Info from Yahoo Shopping" . "<br>";
            }
            $idx++;
            sleep(1);
        }
        //debug($productArray);
        // 作成した配列、$productArray をビューに渡す
        $this->set('productArray', $productArray);
        // display by template
        $this->render();

        // storProduct() へ進む
        //$this->setAction('storeProduct', $productArray);
    }

    public function echoProductList()
    {
        $this->autoLayout = false;
        $this->autoRender = true;
    }

    public function storeProduct($productArray){
        $this->autoLayout = true;
        $this->autoRender = true;
        echo "7. ------------------------------" . "<br>";
        echo "This is AddProduct/storeProduct()." . "<br>";

        // Authentication コンポーネントで user を取得
        if($this->Authentication->getIdentity() !== null){
            $user = $this->Authentication->getIdentity();
        }
        //debug($user);
        // テーブルオブジェクトを取得
        $productsTable = TableRegistry::getTableLocator()->get('Products');
        // set product properties 
        foreach($productArray as $element){
            // check exist using jancode
            //echo "-------------------------------------------------" . "<br/>"; 
            echo $element['jancode'] . "<br>";
            // exist test for product using user_id and jancode
            $query = $productsTable->find();
            $result = $query->where(['jancode = ' => $element['jancode']])->toArray();
            if ($result == null){
                // create Product empty Entity
                $product = $productsTable->newEmptyEntity();
                // set Product Entity properties
                    // $user was defined at AppController
                $product->user_id = $user->id;
                $product->category = $element['category'];
                $product->jancode = $element['jancode'];
                $product->pname =  $element['pname'];
                $product->brand = $element['brand'];
                $product->store = $element['store'];
                $product->image = $element['image'];
                $product->site = $element['site'];
                $product->created = Time::now();
                $product->modified = Time::now();
                //debug($product->pname);  
                // save $product
                if ($productsTable->save($product)) {
                    //$this->Flash->success(__('The product has been saved.'));
                    echo $product->jancode . " : " . "The product has been saved." . "<br/>";
                    echo "-------------------------------------------------" . "<br/>";                    
                } else {
                    //$this->Flash->error(__('The product could not be saved. Please, try again.'));
                    echo "The product could not be saved. Please try again." . "<br/>";
                }
            } else { 
                echo "Record exist!!" . "<br/>";
    
            }
        }
        /** 
        $this->redirect(
            ['controller' => 'AddItem', 'action' => 'returnFromAddProduct']
        );
        */
    }
}