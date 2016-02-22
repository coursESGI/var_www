<?php
	
class user{
	
	public $name;
	public $surname;
	public $birthday;
	public $country;
	public $email;
	public $commentaire = "";
	public $pwd;	
	public $kind;
	public $cgu;
	
	public $bdd;
	
	public function verify($confirmationMotDePasse){
		$list_of_country = ["pa"=>"Paris", "ma"=>"Marseille", "ly"=>"Lyon", "li"=>"Lille"];
		$list_of_kind = [0=>"homme", 1=>"femme"];
		$error = FALSE;
		$msg_error = "";

        $this->name = strtolower(trim($this->name));
        $this->surname = strtolower(trim($this->surname));
        $this->email = strtolower(trim($this->email));

        if(strlen($this->name)<2){
            $error = TRUE;
            $msg_error .= "<li>Le nom doit faire plus d'un caractère";
        }
        if(strlen($this->surname)<2){
            $error = TRUE;
            $msg_error .= "<li>Le prénom doit faire plus d'un caractère";
        }
        if( $this->name === $this->surname){
            $error = TRUE;
            $msg_error .= "<li>Le prénom doit être différent du nom";
        }
        if(!filter_var($this->email, FILTER_VALIDATE_EMAIL)){
            $error = TRUE;
            $msg_error .= "<li>Email invalide";
        }
        if(strlen($this->pwd) <8 || strlen($this->pwd)>12){
            $error = TRUE;
            $msg_error .= "<li>Le mot de passe doit faire entre 8 et 12 caractères";
        }
        if($this->pwd != $confirmationMotDePasse){
            $error = TRUE;
            $msg_error .= "<li>Le mot de passe de confirmation ne correspond pas";
        }
        if(! isset($list_of_country[$this->country]) ){
            $error = TRUE;
            $msg_error .= "<li>Votre ville n'existe pas";
        }
        if(!in_array($this->kind, $list_of_kind)){
            $error = TRUE;
            $msg_error .= "<li>Le genre n'existe pas";
        }

        //Quand le format date fonctionne j'ai 2015-11-18
        //Sinon je vais devoir m'adapter
        //2012-07-08
        $now = new DateTime();


        //Vérifier la présence du "-"
        if( strpos($this->birthday, "-") ){
            $explode_date = explode("-", $this->birthday);
            
            list($year, $month, $day) = explode('-', $this->birthday);
            $time_birthday = mktime(0, 0, 0, $month, $day, $year);

            if( checkdate ( $month , $day , $year )){
                $bithdayDate = new DateTime($this->birthday);
                $interval = $now->diff($bithdayDate);
                $age = $interval->y;

                if($age >= 100 ){
                    $error = TRUE;
                    $msg_error .= "<li>Date de naissance incorrecte";
                }
            }
        }
        //Vérifier la présence du "/"
        else if( strpos($this->birthday, "/") ){

            list($day, $month, $year) = explode('/', $this->birthday);
            $time_birthday = mktime(0, 0, 0, $month, $day, $year);

            if( checkdate ( $month , $day , $year )){
                $bithdayDate = new DateTime($year."-".$month."-".$day);
                $interval = $now->diff($bithdayDate);
                $age = $interval->y;

                if($age >= 100 ){
                    $error = TRUE;
                    $msg_error .= "<li>Date de naissance incorrecte";
                }
            }
        }
        //Erreur
        else{
            $error = TRUE;
            $msg_error .= "<li>Date de naissance incorrecte";
        }
        
        if(!isset($this->cgu)){
            $error = TRUE;
            $msg_error .= "<li>Veuillez accepter les CGUs";
        }
		
        //Vérification de l'unicité de l'email    
        $users = getUser($this->bdd, ["email"=>$this->email] , "id");
        if(!empty($users)){
            $error = TRUE;
            $msg_error .= "<li>L'email existe déjà";

        }


      if($error)
            return $msg_error;
        else
			return 1;
        

    }
    
    public function save(){
		$pwd = password_hash($this->pwd, PASSWORD_DEFAULT);

		setUser( $this->bdd, ["name"=>$this->name,
						"surname"=>$this->surname,
						"kind"=>$this->kind,
						"email"=>$this->email,
						"pwd"=>$pwd,
						"comment"=>$this->commentaire,
						"country"=>$this->country,
						"birthday"=> $this->birthday]  );
	}
}
