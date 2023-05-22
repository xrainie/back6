<html>
    <head>
        <style>
            .container{
                display: flex;
                flex-direction: column;
                align-items: center;
                justify-content: center;
            }
            form{
                margin-top: 100px;
                border: solid rgb(0, 0, 0) 2px;
                border-radius: 10px;
                background-color: rgba(114, 114, 114, 0.952);
            }

            .item-1{
                width: 650px;
                height: 30px;
                margin: 0 5px;
            }

            .item-2{
                width: 650px;
                height: 80px;
                margin: 0 5px;
            }

            .button {
                text-align: right;
                margin-bottom: 10px;
                margin-right:5px;
            }
            .error {
                border: 2px solid red;
            }

            #messages {
                text-align: center;
                width: 200px;
                margin-left: auto;
                margin-right: auto;
            }
        </style>
    </head>
    <body>
    <?php
        if (!empty($messages)) {
            print('<div id="messages">');
            // Выводим все сообщения.
            foreach ($messages as $message) {
                print($message);
            }
            print('</div>');
        }
    ?>
        <div class="container">
            <form action="" method="POST">  
                <div class="aba">
                    <div class="item-1">
                        <label for="fio">Имя: </label>
                        <input type="text" name="fio" id="fio" <?php if ($errors['fio']) {print 'class="error"';} ?> value="<?php print $values['fio']; ?>" >
                        <label for="email">Почта: </label>
                        <input type="email" name="email" id="email" <?php if ($errors['email']) {print 'class="error"';}?> value="<?php print $values['email']; ?>" >
                    </div>
                        
                    <div class="item-1">
                        <label for="year">Год рождения: </label>
                        <select name="year" id="year" <?php if($errors['year']) {print 'class="error"';}?>>
                            <option selected value=""></option>
                            <?php 
                                for ($i = 1922; $i <= 2022; $i++) {
                                    if($i == $values['year']){
                                        printf('<option selected value="%d">%d год</option>', $i, $i);
                                    }
                                else{
                                    printf('<option value="%d">%d год</option>', $i, $i);
                                }
                             }

                            ?>                            
                        </select>
                    </div>
                        
                        
                        <div class="item-1">
                            <label for="gender" <?php if ($errors['r1']) {print 'class="error"';}?> >Пол:</label>
                            <input type="radio" name="r1[]" id="gender" value="male" <?php if ($errors['r1']) {print 'class="error" ';}
                            if($values['r1'] == "male") {print 'checked';} ?>> Мужской
                            <input type="radio" name="r1[]" value="female" value="female" <?php if ($errors['r1']) {print 'class="error" ';}
                            if($values['r1'] == "female") {print 'checked';} ?>> Женский
                        </div>
            
                        
                        <div class="item-1">
                            <label for="limbs" <?php if ($errors['r2']) {print 'class="error"';}?>>Количество конечностей: </label>
                            <input type="radio" name="r2[]" value="2" id="limbs" <?php if ($errors['r2']) {print 'class="error" ';}
                            if($values['r2'] == 2) {print 'checked';} ?>>2
                            <input type="radio" name="r2[]" value="3" <?php if ($errors['r2']) {print 'class="error" ';}
                            if($values['r2'] == 3) {print 'checked';} ?>>3
                            <input type="radio" name="r2[]" value="4" <?php if ($errors['r2']) {print 'class="error" ';}
                            if($values['r2'] == 4) {print 'checked';} ?>>4
                            <input type="radio" name="r2[]" value="many" <?php if ($errors['r2']) {print 'class="error" ';}
                            if($values['r2'] == "many") {print 'checked';} ?>>больше
                        </div>
            
                        <div class="item-2">
                            <select multiple="multiple" name="abilities[]" id="abilities" <?php if ($errors['abilities']) {print 'class="error"';}?>>
                                <option value="Immortality" 
                                <?php if(in_array("Immortality", $values['abilities'])) {print 'selected';}?>>Бессмертие</option>
                                <option value="Passing through walls" 
                                <?php if(in_array("Passing through walls", $values['abilities'])) {print 'selected';}?>>Прохождение сквозь стены</option>
                                <option value="Levitation" 
                                <?php if(in_array("Levitation", $values['abilities'])) {print 'selected';}?>>Левитация</option>
                                </select>
                        </div>
            
                        <div class="item-2">
                            <label for="biography">Биография: </label>
                            <textarea name="biography" id="biography" <?php if ($errors['biography']) {print 'class="error"';}?>><?php print $values['biography']; ?></textarea>
                        </div>
                
                            
            
                        <div class="check">
                            <input type="checkbox" name="cb" id="cb">
                            <label for="cb">Согласен с обработкой персональных данных.</label>
                        </div>
            
                        <div class="button">
                            <input type="submit" value="Отправить">
                        </div>    
                    </div>
                </form>
            </div>
    </body>
</html>  