<?php
require_once "inc/functions.php";
$info = '';
$task = $_GET['task'] ?? 'report';
$error = $_GET['error'] ?? '0';
if ('reset' == $task) {
    resetData();
    $info = "Reset is complete";
}
if('delete' == $task){
    $id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_SPECIAL_CHARS);
    deleteID($id);
    header('location: index.php?task=report');
}
$fname = '';
$lname = '';
$roll = '';
if (isset($_POST['submit'])) {
    $fname = filter_input(INPUT_POST, 'fname', FILTER_SANITIZE_SPECIAL_CHARS);
    $lname = filter_input(INPUT_POST, 'lname', FILTER_SANITIZE_SPECIAL_CHARS);
    $roll = filter_input(INPUT_POST, 'roll', FILTER_SANITIZE_SPECIAL_CHARS);
    $id = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_SPECIAL_CHARS);

    if ($id) {
        if ($fname != '' && $lname != '' && $roll != '') {
            $result = updateStudentInfo($id, $fname, $lname, $roll);
            if ($result) {
                header('location: index.php?task=report');
            } else {
                $error = 1;
            }
        }
    } else {
        if ($fname != '' && $lname != '' && $roll != '') {
            $result = addStudent($fname, $lname, $roll);
            if ($result) {
                header('location: index.php?task=report');
            } else {
                $error = 1;
            }
        };
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="assets/style.css">
    <title>CRUD PROJECT</title>
</head>

<body>

    <main>
        <div class="container">
            <div class="header mt-5 text-center">
                <h2>CRUD PROJECT</h2>
                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Tempore sequi cumque illum maiores iure officiis?</p>
            </div>
            <nav class="text-center">
                <a href="index.php?task=report">All Students</a>
                <a href="index.php?task=add">Add New Students</a>
                <a href="index.php?task=reset">Reset</a>
            </nav>
            <hr>
            <div class="reset">
                <?php echo $info; ?>
            </div>
            <?php if ('report' == $task) : ?>
                <div class="student_info">
                    <?php studentInfo() ?>
                </div>
            <?php endif; ?>
            <?php if ('1' == $error) : ?>
                <div class="student_info" style="max-width: 550px ; margin:auto">
                    <h5>Sorry roll <strong><?php echo $roll ?></strong> is already define</h5>
                    <p>Please try another roll and submit again</p>
                </div>
            <?php endif; ?>
            <?php if ('add' == $task) : ?>
                <div class="add_student">
                    <form style="max-width: 550px ; margin:auto" action="index.php?task=add" method="POST">
                        <div class="form-group">
                            <label class="my-2" for="fname">First Name:</label>
                            <input class="form-control" required type="text" name="fname" id="fname" value="<?php echo $fname ?>">
                        </div>
                        <div class="form-group">
                            <label class="my-2" for="lname">Last Name:</label>
                            <input class="form-control" required type="text" name="lname" id="lname" value="<?php echo $lname ?>">
                        </div>
                        <div class="form-group">
                            <label class="my-2" for="roll">Roll:</label>
                            <input class="form-control" required type="number" name="roll" id="roll" value="<?php echo $roll ?>">
                        </div>
                        <button class="mt-3 form-control" type="submit" name="submit">Submit</button>
                    </form>
                </div>
            <?php endif; ?>

            <?php if ('edit' == $task) :
                $id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_SPECIAL_CHARS);
                $student = getStudentID($id);

                if ($student) :
            ?>
                    <div class="edit_student">
                        <form style="max-width: 550px ; margin:auto" method="POST">
                            <input type="hidden" name="id" value="<?php echo $id; ?>">
                            <div class="form-group">
                                <label class="my-2" for="fname">First Name:</label>
                                <input class="form-control" type="text" name="fname" id="fname" value="<?php echo $student['fname'] ?>">
                            </div>
                            <div class="form-group">
                                <label class="my-2" for="lname">Last Name:</label>
                                <input class="form-control" type="text" name="lname" id="lname" value="<?php echo $student['lname'] ?>">
                            </div>
                            <div class="form-group">
                                <label class="my-2" for="roll">Roll:</label>
                                <input class="form-control" type="text" name="roll" id="roll" value="<?php echo $student['roll'] ?>">
                            </div>
                            <button class="mt-3 form-control" type="submit" name="submit">Submit</button>
                        </form>
                    </div>
            <?php endif;
            endif; ?>
        </div>
    </main>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <script src="assets/script.js"></script>
</body>
</html>