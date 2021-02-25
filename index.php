<?php
    /**
     * connect to data base 
     */
    $servername = 'localhost';
    $username = 'root';
    $pass = '';
    $dbname = 'phpone';

    $conn = mysqli_connect($servername,$username,$pass,$dbname);
    $inserted = FALSE;
    $updated = FALSE;
    $delete = false;
    if(!$conn){
        die("DATA BASe not connected, Becouse of this resion -> ".mysqli_connect_error());
    };
     /* Get requiste */
    // delete the rocord 
    if (isset($_GET['delete'])) {
        # code...
        // echo " sno => ". $_GET['delete'];
        $sno = $_GET['delete'];
        // delete query 
        $sqlDlt = "DELETE FROM `notes` WHERE `notes`.`sno` = $sno";
        $result = mysqli_query($conn,$sqlDlt);
        if ($result) {
            # code...
            $delete = true;
        }else{
            $delete = false;
        }
    };
    /*Post requiste */
    // <!-- INSERTING DATA ON THE DB PHP CODE  -->
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        if(isset($_POST['snoEdit'])){   
            // updated the record 
            // die("DATA BASe not connected, Becouse of this resion -> ".mysqli_connect_error());
            // echo 'yes';
            $utitle = $_POST['titleEdit'];
            $udesc = $_POST['descEdit'];
            $sno = $_POST['snoEdit'];

            // mysql update query
            // "UPDATE `notes` SET `title` = '$utitle', `description` = '$udesc' WHERE `notes`.`sno` = $sno";
            $sqlUpt =  "UPDATE `notes` SET `title` = '$utitle' , `description` = '$udesc' WHERE `notes`.`sno` = $sno";
            $result = mysqli_query($conn,$sqlUpt);
            if($result){
                $updated = TRUE;
            }else{
                echo "Data updated faild Pleas try again and fix the bug!!! --> " . mysqli_error($conn);
            }
        }else{
            # variables... 
            $title = $_POST['title'];
            $desc = $_POST['desc'];
            // INSERT INTO `notes` (`sno`, `title`, `description`, `date`) VALUES ('3', 'third title', 'this is third description', CURRENT_TIMESTAMP);
            $sql = "INSERT INTO `notes` (`title`, `description`, `date`) VALUES ('$title', '$desc', CURRENT_TIMESTAMP)";
            $result = mysqli_query($conn,$sql);

            if($result){
                // this is success alert template
                $inserted = TRUE;
            }
        }
    };

 
?>

<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
    <link rel="stylesheet" href="//cdn.datatables.net/1.10.22/css/jquery.dataTables.min.css">
    <title>iNotes</title>
</head>

