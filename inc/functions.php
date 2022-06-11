<?php
define('DB_NAME', 'c:/xampp/htdocs/crud/data/db.txt');
function resetData()
{
    $data = array(
        array(
            'id' => 1,
            'fname' => 'Monirul',
            'lname' => 'Islam',
            'roll' => 1,
        )
    );
    $serializeData = serialize($data);
    file_put_contents(DB_NAME, $serializeData);
}


function studentInfo()
{
    $serializeData = file_get_contents(DB_NAME);
    $students = unserialize($serializeData);
?>
    <table class="table table-bordered">
        <tr>
            <th>Full Name: </th>
            <th>Roll: </th>
            <th>Action: </th>
        </tr>
        <?php
        foreach ($students as $student) {
        ?>
            <tr>
                <td><?php printf('%s %s', $student['fname'], $student['lname']) ?></td>
                <td><?php printf('%s', $student['roll']) ?></td>
                <td><?php printf('<a href="index.php?task=edit&id=%s">Edit</a> | <a class="delete" href="index.php?task=delete&id=%s">Delete</a>', $student['id'], $student['id']) ?></td>
            </tr>
        <?php
        }
        ?>
    </table>

<?php
}

function rawId($students){
    $maxId = max(array_column($students, 'id'));
    return $maxId+1;
}

function addStudent($fname, $lname, $roll)
{
    $found = false;
    $serializeData = file_get_contents(DB_NAME);
    $students = unserialize($serializeData);
    foreach ($students as $student) {
        if ($student['roll'] == $roll) {
            $found = true;
            break;
        }
    }
    if (!$found) {
        $newID = rawId($students);
        $student = array(
            'id' => $newID,
            'fname' => $fname,
            'lname' => $lname,
            'roll' => $roll,
        );
        array_push($students, $student);
        $serializeData = serialize($students);
        file_put_contents(DB_NAME, $serializeData);
        return true;
    }
    return false;
}


function getStudentID($id)
{
    $serializeData = file_get_contents(DB_NAME);
    $students = unserialize($serializeData);
    foreach ($students as $student) {
        if ($student['id'] == $id) {
            return $student;
        }
    };
    return false;
}

function updateStudentInfo($id, $fname, $lname, $roll)
{
    $found = false;
    $serializeData = file_get_contents(DB_NAME);
    $students = unserialize($serializeData);
    foreach ($students as $student) {
        if ($student['roll'] == $roll && $student['id'] != $id) {
            $found = true;
            break;
        }
    }
    if (!$found) {
        $students[$id - 1]['fname'] = $fname;
        $students[$id - 1]['lname'] = $lname;
        $students[$id - 1]['roll'] = $roll;
        $serializeData = serialize($students);
        file_put_contents(DB_NAME, $serializeData);
        return true;
    }
    return false;
}



function deleteID($id)
{
    $serializeData = file_get_contents(DB_NAME);
    $students = unserialize($serializeData);
    foreach ($students as $offset => $student) {
        if ($student['id'] == $id) {
            unset($students[$offset]);
        }
    };
    $serializeData = serialize($students);
    file_put_contents(DB_NAME, $serializeData);
}

