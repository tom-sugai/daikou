    <?= $this->Form->create(null, ['type' => 'post', 
        'url'=>['controller'=>'ExcView', 'action'=>'receive-cake-form']
    ]); ?> 
            <label for="first_name">
                First name
            </label>
            <input type="text" name="text-1" id="first_name" placeholder="John" size="10">
            <p>---------</p>

          <li>input type=tel</li>
              
          <label for="telno">
              Telephon
          </label>
          <input type="tel" name="telno" id="telno">
          <p>---------</p>
          
          <li>input type=email</li>

          <label for="email">
              Email
          </label>
          <input type="email" name="email" id="url">
          <p>---------</p>

          <li>input type=date</li>

          <label for="date">
              Date
          </label>
          <input type="date" name="date" id="date">
          <p>---------</p>

          <li>input type=time</li>

          <label for="time">
              Time
          </label>
          <input type="time" name="time" id="time">
          <p>---------</p>

          <label for="text_area">
            Textarea( cols * rows )
            </label>
            <textarea name="textarea" placeholder="message" id="text_area" cols="20" rows="4">
            </textarea>
            <p>---------</p>

          <li>Checkbox</li>
          <input type="hidden" name="check-1" value="off" id="cb">
          <input type="checkbox" name="check-1" id="cb">
          <label class="label-inline" for="cb">
          赤が好き
          </label>
          <li>Checkbox</li>
          <input type="hidden" name="check-2" value="off" id="cb">
          <input type="checkbox" name="check-2" id="cb">
          <label class="label-inline" for="cb">
          青が好き
          </label>
        <p>---------</p>

        <li>Radio bottan</li>

          <label class="label-inline"><input type="radio" name="anser" value="yes" checked>Yes</label>
          <label class="label-inline"><input type="radio" name="anser" value="???">???</label>
          <label class="label-inline" ><input type="radio" name="anser" value="no">No</label>
          <br>
          <input type="radio" name="account" value="普通預金" id="s" checked>
          <label class="label-inline" for="s">普通預金</label>
          <input type="radio" name="account" value="当座預金" id="t">
          <label class="label-inline" for="t">当座預金</label>
          <input type="radio" name="account" value="貯蓄預金" id="c">
          <label class="label-inline" for="c">貯蓄預金</label>
        <p>---------</p>

          <li>Select box</li>

            <label for="bank">銀行</label>
            <select name="select-1[]" size="3" multiple id="bank">
              <option value="0001">みずほ銀行</option>
              <option value="0005">三菱UFJ銀行</option>
              <option value="0009">三井住友銀行</option>
            </select>
          <p>---------</p>
      <p><input type="submit"></p>

    <?= $this->Form->end(); ?>