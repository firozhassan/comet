<?php

/**
 * Data Management with function
 */

function create($insert)
{
    connect()->query($insert);
}



/**
 * Data Management with function
 */

function all($table, $order='DESC')
{
    return connect()->query("SELECT * FROM $table ORDER By id $order");
}



/**
 * Data Management with function
 */

function find($table, $id)
{
    $data = connect()->query("SELECT * FROM $table WHERE id='$id'");

    return $data->fetch_object();
}


/**
 * Data Management with function
 */

function delete($table, $id)
{
    connect()->query("DELETE FROM users WHERE id='$id'");
}


/**
 * Data Management with function
 */

function update($sql)
{
    connect()->query($sql);
}


function dataCheck($table, $col, $id)
{
    $email = connect()->query("SELECT $col FROM $table WHERE $col='$id' ");
    If($email->num_rows > 0 ){
        return true; 
    }else{
        return false;
    }
}



/**
 * Passing error message
 */

function validate($msg, $type='danger')

{

    return "<p class=\" alert alert-$type \"> $msg ! <button class=\"close\" data-dismiss=\"alert\">&times;</button>  </p>";

}


/**
 * File Uploading Function
 */

function move($file, $location = '/', array $type=['jpg', 'pdf', 'png', 'gif'])

{

$file_name = $file['name'];
$file_tmpname = $file['tmp_name'];
$file_arr = explode('.', $file_name);
$file_ext = end($file_arr);
$unique_name = md5(time() . rand(1, 999999)) . '.' . $file_ext;

$msg = '';

if(in_array($file_ext, $type) == false){
    $msg = validate('Invalid File Format');
}else{
    move_uploaded_file($file_tmpname, $location . $unique_name);
}
    

return [
    'unique_name'   => $unique_name,
    'err_msg'       => $msg
];

}


function old($name)

{
    if(isset($_POST[$name]))
    echo $_POST[$name];
}

function selected($location)

{
    if(isset($_POST[$location]))
    echo $_POST[$location];

    echo "Selected";
}





?>