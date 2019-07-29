<!-- (file3) insert -->
<!-- (1)สร้างฟรอม html
(2)สร้างการเชื่อมต่อ (php) -->
<!-- validate(ตรวจสอบ) -->
<?php
// Include config file
require_once "config.php";
 
// Define variables and initialize with empty values
/*สามารถเขียนได้ 2 แบบ
$name = "";
$address = "";
$salary = "";*/
$name = $address = $salary = ""; 
$name_err = $address_err = $salary_err = "";
 
// Processing form data when form is submitted(เมื่อฟรอมถูกซับมิทก็จะทำการประมวลผล)
if($_SERVER["REQUEST_METHOD"] == "POST"){
    // Validate name (ตรวจสอบชื่อ)
    //เมื่อทำการป้อนชื่อ ในรูปแบบ post
    $input_name = trim($_POST["name"]);
    // ถ้าค่าว่าง ให้เพิ่มข้อมูล
    if(empty($input_name)){
        $name_err = "Please enter a name.";
    // แต่ถ้า พิมพ์ข้อมูลแปลกๆ ให้ใส่ข้อมูลที่ถูกต้อง
    } elseif(!filter_var($input_name, FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^[a-zA-Z\s]+$/")))){
        $name_err = "Please enter a valid name.";
    // หากถูกอย่างถูกต้อง จะเพิ่มข้อมูลในตัวแปร $input_name;
    } else{
        $name = $input_name;
    }
    
    // Validate address
    $input_address = trim($_POST["address"]);
    if(empty($input_address)){
        $address_err = "Please enter an address.";     
    } else{
        $address = $input_address;
    }
    
    // Validate salary
    $input_salary = trim($_POST["salary"]);
    if(empty($input_salary)){
        $salary_err = "Please enter the salary amount.";     
    } elseif(!ctype_digit($input_salary)){
        $salary_err = "Please enter a positive integer value.";
    } else{
        $salary = $input_salary;
    }
    
    // Check input errors before inserting in database
    // (เช็คว่ามีความผิดพลาดไหมก่อนที่จะเพิ่มข้อมูลลงไปในฐานข้อมูล)
    if(empty($name_err) && empty($address_err) && empty($salary_err)){
        // Prepare an insert statement(เตรียมสถานะการเพิ่มข้อมูล )
        $sql = "INSERT INTO employees (name, address, salary) VALUES (?, ?, ?)";
        //สร้างตัวแปร stmt เก็บฟังก์ชัน mysqli_prepare มีพารามิเตอร์ $link = การเชื่อมต่อ $sql = ตัวแปรฐานข้อมูล
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            // sss คือ string แทน  $param_name, $param_address, $param_salary
            mysqli_stmt_bind_param($stmt, "sss", $param_name, $param_address, $param_salary);
            
            // Set parameters
            $param_name = $name;
            $param_address = $address;
            $param_salary = $salary;
            
            // Attempt to execute the prepared statement
            //ถ้าเกิดมีการเพิ่มข้อมูลลงไปใน employees table แล้วให้มันไปที่หน้า index.php
            //excute คือ ประมวลผล stmt = statement
            if(mysqli_stmt_execute($stmt)){
                // Records created successfully. Redirect to landing page
                header("location: index.php");
                exit();
            } else{
                echo "Something went wrong. Please try again later.";
            }
        }
         
        // Close statement
        mysqli_stmt_close($stmt);
    }
    
    // Close connection
    mysqli_close($link);
}
?>
<!-- create form --> 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Create Record</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
    <style type="text/css">
    /* จัดกึ่งกลาง */
        .wrapper{
            width: 500px;
            margin: 0 auto;
        }
    </style>
</head>
<body>
    <div class="wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="page-header">
                        <h2>Create Record</h2>
                    </div>
                    <p>Please fill this form and submit to add employee record to the database.</p>
                    <!-- วิธีการป้อนกันเว็บไซต์ ไม่ให้hackerเข้าถึงได้ ต้องเพิ่ม htmlspecialchars = แปลงโค้ด -->
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                    <!-- เช็ค if else แบบสั้นๆ -->
                        <div class="form-group <?php echo (!empty($name_err)) ? 'has-error' : ''; ?>">
                            <label>Name</label>
                            <!-- เพิ่มตรง value เมื่อเราพิมพ์อะไรเข้าไป ก็ให้แสดงอันนั้นออกมา -->
                            <input type="text" name="name" class="form-control" value="<?php echo $name; ?>">
                            <!-- เมื่อมีการผิดพลาด ก็ให้แสดง error ออกมาตามที่เราได้ใส่ไปด้านบน -->
                            <span class="help-block"><?php echo $name_err;?></span>
                        </div>
                        <div class="form-group <?php echo (!empty($address_err)) ? 'has-error' : ''; ?>">
                            <label>Address</label>
                            <textarea name="address" class="form-control"><?php echo $address; ?></textarea>
                            <span class="help-block"><?php echo $address_err;?></span>
                        </div>
                        <div class="form-group <?php echo (!empty($salary_err)) ? 'has-error' : ''; ?>">
                            <label>Salary</label>
                            <input type="text" name="salary" class="form-control" value="<?php echo $salary; ?>">
                            <span class="help-block"><?php echo $salary_err;?></span>
                        </div>
                        <input type="submit" class="btn btn-primary" value="Submit">
                        <a href="index.php" class="btn btn-default">Cancel</a>
                    </form>
                </div>
            </div>        
        </div>
    </div>
</body>
</html>