<body>

    <!-- edit Modal -->
    <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
            <form action="/phpprojects/noteSproject/index.php" method='Post'>
            <input type="hidden" name="snoEdit" id="snoEdit">
                <div class="mb-3">
                    <label for="title" class="form-label">Title</label>
                    <input type="title" class="form-control" name="titleEdit" id="titleEdit" aria-describedby="Enter you title">
                </div>
                <div class="mb-3">
                    <label for="desc" class="form-label">Disscription</label>
                    <textarea class="form-control" name="descEdit" id="descEdit" rows="3"></textarea>
                </div>
                
                <div class="modal-footer">
                    <button type="reset" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save changes</button>
                </div>
            </form>
            </div>
            
            </div>
        </div>
    </div>

    

    <!-- navigation bar  -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">iNotes</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="#">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Link</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                            data-bs-toggle="dropdown" aria-expanded="false">
                            Dropdown
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <li><a class="dropdown-item" href="#">Action</a></li>
                            <li><a class="dropdown-item" href="#">Another action</a></li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li><a class="dropdown-item" href="#">Something else here</a></li>
                        </ul>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link disabled" href="#" tabindex="-1" aria-disabled="true">Disabled</a>
                    </li>
                </ul>
                <form class="d-flex">
                    <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
                    <button class="btn btn-outline-success" type="submit">Search</button>
                </form>
            </div>
        </div>
    </nav>

    <!-- SHOW MASSAGES OF WHAT IS HEPPEN ON THE DB  -->
    <?php
        if ($inserted || $updated || $delete) {
            # code...
            echo '<div class="alert alert-success alert-dismissible fade show" role="alert"><strong>Success!! </strong> 
            Your operations is successfully done !🎉🎊🎊😀😀!
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>';
        }
    
    ?>

    <!-- form areaya   -->
    <div class="container">
        <h2>Make Your Notes !</h2>
        <hr>

        <form action="/phpprojects/noteSproject/index.php" method='Post'>
            <div class="mb-3">
                <label for="title" class="form-label">Title</label>
                <input type="title" class="form-control" name="title" id="title" aria-describedby="Enter you title">
            </div>
            <div class="mb-3">
                <label for="desc" class="form-label">Disscription</label>
                <textarea class="form-control" name="desc" id="desc" rows="3"></textarea>
            </div>
            <div class="mb-3 form-check">
                <input type="checkbox" class="form-check-input" id="exampleCheck1">
                <label class="form-check-label" for="exampleCheck1">Check me out</label>
            </div>
            <button type="submit" class="btn btn-primary">Add note</button>
        </form>
    </div>

    <!-- Hare all note data show  -->
    <div class="container">
        <hr>
        <h3 style="text-align: center;">Hare is your all notes </h3>
        <hr>
        <table class="table" id="myTable">
            <thead>
                <tr>
                    <th scope="col">sno</th>
                    <th scope="col">Title</th>
                    <th scope="col">Detail</th>
                    <th scope="col">Date</th>
                    <th scope="col">Action</th>
                </tr>
            </thead>
            <tbody>
                <!-- SHOW ALL DATA For CLIENT PHP CODE  -->
                <?php
                    // checking the DB was connect or not
                    if (!$conn) {
                        # code...
                        die("Connections was not successful becouse of this error => ". mysqli_connect_error());
                    }else{
                        echo "Connections was succefull !!<br>";
                    };

                    // show all data read quiry
                    $sql = "SELECT * FROM `notes`";
                    $result = mysqli_query($conn,$sql);
                    $newSno = 0;
                    while ($tR = mysqli_fetch_assoc($result)) {  // this functions give one by one value to any variable
                        $newSno+=1;
                        # code...
                        echo "
                        <tr>
                            <th scope='row'>". $newSno ."</th>
                            <td>". $tR['title'] ."</td>
                            <td>". $tR['description'] ."</td>
                            <td>". $tR['date'] ."</td>
                            <td><button class='btn edit btn-primary mx-1 btn-sm' data-bs-toggle='modal' data-bs-target='#editModal' id=". $tR['sno'] .">Edit</button>
                            <button class='btn delete btn-primary mx-1 btn-sm' id=d" . $tR['sno'] . ">Delete</button></td>
                        </tr>
                      ";
                    };
                    
                
                
                ?>
            </tbody>

        </table>

    </div>
    <hr>
    <!-- Optional JavaScript; choose one of the two! -->

    <!-- jquery cdn  -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"
        integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ygbV9kiqUc6oa4msXn9868pTtWMgiQaeYH7/t7LECLbyPA2x65Kgf80OJFdroafW"
        crossorigin="anonymous"></script>
 
    <!-- table script from datatable.net  -->
    <script src="//cdn.datatables.net/1.10.22/js/jquery.dataTables.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"
        integrity="sha384-q2kxQ16AaE6UbzuKqyBE9/u/KzioAlnx2maXQHiDX9d4/zp8Ok3f+M7DPm+Ib6IU"
        crossorigin="anonymous"></script>
        
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.min.js"
        integrity="sha384-pQQkAEnwaBkjpqZ8RU1fF1AKtTcHJwFl3pblpTlHXybJjHpMYo79HY3hIi4NKxyj"
        crossorigin="anonymous"></script>
        
    <script>
        
    </script>


    <script>
        // table formating jquiry 
        $(document).ready(function () {
            $('#myTable').DataTable();
        });


        const edits = document.getElementsByClassName('edit');
        // console.log(edits);
        Array.from(edits).forEach((element) => {
            element.addEventListener('click', (e) => {
                // console.log('edit',e);
                const tr = e.target.parentNode.parentNode;
                const title = tr.getElementsByTagName('td')[0].innerText;
                const description = tr.getElementsByTagName('td')[1].innerText;
                titleEdit.value = title;  // if the name is uniq then access diractly by name
                descEdit.value = description;
                snoEdit.value = e.target.id;
                // console.log(title, description,snoEdit);
            });
        });

        // delete the content 
        const deletes = document.getElementsByClassName('delete');
        Array.from(deletes).forEach((element)=> {
            element.addEventListener('click',(e) => {
                const sno = e.target.id.substr(1,);
                if(confirm('Do you want to delete the note ??')){
                    window.location = `/phpprojects/noteSproject/index.php?delete=${sno}`;
                }
            })
        })

    </script>
    <!-- Option 2: Separate Popper and Bootstrap JS -->
</body>

</html>