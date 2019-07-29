<!-- (file2 show all information) -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Dashboard</title>
<!-- (1)copy 3 link -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.js"></script>
<!-- (2)style -->
    <style type="text/css">
        .wrapper{
            /* ความห่างระหว่าง Employees Details & Add new Employee */
            width: 650px;
            margin: 0 auto;
        }
        .page-header h2{
            margin-top: 0;
        }
        table tr td:last-child a{
            margin-right: 15px;
        }
    </style>
<!-- (3)Call function ข้อความจะขึ้นเมื่อเอาเมาส์ไปชี้ที่icon-->
    <script type="text/javascript">
        $(document).ready(function(){
            $('[data-toggle="tooltip"]').tooltip();   
        });
    </script>
</head>
<body>
<!-- (4)bootstrap -->
        <div class="wrapper">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div class="page-header clearfix">
                            <h2 class="pull-left">Employees Details</h2>
                            <a href="create.php" class="btn btn-success pull-right">Add New Employee</a>
                        </div>
                        <?php
                        // (5)Include config file
                        require_once "config.php";
                        
                        // Attempt select query execution
                        $sql = "SELECT * FROM employees";
                        // link from config file
                        if($result = mysqli_query($link, $sql)){
                            //เช็ค if หากมีการเพิ่มข้อมูลก็จะแสดงตารางออกมา
                            if(mysqli_num_rows($result) > 0){
                                echo "<table class='table table-bordered table-striped'>";
                                    //read => T-Head
                                    echo "<thead>";
                                    //Table Row
                                        echo "<tr>";
                                            echo "<th>#</th>";
                                            echo "<th>Name</th>";
                                            echo "<th>Address</th>";
                                            echo "<th>Salary</th>";
                                            echo "<th>Action</th>";
                                        echo "</tr>";
                                    echo "</thead>";
                                    echo "<tbody>";
                                    // ลูปข้อมูลจากTable Employee Database
                                    // function fetch
                                    while($row = mysqli_fetch_array($result)){
                                        echo "<tr>";
                                            echo "<td>" . $row['id'] . "</td>";
                                            echo "<td>" . $row['name'] . "</td>";
                                            echo "<td>" . $row['address'] . "</td>";
                                            echo "<td>" . $row['salary'] . "</td>";
                                            echo "<td>";
                                            // link title icon
                                                echo "<a href='read.php?id=". $row['id'] ."' title='View Record' data-toggle='tooltip'><span class='glyphicon glyphicon-eye-open'></span></a>";
                                                echo "<a href='update.php?id=". $row['id'] ."' title='Update Record' data-toggle='tooltip'><span class='glyphicon glyphicon-pencil'></span></a>";
                                                echo "<a href='delete.php?id=". $row['id'] ."' title='Delete Record' data-toggle='tooltip'><span class='glyphicon glyphicon-trash'></span></a>";
                                            echo "</td>";
                                        echo "</tr>";
                                    }
                                    echo "</tbody>";                            
                                echo "</table>";
                                // function => free result set
                                mysqli_free_result($result);
                            } else{
                                echo "<p class='lead'><em>No records were found.</em></p>";
                            }
                        } else{
                            echo "ERROR: Could not able to execute $sql. " . mysqli_error($link);
                        }
    
                        // Close connection ปิดการเชื่อมต่อ
                        mysqli_close($link);
                        ?>
                    </div>
                </div>        
            </div>
        </div>
</body>
</html>