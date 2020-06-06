<?php
$error=array();
$name =$email = $phone_no = "";
if ($_SERVER["REQUEST_METHOD"] == "POST") 
{
	if(isset($_POST["name"])!='' && isset($_POST["email"])!='' && isset($_POST["phone_no"])!='')
	{
        $name=$_POST["name"]; 
        $phone_no=$_POST["phone_no"];
        $email=$_POST["email"];

        if (!preg_match("/^[a-zA-Z ]*$/",$name)) 
        {
            array_push($error,"Only letters and white space allowed");   
            $name=""; 
        }
        if(!filter_var($email, FILTER_VALIDATE_EMAIL))
        {
            array_push($error,"Invalid email format"); 
            $email="";   
        }
        if(!preg_match("/^[0-9]{10}$/",$phone_no))
        {
            array_push($error,"enter the valid phone number"); 
            $phone_no="";   
        }
        if(count($error)==0){

            include 'connect.php';
            $sql = "select * from studentform where name ='$name'";
            $result=mysqli_query($conn, $sql);
            $resultCheck=mysqli_num_rows($result);
            if ($resultCheck > 0) {
                array_push($error,'Student already Registered');
            }

            else{
                $sql = "INSERT INTO `studentform` (`name`, `email`, `phone_no`) VALUES ('$name','$email','$phone_no')";
                $result=mysqli_query($conn, $sql);
				if(!$result)
				{
                   array_push($error,"Something Went Wrong try again after sometime");
                }
            }
        }
    }
    else{
        array_push($error,"All Fields are mandatory");
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>
    <link rel="icon" type="image/png" sizes="192x192" href="download.png">
    <script>
        $(document).ready(function(){
            $(".close").click(function(){
                $("#myAlert").alert("close");
            });
        });
    </script>
    <style>
        header {
        color: white;
        /* background-color:black; */
        padding:10px;
        text-align: center;
        font-weight: bolder;
        /* border-bottom: 2px solid black; */
        }
        body{
            color:white;
            /* background-color:#DBF5F0; */
        }
        .myformContainer{
            display:flex;
            justify-content: center;
            align-items: center;
            border-radius:10px;
            height:500px;
            
        }
        form{
            margin:20px;
            margin-top:5px;
            border-radius:10px;
            background-color:black;
            box-shadow: 0 4px 8px 4px grey;
            padding:30px 20px;
            width:50%;
        }
        .form-group{
            margin:20px 5px;
        }
        label{
            font-size:18px;
        }
        .form-control{
            height:40px;
            
        }
        .radio{
            margin-left:10px;
        }
        .radio label
        {
            font-size:15px;
        }
        input[type=submit]
        {
            display:block;
            text-transform:uppercase;
            padding:5px 20px;
            margin:auto;
        }
        .myalert{
            margin-top:10px;
        }
        @media screen and (max-width: 750px) {
            form{
            width:100%;
            }
        }
        .alert{
            animation: shake 0.5s;
            animation-iteration-count: 1;
        }
        @keyframes shake {
            0% { transform: translate(1px, 1px) rotate(0deg); }
            10% { transform: translate(-1px, -2px) rotate(-1deg); }
            20% { transform: translate(-3px, 0px) rotate(1deg); }
            30% { transform: translate(3px, 2px) rotate(0deg); }
            40% { transform: translate(1px, -1px) rotate(1deg); }
            50% { transform: translate(-1px, 2px) rotate(-1deg); }
            60% { transform: translate(-3px, 1px) rotate(0deg); }
            70% { transform: translate(3px, 1px) rotate(-1deg); }
            80% { transform: translate(-1px, -1px) rotate(1deg); }
            90% { transform: translate(1px, 2px) rotate(0deg); }
            100% { transform: translate(1px, -2px) rotate(-1deg); }
        }
    </style>
    <title>Girlscript</title>
    
</head>
<body>
    <header class="container-fluid">
     <img src="gs_new.png" alt="" height="120px" > 
    </header>

    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        echo '<div class="myalert">';
        if(count($error)>0)
        {
                foreach($error as $err)
                {
                    echo '<div class="container">
                            <div class="alert alert-danger alert-dismissible" id="myAlert">
                                <a href="#" class="close">&times;</a>
                                <strong>error! </strong>'.$err.'
                            </div>
                        </div>';
                }
        }
        else{
            echo '<div class="container">
                    <div class="alert alert-success alert-dismissible" id="myAlert">
                        <a href="#" class="close">&times;</a>
                        <strong>success! </strong>Registered Successfully!!
                    </div>
                </div>';
        } 
        echo '</div>';  
    }    
    ?>
    <div class="container">
        <div class="myformContainer">
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="POST">
        <div class="form-group">
            <label id="name" for="name">Name</label>
            <input type="text" name="name" class="form-control" value="<?php if(count($error)>0){ echo $name;}?>" placeholder="Enter Student name" required>
        </div>
        <div class="form-group">
            <label id="email" for="email">Email</label>
            <input type="email" name="email" required class="form-control" value="<?php if(count($error)>0){ echo $email;}?>"  placeholder="Enter email">
        </div>

        <div class="form-group">
            <label id="phone_no" for="phone_no">Phone Number</label>
            <input type="text" name="phone_no"  required class="form-control" <?php if(count($error)>0){ echo $phone_no;}?> placeholder="Enter phone number">
        </div>  
        
        <input type="submit" name="Submit" class="btn btn-default" value="submit">
        
    </form>
        </div> 
    </div>
</body>
</html>
