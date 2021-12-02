<?php
$message = '';

session_start();
			
		if(empty($_SESSION["Userid"])){
			if((isset($_COOKIE["Userid"])) && (isset($_COOKIE["UserName"])) && $_COOKIE["Userid"] != '' && $_COOKIE["UserName"] != '') {
				$_SESSION["Userid"] = $_COOKIE["Userid"];
				$_SESSION["UserName"] = $_COOKIE["UserName"];
				}
		}
			

class dbConfig
{
    // Database Connection Properties
    protected $host = 'localhost';
    protected $user = 'root';
    protected $password = '';
    protected $database = "social";

    // connection property
    public $con = null;

    // call constructor
    public function __construct()
    {
        $this->con = mysqli_connect($this->host, $this->user, $this->password, $this->database);
        if ($this->con->connect_error){
            echo "Fail " . $this->con->connect_error;
        }
    }

    public function __destruct()
    {
        $this->closeConnection();
    }

    // for mysqli closing connection
    protected function closeConnection(){
        if ($this->con != null ){
            $this->con->close();
            $this->con = null;
        }
    }
}

class Auth 
{
	private $userTable = 'users';
	private $brands = 'brands';
	private $brandimages = 'brandimages';
	private $companybenefits = 'companybenefits';

	public $db = null;

