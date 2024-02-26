<?= "This is confirm_form.php template file." . "<br><br>"?>
<?php 
    echo $this->Form->create($confirmForm);
        echo $this->Form->control('confirmForm.name',['size' => '20','label' => ['class' => 'tom', 'text' => 'UserName'],'style' => 'width:20.0rem;', 'val' => $confirmConst['name']]);
        echo $this->Form->control('confirmForm.tel', ['val' => $confirmConst['tel']]);
        echo $this->Form->control('confirmForm.email', ['val' => $confirmConst['email']]);
        echo $this->Form->control('confirmForm.date',['type' => 'date', 'val' => $confirmConst['date']]);
        echo $this->Form->control('confirmForm.time',['type' => 'time', 'val' => $confirmConst['time']]);
        echo $this->Form->control('confirmForm.textarea',['type'=>'textarea', 'label' => 'Your message.','cols' => '20', 'rows' => '2', 'style' => 'width:40.0rem;height:4.0rem;', 'val' => $confirmConst['textarea']]);
        echo $this->Form->label('Which do you like ?');
        echo $this->Form->control('confirmForm.likered',['type' => 'checkbox','label' => '赤が好き', 'val' => $confirmConst['likered']]);
        echo $this->Form->control('confirmForm.likeblue',['type' => 'checkbox','label' => '青が好き', 'val' => $confirmConst['likeblue']]);
        echo $this->Form->label('Question : How are you ? ');
        echo $this->Form->radio('confirmForm.answer',['元気です','マアマア','あんまり'],['label' => 'true', 'val' => $confirmConst['answer']]);
        echo $this->Form->select('confirmForm.banks',['みずほ銀行','三菱銀行','三井住友銀行'],['multiple' => 'true', 'val' => $confirmConst['banks']]);
        echo $this->Form->button('Submit');
    echo $this->Form->end();

    echo "The recieved results from ConfirmForm are follows." . "<br><br>";
    $postedData = $confirmForm->getData();
    foreach ($postedData['confirmForm'] as $key => $val){
        if($key == 'banks'){
            foreach($postedData['confirmForm']['banks'] as $bank){
                echo "Selected Bank is : " . $bank . "<br>";
            }
        } else {
            echo $key . " : " . $val . "<br>";
        }
    }
     
    
 
?>

