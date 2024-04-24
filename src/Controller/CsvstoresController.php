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
 * Csvstores Controller
 *
 * @property \App\Model\Table\CsvstoresTable $Csvstores
 * @method \App\Model\Entity\Csvstore[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class CsvstoresController extends AppController
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
        $this->Authentication->addUnauthenticatedActions(['index','setListCsvClient']);
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
    public function index($sw = null)
    {
        //$sw = null;

        $this->paginate = [
            'contain' => ['Users', 'Products'],
        ];

        switch((int)$sw){
            case 0:
                // exist pdb
                $query = $this->Csvstores->find()
                    ->where(['existpdb =' =>  1]);
            
                break;
            case 1:
                // hits yahoo
                $query = $this->Csvstores->find()
                    ->where(['hitsyahoo =' =>1]);
                break;
            case 2:
                // exist pdb OR hits yahoo
                $query = $this->Csvstores->find()
                    ->where(['OR' => ['existpdb' => 1, 'hitsyahoo' =>1]]);
                break;
            case 3:
                // not exist pdb AND didn't hit yahoo 
                $query = $this->Csvstores->find()
                    ->where(['existpdb =' => 0])
                    ->where(['hitsyahoo =' => 0]);
                break;
        }
        $csvstores = $this->paginate($query);    
        //$csvstores = $this->paginate($this->Csvstores);

        $this->set(compact('csvstores'));
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
            $csvstore = $this->Csvstores->get($id, [
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
            $csvstore = $this->Csvstores->newEmptyEntity();
            if ($this->request->is('post')) {
                $csvstore = $this->Csvstores->patchEntity($csvstore, $this->request->getData());
                if ($this->Csvstores->save($csvstore)) {
                    $this->Flash->success(__('The csvstore has been saved.'));

                    return $this->redirect(['action' => 'index']);
                }
                $this->Flash->error(__('The csvstore could not be saved. Please, try again.'));
            }
            $users = $this->Csvstores->Users->find('list', ['limit' => 200])->all();
            $products = $this->Csvstores->Products->find('list', ['limit' => 200])->all();
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
            $csvstore = $this->Csvstores->get($id, [
                'contain' => [],
            ]);
            if ($this->request->is(['patch', 'post', 'put'])) {
                $csvstore = $this->Csvstores->patchEntity($csvstore, $this->request->getData());
                if ($this->Csvstores->save($csvstore)) {
                    $this->Flash->success(__('The csvstore has been saved.'));

                    return $this->redirect(['action' => 'index']);
                }
                $this->Flash->error(__('The csvstore could not be saved. Please, try again.'));
            }
            $users = $this->Csvstores->Users->find('list', ['limit' => 200])->all();
            $products = $this->Csvstores->Products->find('list', ['limit' => 200])->all();
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
            $csvstore = $this->Csvstores->get($id);
            if ($this->Csvstores->delete($csvstore)) {
                $this->Flash->success(__('The csvstore has been deleted.'));
            } else {
                $this->Flash->error(__('The csvstore could not be deleted. Please, try again.'));
            }

            return $this->redirect(['action' => 'index']);
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
        $remove_end = array_pop($data);
        // datalines after remove
        $lines = count($data);
        echo "datalines after remove top & end : $lines" . "<br>";
        // check data[], jancode column of eache line in $ary_line[4]
        // $j is line conuter. start from 1. becouse vscode editor line count start 1.
        echo "------------------------" . "<br>";
        $bad_data_list = [];
        $j = 0;
        foreach($data as $ary_line)
        {
            if($ary_line != null)
            {    
                // echo item list in the csv file
                /** 
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
                    $bad_data_list[] =+ $j; 
                }
            }
            $j++;                
        }
        //echo "find last data(= blank line). line No. $j is null(on line order csv file)" . "<br>";
        $k = $lines;
        echo "<br>" . "There are $k data lines in this csv file." . "<br>";

        // remove bad data from data array using bad_data_list
        $bad_count = count($bad_data_list);
        echo "There are $bad_count bad data in this csv file." . "<br>";
        print_r($bad_data_list);

        // create clean_data (remove bad data)
        $bad_data = reset($bad_data_list);
        $clean_data = [];
        $count = 0;
        foreach($data as $row_data)
        {
            //debug($bad_data);
            if($count == $bad_data)
            {
                $bad_data = next($bad_data_list);
            } else {
                $clean_data[] = $row_data;
                //debug($clean_data);
            }
            $count++;
        }        
        //debug($clean_data);
        $clean_count = count($clean_data);
        echo "<br>" . "created $clean_count rows clean_data array." . "<br>";
        //debug($clean_data);
        // go to next action;
        $this->setAction('existInCsvstores', $clean_data);
    }

        /**
     * parameter $data pass from checkCsv()
     */
    public function existInCsvstores($data)
    {
        $this->autoLayout = true;
        $this->autoRender = true;
        echo "4. ------------------------------" . "<br>";
        echo "This is existInCsvstores() ." ."<br>";

        // check code(jancode) of the row_data exist in Csvstores ?
        // if not exist ---- save row_data to Csvstores with clien id
        // if exist -------- echo message

        // set owner of Data  to Csvstores filed user_id
        $usersTable = $this->loadModel('Users');
        // get user_id from $this->clientEmail
        $user = $usersTable->find()
            ->where(['email = ' => $this->clientEmail])
            ->first();

        // exist? in the Csvstores Table
        $existList =[];
        $lineno = 0;
        $savedcsv = 0;
        // search code & create existList[]
        foreach ($data as $rowdata){
            //debug($rowdata);
            $code = $rowdata[4];
            //debug($code);
             
            $result = $this->Csvstores->find()
                //->where(['user_id = ' => $user->id]) **** Do'nt exist same code item in Csvstores table
                ->where(['code = ' => $code])
                ->first();
            //debug($result);
            
            //$result = null;
            if ($result == null){
                //echo "lineNo : $lineno ---- $code not exist" . "<br>";

                // create Csvstore object
                $csvstore = $this->Csvstores->newEmptyEntity();
                    // set user_id = clientId
                    $csvstore->user_id = $user->id;
                    // set csv name
                    $csvstore->csvname = $this->csvFile;
                    // set flag 1 to Csvstore->existpdb and set lineno, codeformat
                    //$csvstore->existpdb = 0;
                    //$csvstore->hitsyahoo = 0;
                    $csvstore->lineno = $lineno;
                    $csvstore->codeformat = $rowdata[3];
                    // set code to Csvstore->code
                    $csvstore->code = $code;
                    //debug($csvstore);
                // save object
                if ($this->Csvstores->save($csvstore)) {
                    $this->Flash->success(__('The csvstore has been saved.'));
                    //echo "lineno : $lineno, user_id : $user->id, code : $code was saved." . "<br>";
                    $savedcsv++;
                    //return $this->redirect(['action' => 'index']);
                } else {
                    $this->Flash->error(__('The csvstore could not be saved. Please, try again.'));
                }
            } else { 
                // if exist in the Csvstores Table ---> add $code to $existList[]
                //echo "lieno : $lineno , user_id : $user->id , code : $code  exist." . "<br>";
                $existList[] =  $code;
            }
            $lineno++;
        }
        echo "$savedcsv rows saveed." . "<br>";

        // go to next step

        echo "existInCsvstores() end" . "<br>";
        $this->render();
    }

    // existInPdb
    public function existInPdb()
    {
        $this->autoLayout = true;
        $this->autoRender = true;
        echo "5. ------------------------------" . "<br>";
        echo "This is existInPdb() ." ."<br>";
        // 1.select user_id (client id) in the Form
        // 2.submit
        // 3.query to Csvstores where user_id = client id
        // 4.check code(jancode) of eache row_data[4]
        // 5.if exist in Products table ---- 
        //      set 1 to field existpdb & set product_id to csvstore field product_id

        // load Products table
        $productsTable = $this->loadModel('Products');

        // exist in Products table ?

        // get existpdb = 0 csvdata from Csvstores (initial set = 0) 
        $clientdatas = $this->Csvstores->find()
            ->where(['existpdb = ' => 0]);
        //debug($clientdatas);
        
        // exist? in the Products Table
        $existCount = 0;
        $unExistCount = 0;
        $unExistList =[];

        // search jancode & if exist set 1 to field existpdb
        foreach ($clientdatas as $rowdata){
            //debug($rowdata);
            $jancode = $rowdata['code'];
            //debug($jancode);
            $product = $productsTable->find()
                ->where(['jancode = ' => $jancode])
                ->first();

            if ($product != null){
                echo "$jancode exist" . "<br>";
                // set rowdata field existpdb = 1, $rowdata->product_id = result->id
                // set flag 1 to Csvstore->existpdb and set lineno, codeformat
                $rowdata->existpdb = 1;
                // set product->id to Csvstore->product_id
                $rowdata->product_id = $product->id;
                // set imageurl
                $rowdata->imageurl = $product->image;
                // set ctegory
                $rowdata->category = $product->category;
                // set pname
                $rowdata->pname = $product->pname;
                // set brand
                $rowdata->brand = $product->brand;

                //debug($rowdata);

                if ($this->Csvstores->save($rowdata)) {
                    $this->Flash->success(__('The csvstore has been saved.'));
                    $existCount++;
                } else {
                    $this->Flash->error(__('The csvstore could not be saved. Please, try again.'));
                }
            } else { 
                // if did'nt exist in the Products Table ---> add $jancode to $unExistList[]
                $unExistList[] =  $jancode;
                $unExistCount++;
                echo "$jancode  not exist in Products table" . "<br>";
            }
            //debug($product);
        }
        //debug($unExistList);
        echo "$existCount exist was saved." . "<br>";
        echo "$unExistCount not exist." . "<br>";
        // go to next step
        if($unExistList != null){
            //$this->setAction('buildProductArray', $unExistList);            
        }

        echo "End existInPdb()" . "<br>";
        $this->render();
    }

    // hitsyahoo
    public function hitsYahoo()
    {
        $this->autoLayout = true;
        $this->autoRender = true;
        echo "5. ------------------------------" . "<br>";
        echo "This is hitsYahoo() ." ."<br>";
        // 1.select user_id (client id) in the Form
        // 2.submit
        // 3.query to Csvstores where user_id = client id
        // 4.check code(jancode) of eache row_data[4]
        // 5.if exist in Products table ---- 
        //      set 1 to field existpdb & set product_id to csvstore field product_id

        // Productsテーブルオブジェクトを取得
        $productsTable = $this->loadModel('Products');

        //debug($this->clientId);
        // userId for test
        //$userId = 1;
        // get clientdatas (csvstore) where user_id = $this->clientId
        $clientdatas = $this->Csvstores->find()
            ->where(['existpdb = ' => 0]);
        //debug($clientdatas);
        
        // hits yahoo api search
        $hitsCount = 0;
        $unExistList =[];
        //create http-client instance
        $http = new Client();

        // search jancode. if hits set 1 to field existpdb
        // and set yahoo product info to csvstore's porduct fields
        foreach ($clientdatas as $rowdata){
            //debug($rowdata);
            $jancode = $rowdata['code'];
            debug($jancode);
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
                    // hits yahoo
                    $rowdata->hitsyahoo = 1;
                    // janCode : $responseArray['hits'][0]['janCode']
                    $rowdata->code = $responseArray['hits'][0]['janCode'];
                    // itemName : $responseArray['hits'][0]['name']
                    $rowdata->pname = $responseArray['hits'][0]['name'];
                    // itemBrand
                    $rowdata->brand = $responseArray['hits'][0]['brand']['name'];
                    // ctegories
                    $rowdata->category = $responseArray['hits'][0]['parentGenreCategories'][0]['name'];
                    // itemImage : $responseArray['hits'][0]['image']['medium']
                    $rowdata->imageurl = $responseArray['hits'][0]['image']['medium'];
                    // url
                    $rowdata->siteurl = $responseArray['hits'][0]['url'];
                    // store empty
                    $rowdata->store = null;
                    // count up
                    $hitsCount++;   
                }   else {
                     // Request failure, did'nt exist $responseArray['hits'] == null
                    // set null to all fileds without jancode
                    $rowdata->code = $jcode;
                    // itemName
                    $rowdata->pname = 'notfound';
                    // itemBrand
                    $rowdata->brand = null;
                    // ctegories
                    $rowdata->category = null;
                    // itemImage
                    $rowdata->imageurl = null;
                    // url
                    $rowdata->siteurl = null;
                    // store empty
                    $rowdata->store = null;
                    //echo "skip data : " . $jcode . "<br/>";
                    
                }
                // save rowdata to $this->Csvstores
                if ($this->Csvstores->save($rowdata)) {
                    $this->Flash->success(__('The csvstore has been saved.'));
                    $existCount++;
                } else {
                    $this->Flash->error(__('The csvstore could not be saved. Please, try again.'));
                }
            } else {
                echo "error code : " . $response->getStatusCode() . "  jancode = " . $jcode ."<br>";
                echo "Can not get Item Info from Yahoo Shopping" . "<br>";
            }

            sleep(1);
        }

        // go to next step
        if($unExistList != null){
            //$this->setAction('buildProductArray', $unExistList);            
        }

        echo "End hitsYahoo()" . "<br>";
        $this->render();
    }
}

