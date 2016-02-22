	

    <?php
     
            function connectBdd(){
                    try{
                    return new PDO(BDD_DRIVER.":host=".BDD_HOST.";dbname=".BDD_DBNAME , BDD_USER, BDD_PWD);    
            }catch(Exception $e){
                die("Error :".$e->getMessage());
            }
            }
     
     
     
     
     
            function getUser($bdd, $condition = [], $columns = "*"){
                    //Condition est un tableau du type ["email"=>"y.skrzypczyk@gmail.com"]
                    //Column est une liste du type "name,surname,...."
     
                    $sql = "SELECT ".$columns." FROM users  ";
                    if(!empty($condition)){
                            $sql .="WHERE ";
                            foreach ($condition as $key => $value) {
                                    $list_of_conditions[] = $key."= :".$key;
                            }
                            $sql .= implode(" AND ", $list_of_conditions);
                    }
     
                    $query = $bdd->prepare($sql);
                    $query->execute($condition);
     
                    return $query->fetchAll();
     
            }
     
            function setUser( $bdd, $user=[]){
				$sql = "INSERT INTO users (name, surname, kind, email, pwd, comment, country, birthday)
				VALUES (:name, :surname, :kind, :email, :pwd, :comment, :country, :birthday)";
				
				$query = $bdd->prepare($sql);
				$query->execute($user);
            }
     
            function verifyPwd($user, $pwd){
				
            }
     
            function createToken($user=[]){
				return md5($user["id"].$user["name"].$user["email"].SALT.date("Ymd"));
            }
     
            function logAuth($elements){
     
            }

