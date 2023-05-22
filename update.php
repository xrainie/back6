<?php

if($_SERVER["REQUEST_METHOD"] === "GET" && isset($_GET["id"]))
{
    try{
        $user = 'u53712';
        $pass = '5427961';
        $db = new PDO('mysql:host=localhost;dbname=u53712', $user, $pass,
        [PDO::ATTR_PERSISTENT => true, PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
        $stmt = $db->prepare("SELECT * FROM application WHERE id = :id");
        $stmt->bindParam(':id', $id);

        $id = $_GET["id"];

        $stmt->execute();

        $q = $db->prepare("SELECT ability from abilities WHERE id = :id");
        $q->bindParam(':id', $id);
        $id = $_GET["id"];
        $q->execute();
    }
    catch(PDOException $e){
        print('Error : ' . $e->getMessage());
        exit();
    }
    $row = $stmt->fetch(PDO::FETCH_LAZY);
    $abilities = $q->fetchAll(PDO::FETCH_COLUMN, 0);
    $userId = $row["id"];
    $userName = $row["name"];
    $userYear = $row["year"];
    $userEmail = $row["email"];
    $userGender = $row["gender"];
    $userLimbs = $row["limbs"];
    $userBiography = $row["biography"];

    print("<h3>Данные пользователя " . $row['user_login'] . "</h3>");
?>
    <form method='post'>
                    <p>Имя:
                    <input type='text' name='name' value='<?php print($userName);?>' /></p>
                    <p>Год рождения:
                    <input type='number' min='1900' max='2023' name='year' value='<?php print($userYear);?>' /></p>
                    <p>Почта:
                    <input type='email' name='email' value='<?php print($userEmail); ?>' /></p>
                    <p>Пол:
                    <input type="radio" name="gender[]" id="gender" value="male" <?php if($userGender == "male") {print 'checked';} ?>> Мужской
                    <input type="radio" name="gender[]" value="female" value="female" <?php if($userGender == "female") {print 'checked';} ?>> Женский
                    </p>
                    <p>Количество конечностей: 
                    <input type="radio" name="limbs[]" value="2" id="limbs" <?php if($userLimbs == 2) {print 'checked';} ?>>2
                    <input type="radio" name="limbs[]" value="3" <?php if($userLimbs == 3) {print 'checked';} ?>>3
                    <input type="radio" name="limbs[]" value="4" <?php if($userLimbs == 4) {print 'checked';} ?>>4
                    <input type="radio" name="limbs[]" value="many" <?php if($userLimbs == "many") {print 'checked';} ?>>больше</p>
                    <p>Сверхспособности: 
                    <select multiple="multiple" name="abilities[]" id="abilities">
                                <option value="Immortality" 
                                <?php if(in_array("Immortality", $abilities)) {print 'selected';}?>>Бессмертие</option>
                                <option value="Passing through walls" 
                                <?php if(in_array("Passing through walls", $abilities)) {print 'selected';}?>>Прохождение сквозь стены</option>
                                <option value="Levitation" 
                                <?php if(in_array("Levitation", $abilities)) {print 'selected';}?>>Левитация</option>
                                </select></p>
                    <p>Биография: 
                    <textarea name="biography" id="biography"> <?php print($userBiography);?></textarea></p>
                    <input type='submit' value='Сохранить'>
    </form>
<?php
}
else {
    try{
        $user = 'u53712';
        $pass = '5427961';
        $db = new PDO('mysql:host=localhost;dbname=u53712', $user, $pass,
        [PDO::ATTR_PERSISTENT => true, PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
        $stmt = $db->prepare("UPDATE application SET name = :name , year = :year, email = :email, gender = :gender, limbs = :limbs, biography = :biography
        WHERE id = :id");
         $stmt->bindParam(':name', $userName);
         $stmt->bindParam(':year', $userYear);
         $stmt->bindParam('email', $userEmail);
         $stmt->bindParam(':gender', $userGender);
         $stmt->bindParam(':limbs', $userLimbs);
         $stmt->bindParam(':biography', $userBiography);
         $stmt->bindParam(':id', $id); 

        $userName = $_POST["name"];
        $userYear = $_POST["year"];
        $userEmail = $_POST["email"];
        $userGender = $_POST["gender"][0];
        $userLimbs = $_POST["limbs"][0];
        $userBiography = $_POST["biography"];
        $id = $_GET["id"]; 

        $stmt->execute();

        $abilities = $_POST["abilities"];
        $stmt = $db->prepare("DELETE FROM abilities WHERE id = :id");
        $stmt->bindParam(':id', $usrid);

        $usrid = $id;

        $stmt->execute();

        $stmt = $db->prepare("INSERT INTO abilities (id, ability) VALUES(:id, :ability)");
        
        foreach($abilities as $abil){
            $stmt->bindParam(':id', $usrid);
            $stmt->bindParam(':ability', $ability);
            $usrid = $id;
            $ability = $abil;
            $stmt->execute();
        }
    }
    catch(PDOException $e){
        print('Error : ' . $e->getMessage());
        exit();
    }
    header('Location: ./admin.php');    
}

?>