    public function __construct(dbConfig $db)
    {
        if (!isset($db->con)) return null;
        $this->dbConnect = $db;
    }


    
    public function getData($sqlQuery) {
		$result = mysqli_query($this->dbConnect->con, $sqlQuery);
		if(!$result){
			die('Error in query: '. mysqli_error($result));
		}
		$data= array();
		while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
			$data[]=$row;            
		}
		return $data;
    }

    public function setData($sqlQuery) {
        $message = '';
        $userSaved = mysqli_query($this->dbConnect->con, $sqlQuery);

        if($userSaved){
            $message = 'Data Updated';
        }
        return $message;
    }

	public function getNumRows($sqlQuery) {
		$result = mysqli_query($this->dbConnect->con, $sqlQuery);
		if(!$result){
			die('Error in query: '. mysqli_error($result));
		}
		$numRows = mysqli_num_rows($result);
		return $numRows;
    }


	public function LoginCheck(){
		if(isset($_SESSION["Userid"])) {
			header("Location: user-profile.php");
		} elseif(isset($_SESSION["adminUserid"])) {
			header("Location: admin/dashboard.php");
		}
	}

    public function adminLoginStatus(){
		if(empty($_SESSION["adminUserid"])) {
			header("Location: login.php");
		}
	}

    public function UserLoginStatus(){
		if(empty($_SESSION["Userid"])) {
			header("Location: login.php");
		}
	}



    public function getAuthtoken($email) {
		$code = md5(889966);
		$authtoken = $code."".md5($email);
		return $authtoken;
	}

	public function login(){
		$errorMessage = '';
		if(isset($_POST["login"]) && $_POST["loginId"]!=''&& $_POST["loginPass"]!='') {

			$loginId = $_POST['loginId'];
			$password = $_POST['loginPass'];

			if(isset($_COOKIE["loginPass"]) && $_COOKIE["loginPass"] == $password) {
				$password = $_COOKIE["loginPass"];
			} else {
				$password = md5($password);
			}

			$sqlQuery = "SELECT * FROM ".$this->userTable."
				WHERE email='".$loginId."' AND password='".$password."' AND status = 'active' ";

			$resultSet = mysqli_query($this->dbConnect->con, $sqlQuery);
			$isValidLogin = mysqli_num_rows($resultSet);
			if($isValidLogin){

				
			if(!empty($_POST["remember"]) && $_POST["remember"] != '') {
				setcookie ("loginId", $loginId, time()+ (10 * 365 * 24 * 60 * 60));
				setcookie ("loginPass",	$password,	time()+ (10 * 365 * 24 * 60 * 60));
			} else {
				$_COOKIE['loginId' ]='';
				$_COOKIE['loginPass'] = '';
			}

				$userDetails = mysqli_fetch_assoc($resultSet);

				if($userDetails['type'] == 'user'){
					$_SESSION["Userid"] = $userDetails['id'];
					$_SESSION["UserName"] = $userDetails['fullName'];

					setcookie ("Userid",	$userDetails['id'],	time()+ (10 * 365 * 24 * 60 * 60));
					setcookie ("UserName",	$userDetails['fullName'],	time()+ (10 * 365 * 24 * 60 * 60));

	
						header("location: ./index.php");

				} 
				
				elseif($userDetails['type'] == 'admin') {
					$_SESSION["adminUserid"] = $userDetails['id'];
					$_SESSION["admin"] = $userDetails['fullName'];
	
					header("location: ./index.php");
				}
			
			} else {
				$errorMessage = "Invalid login!";
			}
		} else if(!empty($_POST["loginId"])){
			$errorMessage = "Enter Both username and password!";
		}
		return $errorMessage;
	}



    public function register(){
		$message = ''; 
		if(isset($_POST["register"]) && !empty($_POST["passwd"]) && $_POST["passwd"] !='' && $_POST["passwd"] != $_POST["cpasswd"]){
			$message = "Confirm password is not same.";
		}
		elseif(isset($_POST["register"]) && $_POST["email"] !='') {
			$sqlQuery = "SELECT * FROM ".$this->userTable."
				WHERE email='".$_POST["email"]."'";
			$result = mysqli_query($this->dbConnect->con, $sqlQuery);
			$isUserExist = mysqli_num_rows($result);
			if($isUserExist) {
				$message = 'User already exist with this email address. <a href="login.php">Login</a>';
			} else {
				$insertQuery = "INSERT INTO ".$this->userTable."(fullName, email, password, status, type, datetime)
				VALUES ('".$_POST["name"]."','".$_POST["email"]."', '".md5($_POST["passwd"])."','active','user', NOW())";
				$userSaved = mysqli_query($this->dbConnect->con, $insertQuery);
				if($userSaved) {
					$message = 'User has successfuly registered. <a href="login.php">Login</a>';
				} else {
					$message = 'User register request failed.';
				}
			}
		}
		return $message;
	}


    public function verifyRegister(){
		$verifyStatus = 0;
		if(!empty($_GET["authtoken"]) && $_GET["authtoken"] != '') {
			$sqlQuery = "SELECT * FROM ".$this->userTable."
				WHERE authtoken='".$_GET["authtoken"]."'";
			$resultSet = mysqli_query($this->dbConnect->con, $sqlQuery);
			$isValid = mysqli_num_rows($resultSet);
			if($isValid){
				$userDetails = mysqli_fetch_assoc($resultSet);
				$authtoken = $this->getAuthtoken($userDetails['email']);
				if($authtoken == $_GET["authtoken"]) {
					$updateQuery = "UPDATE ".$this->userTable." SET status = 'active'
						WHERE id='".$userDetails['id']."'";
					$isUpdated = mysqli_query($this->dbConnect->con, $updateQuery);
					if($isUpdated) {
						$verifyStatus = 1;
					}
				}
			}
		}
		return $verifyStatus;
	}


	public function resetPassword(){
		$message = '';
		if(isset($_POST['forgetpassword']) && $_POST['loginId'] == '') {
			$message = '<div class="alert alert-danger" role="alert">Please enter email address</div>';
		} elseif(isset($_POST['forgetpassword']) && $_POST['loginId'] != '') {
			$sqlQuery = "
				SELECT email
				FROM ".$this->userTable."
				WHERE email = '".$_POST['loginId']."'";
			$result = mysqli_query($this->dbConnect->con, $sqlQuery);
			$numRows = mysqli_num_rows($result);
			if($numRows) {
			        $randomPass = rand(10,10000);
			        $md5randomPass = md5($randomPass);
			        
			        	$updateQuery = "UPDATE ".$this->userTable." SET password = '".$md5randomPass."'
						WHERE email = '".$_POST['loginId']."' AND status = 'active'";
					    $isUpdated = mysqli_query($this->dbConnect->con, $updateQuery);
				    	if($isUpdated) {

				       $to = $_POST['loginId'];
                       $subject = "Reset Password";
                       $message = "Your temporary password is: ".$randomPass;

                         $header = "From:donotreply@fitracom.com\r\n";
                         $header .= "MIME-Version: 1.0\r\n";
                         $header .= "Content-type: text/html\r\n";
                       
			    	if(mail ($to,$subject,$message,$header)) {
				    	$message = '<div class="alert alert-success" role="alert">The temporary password has been sent to your email.</div>';
			    	}
				    	}
			} else {
				
				$message = '<div class="alert alert-danger" role="alert">Email not found..</div>';
			}
		}
		return $message;
	}


	public function resetPassword2(){
		$message = '';
		if(isset($_POST['forgetpassword']) && $_POST['email'] == '') {
			$message = "Please enter username or email to proceed with password reset";
		} elseif(isset($_POST['forgetpassword']) && $_POST['email'] != '') {
			$sqlQuery = "
				SELECT email
				FROM ".$this->userTable."
				WHERE email='".$_POST['email']."'";
			$result = mysqli_query($this->dbConnect->con, $sqlQuery);
			$numRows = mysqli_num_rows($result);
			if($numRows) {
				$user = mysqli_fetch_assoc($result);
				$authtoken = $this->getAuthtoken($user['email']);
				$link="<a href='".$_SERVER['SERVER_NAME']."/recover-password.php?authtoken=".$authtoken."'>Reset Password</a>";
				$toEmail = $user['email'];
				$subject = "Reset your password on examplesite.com";
				$msg = "Hi there, click on this ".$link." to reset your password.";
				$msg = wordwrap($msg,70);
				$headers = "From: info@webdamn.com";
				if(mail($toEmail, $subject, $msg, $headers)) {
					$message =  "Password reset link send. Please check your mailbox to reset password.";
				}
			} else {
				$message = "No account exist with entered email address.";
			}
		}
		return $message;
	}

   

    public function savePassword(){
		$message = '';
		if(isset($_POST["resetpassword"]) && $_POST['password'] != $_POST['cpassword']) {
			$message = "Password does not match the confirm password.";
		} elseif(isset($_POST["resetpassword"]) && $_POST['authtoken'] && $_POST['password'] == $_POST['cpassword']) {
			$sqlQuery = "
				SELECT email, authtoken
				FROM ".$this->userTable."
				WHERE authtoken='".$_POST['authtoken']."'";
			$result = mysqli_query($this->dbConnect->con, $sqlQuery);
			$numRows = mysqli_num_rows($result);
			if($numRows) {
				$userDetails = mysqli_fetch_assoc($result);
				$authtoken = $this->getAuthtoken($userDetails['email']);
				if($authtoken == $_POST['authtoken']) {
					$sqlUpdate = "
						UPDATE ".$this->userTable."
						SET password='".md5($_POST['password'])."'
						WHERE email='".$userDetails['email']."' AND authtoken='".$authtoken."'";
					$isUpdated = mysqli_query($this->dbConnect->con, $sqlUpdate);
					if($isUpdated) {
						$message = "Password saved successfully.";
					}
				} else {
					$message = "Invalid password change request.";
				}
			} else {
				$message = "Invalid password change request.";
			}
		}
		return $message;
	}

	public function editAccount () {
		$message = '';
		$updatePassword = '';
		if(!empty($_POST["passwd"]) && $_POST["passwd"] != '' && $_POST["passwd"] != $_POST["cpasswd"]) {
			$message = "Confirm passwords do not match.";
		} else if(!empty($_POST["passwd"]) && $_POST["passwd"] != '' && $_POST["passwd"] == $_POST["cpasswd"]) {
			$updatePassword = ", password='".md5($_POST["passwd"])."' ";
		}
		$updateQuery = "UPDATE ".$this->userTable."
			SET first_name = '".$_POST["firstname"]."', last_name = '".$_POST["lastname"]."', email = '".$_POST["email"]."', country = '".$_POST["country"]."', tele_username = '".$_POST["tele_username"]."', mobile = '".$_POST["mobile"]."', designation = '".$_POST["designation"]."', gender = '".$_POST["gender"]."' $updatePassword
			WHERE id ='".$_SESSION["userid"]."'";
		$isUpdated = mysqli_query($this->dbConnect->con, $updateQuery);
		if($isUpdated) {
			$_SESSION["name"] = $_POST['firstname']." ".$_POST['lastname'];
			$message = "Account details saved.";
		}
		return $message;
	}

	public function editProfile() {
		$message = '';
		$updatePassword = '';

		if(isset($_POST["editProfile"])){

			if(empty($_FILES['File']['name'])){

			$updateQuery = "UPDATE ".$this->userTable."
				SET fullName = '".$this->dbConnect->con->real_escape_string($_POST["fullName"])."', location = '".$this->dbConnect->con->real_escape_string($_POST["location"])."', aboutMe = '".$this->dbConnect->con->real_escape_string($_POST["aboutMe"])."', twitterLink = '".$this->dbConnect->con->real_escape_string($_POST["twitterLink"])."', facebookLink = '".$this->dbConnect->con->real_escape_string($_POST["facebookLink"])."', instagramLink = '".$this->dbConnect->con->real_escape_string($_POST["facebookLink"])."', youtubeLink = '".$this->dbConnect->con->real_escape_string($_POST["youtubeLink"])."'
				WHERE id ='".$_SESSION["Userid"]."'";
			$isUpdated = mysqli_query($this->dbConnect->con, $updateQuery);
			if($isUpdated) {
				$_SESSION["UserName"] = $_POST['fullName'];
				setcookie ("UserName",	$_POST['fullName'],	time()+ (10 * 365 * 24 * 60 * 60));

				$message = "Account details Updated.";
				}

			} else {

				$fileName = $_FILES['File']['name'];
				$ext = pathinfo($fileName, PATHINFO_EXTENSION);
				$fileName = md5(time() . $fileName).'.'.$ext;
				$destination1 = 'userProfiles/'. $fileName;
				$file = $_FILES['File']['tmp_name'];
				$move = move_uploaded_file($file, $destination1);

				$updateQuery = "UPDATE ".$this->userTable."
				SET fullName = '".$this->dbConnect->con->real_escape_string($_POST["fullName"])."', location = '".$this->dbConnect->con->real_escape_string($_POST["location"])."', aboutMe = '".$this->dbConnect->con->real_escape_string($_POST["aboutMe"])."', twitterLink = '".$this->dbConnect->con->real_escape_string($_POST["twitterLink"])."', facebookLink = '".$this->dbConnect->con->real_escape_string($_POST["facebookLink"])."', instagramLink = '".$this->dbConnect->con->real_escape_string($_POST["facebookLink"])."', youtubeLink = '".$this->dbConnect->con->real_escape_string($_POST["youtubeLink"])."',
				profilePhoto = '".$fileName."'
				WHERE id ='".$_SESSION["Userid"]."'";
			$isUpdated = mysqli_query($this->dbConnect->con, $updateQuery);
			if($isUpdated) {
				$_SESSION["UserName"] = $_POST['fullName'];
				setcookie ("UserName",	$_POST['fullName'],	time()+ (10 * 365 * 24 * 60 * 60));

				$message = "Account details Updated.";
				}

			}

		}


		if(isset($_POST["changePassword"])){
			if(!empty($_POST["cupassword"]) && $_POST["cupassword"] != ''){

			$sqlQuery = "SELECT * FROM ".$this->userTable." WHERE id = '".$_SESSION["Userid"]."' ";
					$resultSet = mysqli_query($this->dbConnect->con, $sqlQuery);
					$userDetails = mysqli_fetch_assoc($resultSet);
					$password = $userDetails['password']; 

			if(md5($_POST["cupassword"]) == $password) {
					if(!empty($_POST["password"]) && $_POST["password"] != '' && $_POST["password"] != $_POST["cpassword"] ){
						$message = "Confirm Password does not match.";
					} else if(!empty($_POST["password"]) && $_POST["password"] != '' && $_POST["password"] == $_POST["cpassword"]) {
						$updateQuery = "UPDATE ".$this->userTable." SET password = '".md5($_POST["password"])."' WHERE id ='".$_SESSION["Userid"]."'";
						$isUpdated = mysqli_query($this->dbConnect->con, $updateQuery);
						if($isUpdated) {
							$message = "Password Updated.";
						}
					}

			} else {
				$message = "Current Password is Invelid.";
			}
		} else {
			$message = "Please enter current Password.";
		}
	}

			if(isset($_POST["saveEmail"])){
				$updateQuery = "UPDATE ".$this->userTable." SET email = '".$_POST["email"]."' WHERE id ='".$_SESSION["Userid"]."'";
						$isUpdated = mysqli_query($this->dbConnect->con, $updateQuery);
						if($isUpdated) {
							$message = "Email Updated.";
						}
			}

			if(isset($_POST["saveWalletAddress"])){
				$updateQuery = "UPDATE ".$this->userTable." SET walletAddress = '".$_POST["walletAddress"]."' WHERE id ='".$_SESSION["Userid"]."'";
						$isUpdated = mysqli_query($this->dbConnect->con, $updateQuery);
						if($isUpdated) {
							$message = "Wallet Address Updated.";
						}
			}

			if(isset($_POST["DeleteAccount"])){
				$updateQuery = "UPDATE ".$this->userTable." SET status = 'deleted' WHERE id ='".$_SESSION["Userid"]."'";
						$isUpdated = mysqli_query($this->dbConnect->con, $updateQuery);
						if($isUpdated) {
							$sqlQuery = "SELECT * FROM ".$this->userTable." WHERE id = '".$_SESSION["Userid"]."' ";
								$resultSet = mysqli_query($this->dbConnect->con, $sqlQuery);
								$userDetails = mysqli_fetch_assoc($resultSet);
								$status = $userDetails['status']; 
								if($status == 'deleted'){
									setcookie ("Userid", '', time()- (3600));
									setcookie ("UserName", '', time()- (3600));
									session_destroy();
									header("Location:index.php");
								} else {
									$message = "Something went wrong.";
								}

							
						}
			}

		return $message;

	}



	public function editBrand() {
		$message = '';

		if(isset($_POST["editBrand"])){

			if(empty($_FILES['File']['name'])){

			$updateQuery = "UPDATE ".$this->brands."
				SET brandName = '".$this->dbConnect->con->real_escape_string($_POST["brandName"])."', slogan = '".$this->dbConnect->con->real_escape_string($_POST["slogan"])."',
				 aboutBrand = '".$this->dbConnect->con->real_escape_string($_POST["aboutBrand"])."', category = '".$this->dbConnect->con->real_escape_string($_POST["category"])."',
				  employeeSize = '".$this->dbConnect->con->real_escape_string($_POST["employeeSize"])."', founded = '".$this->dbConnect->con->real_escape_string($_POST["founded"])."',
				   brandStatus = '".$this->dbConnect->con->real_escape_string($_POST["brandStatus"])."', link = '".$this->dbConnect->con->real_escape_string($_POST["link"])."',
				   twitterLink = '".$this->dbConnect->con->real_escape_string($_POST["twitterLink"])."', facebookLink = '".$this->dbConnect->con->real_escape_string($_POST["facebookLink"])."',
				   instagramLink = '".$this->dbConnect->con->real_escape_string($_POST["instagramLink"])."', youtubeLink = '".$this->dbConnect->con->real_escape_string($_POST["youtubeLink"])."'
				WHERE id ='".$_POST["id"]."'";
			$isUpdated = mysqli_query($this->dbConnect->con, $updateQuery);
			if($isUpdated) {
				$message = "Account details Updated.";
				}

			} else {

				$fileName = $_FILES['File']['name'];
				$ext = pathinfo($fileName, PATHINFO_EXTENSION);
				$fileName = md5(time() . $fileName).'.'.$ext;
				$destination1 = 'brandImages/'. $fileName;
				$file = $_FILES['File']['tmp_name'];
				$move = move_uploaded_file($file, $destination1);

				$updateQuery = "UPDATE ".$this->brands."
				SET brandName = '".$this->dbConnect->con->real_escape_string($_POST["brandName"])."', slogan = '".$this->dbConnect->con->real_escape_string($_POST["slogan"])."',
				aboutBrand = '".$this->dbConnect->con->real_escape_string($_POST["aboutBrand"])."', category = '".$this->dbConnect->con->real_escape_string($_POST["category"])."',
				 employeeSize = '".$this->dbConnect->con->real_escape_string($_POST["employeeSize"])."', founded = '".$this->dbConnect->con->real_escape_string($_POST["founded"])."',
				  brandStatus = '".$this->dbConnect->con->real_escape_string($_POST["brandStatus"])."', link = '".$this->dbConnect->con->real_escape_string($_POST["link"])."',
				  twitterLink = '".$this->dbConnect->con->real_escape_string($_POST["twitterLink"])."', facebookLink = '".$this->dbConnect->con->real_escape_string($_POST["facebookLink"])."',
				  instagramLink = '".$this->dbConnect->con->real_escape_string($_POST["instagramLink"])."', youtubeLink = '".$this->dbConnect->con->real_escape_string($_POST["youtubeLink"])."',
				profilePhoto = '".$fileName."'
				WHERE id ='".$_POST["id"]."'";
			$isUpdated = mysqli_query($this->dbConnect->con, $updateQuery);
			if($isUpdated) {

				$message = "Account details Updated.";
				}

			}

		}

		
			if(isset($_POST["delete_image"])){
				$delete_image = "DELETE FROM ".$this->brandimages." WHERE id = '".$_POST["image_id"]."'";
				$isUpdated = mysqli_query($this->dbConnect->con, $delete_image);

				   if($isUpdated) {
					   $message = "Image deleted.";
				
				   } else {
					   $message = "Something went wrong.";
				   }
			}

			if(isset($_POST["DeleteBrandAccount"])){
				$updateQuery = "UPDATE ".$this->brands." SET status = 'deleted' WHERE id = '".$_POST["id"]."'";
						$isUpdated = mysqli_query($this->dbConnect->con, $updateQuery);
						if($isUpdated) {
							
								$message = "Brand Account deletet.";

								} else {
									$message = "Something went wrong.";
								}

			}

			if(isset($_POST["updateB"])){
						    // File upload configuration						
						 $errorMsg = $insertValuesSQL = $Message = '';
							$includes = $_POST['includes'];
							if(!empty($includes)){
								foreach($_POST['includes'] as $key=>$includes){
									// File upload path
											$insertValuesSQL .= "('".$_POST["id"]."','".$includes."'),";
								}
						
								if(!empty($insertValuesSQL)){
									$insertValuesSQL = trim($insertValuesSQL, ',');
									// Insert image file name into database
									$insert = "INSERT INTO ".$this->companybenefits." (link_id, details) VALUES $insertValuesSQL";
									$isUpdated = mysqli_query($this->dbConnect->con, $insert);
		
									if($insert){
									
										$Message = "Benefits are updated successfully.";
									}else{
										$Message = "Sorry, there was an error updated.";
									}
								}
							} else{
								$Message = 'Add Benefits';
							}

			}

			if(isset($_POST["upload"])){

				    // File upload configuration
					$targetDir = "brandImages/";
					$allowTypes = array('jpg','png','jpeg','gif','JPG','PNG','JPEG');
				
					$statusMsg = $errorMsg = $insertValuesSQL = $errorUpload = $errorUploadType = '';
					$fileNames = array_filter($_FILES['files']['name']);
					if(!empty($fileNames)){
						foreach($_FILES['files']['name'] as $key=>$val){
							// File upload path
							$fileName = basename($_FILES['files']['name'][$key]);
							$targetFilePath = $targetDir . $fileName;
				
							// Check whether file type is valid
							$fileType = pathinfo($targetFilePath, PATHINFO_EXTENSION);
							if(in_array($fileType, $allowTypes)){
								// Upload file to server
								if(move_uploaded_file($_FILES["files"]["tmp_name"][$key], $targetFilePath)){
									// Image db insert sql
									$insertValuesSQL .= "('".$_POST["id"]."','".$fileName."'),";
								}else{
									$errorUpload .= $_FILES['files']['name'][$key].' | ';
								}
							}else{
								$errorUploadType .= $_FILES['files']['name'][$key].' | ';
							}
						}
				
						if(!empty($insertValuesSQL)){
							$insertValuesSQL = trim($insertValuesSQL, ',');
							// Insert image file name into database
							$insert = "INSERT INTO ".$this->brandimages." (link_id, image) VALUES $insertValuesSQL";
							$isUpdated = mysqli_query($this->dbConnect->con, $insert);

							if($insert){
								$errorUpload = !empty($errorUpload)?'Upload Error: '.trim($errorUpload, ' | '):'';
								$errorUploadType = !empty($errorUploadType)?'File Type Error: '.trim($errorUploadType, ' | '):'';
								$errorMsg = !empty($errorUpload)?'<br/>'.$errorUpload.'<br/>'.$errorUploadType:'<br/>'.$errorUploadType;
								$Message = "Files are uploaded successfully.".$errorMsg;
							}else{
								$Message = "Sorry, there was an error uploading your file.";
							}
						}
					}else{
						$Message = 'You have not select files (optinal)';
					}

			}


			if(isset($_POST["upload"])){

				// File upload configuration
				$targetDir = "brandImages/";
				$allowTypes = array('jpg','png','jpeg','gif','JPG','PNG','JPEG');
			
				$statusMsg = $errorMsg = $insertValuesSQL = $errorUpload = $errorUploadType = '';
				$fileNames = array_filter($_FILES['files']['name']);
				if(!empty($fileNames)){
					foreach($_FILES['files']['name'] as $key=>$val){
						// File upload path
						$fileName = basename($_FILES['files']['name'][$key]);
						$targetFilePath = $targetDir . $fileName;
			
						// Check whether file type is valid
						$fileType = pathinfo($targetFilePath, PATHINFO_EXTENSION);
						if(in_array($fileType, $allowTypes)){
							// Upload file to server
							if(move_uploaded_file($_FILES["files"]["tmp_name"][$key], $targetFilePath)){
								// Image db insert sql
								$insertValuesSQL .= "('".$_POST["id"]."','".$fileName."'),";
							}else{
								$errorUpload .= $_FILES['files']['name'][$key].' | ';
							}
						}else{
							$errorUploadType .= $_FILES['files']['name'][$key].' | ';
						}
					}
			
					if(!empty($insertValuesSQL)){
						$insertValuesSQL = trim($insertValuesSQL, ',');
						// Insert image file name into database
						$insert = "INSERT INTO ".$this->brandimages." (link_id, image) VALUES $insertValuesSQL";
						$isUpdated = mysqli_query($this->dbConnect->con, $insert);

						if($insert){
							$errorUpload = !empty($errorUpload)?'Upload Error: '.trim($errorUpload, ' | '):'';
							$errorUploadType = !empty($errorUploadType)?'File Type Error: '.trim($errorUploadType, ' | '):'';
							$errorMsg = !empty($errorUpload)?'<br/>'.$errorUpload.'<br/>'.$errorUploadType:'<br/>'.$errorUploadType;
							$Message = "Files are uploaded successfully.".$errorMsg;
						}else{
							$Message = "Sorry, there was an error uploading your file.";
						}
					}
				}else{
					$Message = 'You have not select files (optinal)';
				}

		}

			if(isset($_POST["DeleteAccount"])){
				$updateQuery = "UPDATE ".$this->brands." SET status = 'deleted' WHERE id ='".$_SESSION["Userid"]."'";
						$isUpdated = mysqli_query($this->dbConnect->con, $updateQuery);
						if($isUpdated) {
							$sqlQuery = "SELECT * FROM ".$this->userTable." WHERE id = '".$_SESSION["Userid"]."' ";
								$resultSet = mysqli_query($this->dbConnect->con, $sqlQuery);
								$userDetails = mysqli_fetch_assoc($resultSet);
								$status = $userDetails['status']; 
								if($status == 'deleted'){
									setcookie ("Userid", '', time()- (3600));
									setcookie ("UserName", '', time()- (3600));
									session_destroy();
									header("Location:index.php");
								} else {
									$message = "Something went wrong.";
								}

							
						}
			}

		return $message;

	}

	public function createBrand() {
		$message = '';

		if(isset($_POST["createBrand"])){

			$sqlQuery = "SELECT * FROM ".$this->brands." WHERE user_id = '".$_SESSION["Userid"]."' AND brandName = '".$_POST["brandName"]."' ";
					$result = mysqli_query($this->dbConnect->con, $sqlQuery);
					$isBrandExist = mysqli_num_rows($result);
				if(!$isBrandExist) {
						$updateQuery = "INSERT INTO ".$this->brands."(user_id, brandName, category, aboutMe)
						VALUES ('".$_SESSION["Userid"]."','".$_POST["brandName"]."', '".$_POST["category"]."','".$_POST["aboutMe"]."')";
						$isUpdated = mysqli_query($this->dbConnect->con, $updateQuery);
						if($isUpdated) {
							$message = "Account details Updated.";
						}
				} else {
					$message = "Brand name already exists.";
				}

		}

			return $message;

	}

	public function time_elapsed_string($datetime, $full = false) {
		$now = new DateTime;
		$ago = new DateTime($datetime);
		$diff = $now->diff($ago);
	
		$diff->w = floor($diff->d / 7);
		$diff->d -= $diff->w * 7;
	
		$string = array(
			'y' => 'year',
			'm' => 'month',
			'w' => 'week',
			'd' => 'day',
			'h' => 'hour',
			'i' => 'minute',
			's' => 'second',
		);
		foreach ($string as $k => &$v) {
			if ($diff->$k) {
				$v = $diff->$k . ' ' . $v . ($diff->$k > 1 ? 's' : '');
			} else {
				unset($string[$k]);
			}
		}
	
		if (!$full) $string = array_slice($string, 0, 1);
		return $string ? implode(', ', $string) . ' ago' : 'just now';
	}



	public function saveAdminPassword(){
		$message = '';
		if($_POST['password'] && $_POST['password'] != $_POST['cpassword']) {
			$message = "Password does not match the confirm password.";
		} else {
			$sqlUpdate = "
				UPDATE ".$this->userTable."
				SET password='".md5($_POST['password'])."'
				WHERE id='".$_SESSION['adminUserid']."' AND type='administrator'";
			$isUpdated = mysqli_query($this->dbConnect->con, $sqlUpdate);
			if($isUpdated) {
				$message = "Password saved successfully.";
			}
		}
		return $message;
	}
	public function adminDetails () {
		$sqlQuery = "SELECT * FROM ".$this->userTable."
			WHERE id ='".$_SESSION["adminUserid"]."'";
		$result = mysqli_query($this->dbConnect->con, $sqlQuery);
		$userDetails = mysqli_fetch_assoc($result);
		return $userDetails;
	}

}

$db = new dbConfig();
$data = new Auth($db);


?>