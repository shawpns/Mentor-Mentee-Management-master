<?php
require_once('mail.php');


function random_string($length = 8) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return strtoupper($randomString);
}

/*
	Check if a session user id exist or not. If not set redirect
	to login page. If the user session id exist and there's found
	$_GET['logout'] in the query string logout the user
*/
function checkFDUser()
{
	// if the session id is not set, redirect to login page
	if (!isset($_SESSION['calendar_fd_user'])) {
		header('Location: ' . WEB_ROOT . 'login.php');
		exit;
	}
	// the user want to logout
	if (isset($_GET['logout'])) {
		doLogout();
	}
}

function doLogin() {
    $name = $_POST['name'];
    $pwd  = $_POST['pwd'];

    $errorMessage = '';

    // Fetch the user record
    $sql  = "SELECT * FROM tbl_users WHERE name = '$name' AND status = 'active'";
    $result = dbQuery($sql);

    if (dbNumRows($result) == 1) {
        $row = dbFetchAssoc($result);
        $hashedPassword = $row['pwd'];

        // Verify the password using MD5 (not recommended for production)
        if (md5($pwd) === $hashedPassword) {
            $_SESSION['calendar_fd_user'] = $row;
            $_SESSION['calendar_fd_user_name'] = $row['username'];
            header('Location: index.php');
            exit();
        } else {
            $errorMessage = 'Invalid username/password. Please try again.';
        }
    } else {
        $errorMessage = 'Invalid username/password or user is not active. Please try again.';
    }
    return $errorMessage;
}


/*
	Logout a user
*/
function doLogout()
{
	if (isset($_SESSION['calendar_fd_user'])) {
		unset($_SESSION['calendar_fd_user']);
		//session_unregister('hlbank_user');
	}
	header('Location: index.php');
	exit();
}


//student or teacher will register
function registerUser () {
    $name     = $_POST['name'];
    $pwd      = $_POST['pwd']; // Get the password from POST data
    $address  = $_POST['address'];
    $phone    = $_POST['phone'];
    $email    = $_POST['email'];
    $type     = $_POST['type'];

	// // After successful registration, create a Google Meet link
    // $eventName = "Welcome Meeting"; // Customize the event name
    // $eventDateTime = date('Y-m-d\TH:i:s', strtotime('+1 day')); // Set the event time (e.g., 1 day from now)

    // $meetLink = createGoogleMeet($email, $eventName, $eventDateTime);

    // // Send the Google Meet link to the registered email
    // mail($email, "Your Google Meet Link", "You can join the meeting using the following link: $meetLink");

    // // Return success message or redirect
    // return "Registration successful! A Google Meet link has been sent to your email.";

	

    // Check if user with the same name already exists
    $hsql = "SELECT * FROM tbl_users WHERE name = '$name'";
    $hresult = dbQuery($hsql);
    if (dbNumRows($hresult) > 0) {
        $errorMessage = 'User  with the same name already exists. Please try another name.';
        header('Location: register.php?err=' . urlencode($errorMessage));
        exit();
    }

    // Simple password hashing using MD5 (not recommended for production)
    $hashedPwd = md5($pwd); // Use a better hashing method in production

    $sql = "INSERT INTO tbl_users (name, pwd, address, phone, email, type, status, bdate)
            VALUES ('$name', '$hashedPwd', '$address', '$phone', '$email', '$type', 'inactive', NOW())";    
    dbQuery($sql);

    // Send email on registration confirmation
    $bodymsg = "User  $name is registered and currently in INACTIVE state. Please contact admin for activation.";
    $data = array('to' => $email, 'sub' => 'Registration Confirmation', 'msg' => $bodymsg);
    // send_email($data); // Uncomment if email function is implemented
    header('Location: register.php?msg=' . urlencode('User  successfully registered.'));
    exit();
}

function getBookingRecords(){
	$per_page = 10;
	$page = (isset($_GET['page']) && $_GET['page'] != '') ? $_GET['page'] : 1;
	$start 	= ($page-1)*$per_page;
	$sql 	= "SELECT u.id AS uid, u.name, u.phone, u.email,
			   r.ucount, r.rdate, r.status, r.comments   
			   FROM tbl_users u, tbl_reservations r 
			   WHERE u.id = r.uid  
			   ORDER BY r.id DESC LIMIT $start, $per_page";
	//echo $sql;
	$result = dbQuery($sql);
	$records = array();
	while($row = dbFetchAssoc($result)) {
		extract($row);
		$records[] = array("user_id" => $uid,
							"user_name" => $name,
							"user_phone" => $phone,
							"user_email" => $email,
							"count" => $ucount,
							"res_date" => $rdate,
							"status" => $status,
							"comments" => $comments);	
	}//while
	return $records;
}


function getUserRecords(){
	$per_page = 20;
	$page = (isset($_GET['page']) && $_GET['page'] != '') ? $_GET['page'] : 1;
	$start 	= ($page-1)*$per_page;
	
	$type = $_SESSION['calendar_fd_user']['type'];
	if($type == 'student') {
		$id = $_SESSION['calendar_fd_user']['id'];
		$sql = "SELECT  * FROM tbl_users u WHERE type != 'admin' AND id = $id ORDER BY u.id DESC";
	}
	else {
		$sql = "SELECT  * FROM tbl_users u WHERE type != 'admin' ORDER BY u.id DESC LIMIT $start, $per_page";
	}
	
	//echo $sql;
	$result = dbQuery($sql);
	$records = array();
	while($row = dbFetchAssoc($result)) {
		extract($row);
		$records[] = array("user_id" => $id,
			"user_name" => $name,
			"user_phone" => $phone,
			"user_email" => $email,
			"type" => $type,
			"status" => $status,
			"bdate" => $bdate
		);	
	}
	return $records;
}

function getHolidayRecords() {
	$per_page = 10;
	$page 	= (isset($_GET['page']) && $_GET['page'] != '') ? $_GET['page'] : 1;
	$start 	= ($page-1)*$per_page;
	$sql 	= "SELECT * FROM tbl_holidays ORDER BY id DESC LIMIT $start, $per_page";
	//echo $sql;
	$result = dbQuery($sql);
	$records = array();
	while($row = dbFetchAssoc($result)) {
		extract($row);
		$records[] = array("hid" => $id, "hdate" => $date,"hreason" => $reason);	
	}//while
	return $records;
}

function generateHolidayPagination() {
	$per_page = 10;
	$sql 	= "SELECT * FROM tbl_holidays";
	$result = dbQuery($sql);
	$count 	= dbNumRows($result);
	$pages 	= ceil($count/$per_page);
	$pageno = '<ul class="pagination pagination-sm no-margin pull-right">';
	for($i=1; $i<=$pages; $i++)	{
		$pageno .= "<li><a href=\"?v=HOLY&page=$i\">".$i."</a></li>";
	}
	$pageno .= 	"</ul>";
	return $pageno;
}

function generatePagination(){
	$per_page = 10;
	$sql 	= "SELECT * FROM tbl_users";
	$result = dbQuery($sql);
	$count 	= dbNumRows($result);
	$pages 	= ceil($count/$per_page);
	$pageno = '<ul class="pagination pagination-sm no-margin pull-right">';
	for($i=1; $i<=$pages; $i++)	{
	//<li><a href="#">1</a></li>
		//$pageno .= "<a href=\"?v=USER&page=$i\"><li id=\".$i.\">".$i."</li></a> ";
		$pageno .= "<li><a href=\"?v=USER&page=$i\">".$i."</a></li>";
	}
	$pageno .= 	"</ul>";
	return $pageno;
}

?>