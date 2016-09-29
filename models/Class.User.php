<?php
class User implements JsonSerializable {

	private $id;
	private $firstname;
	private $lastname;
	private $mail;
    private $phone;
    private $memberType;
    private $password;

	public function __construct($id=null, $firstname, $lastname, $mail, $phone, $memberType, $password){
		$this->setId($id);
		$this->setFirstname($firstname);
		$this->setLastname($lastname);
		$this->setMail($mail);
        $this->setPhone($phone);
        $this->setMemberType($memberType);
		$this->setPassword($password);
	}

	public static function empty_construct() {
		return new self(null, null, null, null,null, null, null);
	}


	
	public function getId(){
		return $this->id;
	}
	
	public function setId($id){
		$this->id = $id;
	}
	
	public function getFirstname(){
		return $this->firstname;
	}
	
	public function setFirstname($firstname){
		$this->firstname = $firstname;
	}
	
	public function getLastname(){
		return $this->lastname;
	}
	
	public function setLastname($lastname){
		$this->lastname = $lastname;
	}
	
	public function getMail(){
		return $this->mail;
	}
	
	public function setMail($mail){
		$this->mail = $mail;
	}

    public function getPhone()
    {
        return $this->phone;
    }

    public function setPhone($phone)
    {
        $this->phone = $phone;
    }

    public function getMemberType()
    {
        return $this->memberType;
    }

    public function setMemberType($memberType)
    {
        $this->memberType = $memberType;
    }
	
	public function getPassword(){
		return $this->password;
	}
	
	public function setPassword($password){
		$this->password = $password;
	}

/*
 * Creates the password change request for the user.
 * 1.Generates a secret key by shuffling all characters and picking them in random, 30 char length.
 * 2.Sha1 this secret key and stores it timed in the database.
 * 3. Deletes any other change requests there would be for this user.
 */

    public function createPwdChangeRequest(){

        $secretKey = substr(str_shuffle(str_repeat($x='0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ', ceil(30/strlen($x)) )),1,30);
        $ultraSecretKey = sha1($secretKey);
        $query ="DELETE from password_change_requests where fk_idUser ='$this->id'";
        MySqlConn::getInstance()->executeQuery($query);

        $query = "INSERT into password_change_requests(idRequest, Time, fk_idUser )
         VALUES('$ultraSecretKey',now(),'$this->id')";
          MySqlConn::getInstance()->executeQuery($query);
        return $secretKey;

    }

    /*
     * returns user id which corresponds to the given secret key in a 15 min timeplase
     *
     */
    public static function getUserCorrespondingToSecretKey($secretKey){

        $query = "Select * from password_change_requests where idRequest = sha1('$secretKey') AND now() BETWEEN Time and Time + INTERVAL 15 MINUTE ";
        $result = MySqlConn::getInstance()->selectDB($query);
        $idUser = $result->fetch();

        return self::getUserFromId($idUser[2]);
    }

    /*
     * Returns the user object corresponding to the mail
     */
	public static function getUserFromMail($mail){

       $query = "Select * from users where mail ='$mail'";
        $result = MySqlConn::getInstance()->selectDB($query);
        $row = $result->fetch();
        if(!$row) return null;

        return new User($row['idUser'], $row['firstname'], $row['lastname'],
            $row['mail'], $row['tel'],$row['fk_idUserTypes'], $row['pwd']);

        return   MySqlConn::getInstance()->executeQuery($query);
    }
    /*
     * Returns the user object corresponding to the id given
     */
    public static function getUserFromId($idUser){

        $query = "Select * from users where idUser ='$idUser'";
        $result = MySqlConn::getInstance()->selectDB($query);
        $row = $result->fetch();


        return new User($row['idUser'], $row['firstname'], $row['lastname'],
            $row['mail'], $row['tel'],$row['fk_idUserTypes'], $row['pwd']);

    }

	public function save(){
		$pwd = sha1($this->password);
		$query = "INSERT into users( firstname, lastname, mail, tel, fk_idUserTypes, pwd)
		VALUES('$this->firstname', '$this->lastname', '$this->mail', '$this->phone','$this->memberType','$pwd');";
			
		return  MySqlConn::getInstance()->executeQuery($query);
	}
	public function changePwd($newPwd){
	    $newPwd = sha1($newPwd);
        $query = "UPDATE users set pwd='$newPwd' WHERE idUser='$this->id'";
        return MySqlConn::getInstance()->executeQuery($query);
    }
	
	public static function connect($mail, $pwd){
		$pwd = sha1($pwd);
		$query = "SELECT * FROM users WHERE mail='$mail' AND pwd='$pwd'";
		$result = MySqlConn::getInstance()->selectDB($query);
		$row = $result->fetch();
		if(!$row) return false;
		
		return new User($row['idUser'], $row['firstname'], $row['lastname'],
				$row['mail'], $row['tel'],$row['fk_idUserTypes'], $row['pwd']);
	}

	public function jsonSerialize() {
		return array('id' => $this->id,
			'firstname' => $this->firstname,
			'lastname' => $this->lastname,
			'mail' => $this->mail,
			'phone' => $this->phone,
			'member_type' => $this->memberType);
	}


	
}