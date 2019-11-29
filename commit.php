<?php
$db = mysqli_connect('localhost', 'root') or 
    die ('Unable to connect. Check your connection parameters.');
mysqli_select_db($db, 'animesite') or die(mysqli_error($db));
?>
<html>
 <head>
  <title>Commit</title>
 </head>
 <body>
<?php
switch ($_GET['action']) {
case 'add':
    switch ($_GET['type']) {
    case 'anime':
        $error = array();
        $anime_name = isset($_POST['anime_name']) ? trim($_POST['anime_name']) : '';
        if (empty($anime_name)) {
            $error[] = urlencode('Please enter a anime name.');
        }
        $anime_type = isset($_POST['anime_type']) ? trim($_POST['anime_type']) : '';
        if (empty($anime_type)) {
            $error[] = urlencode('Please select a anime type.');
        }
        $anime_year = isset($_POST['anime_year']) ? trim($_POST['anime_year']) : '';
        if (empty($anime_year)) {
            $error[] = urlencode('Please select a anime year.');
        }
        $anime_leadactor = isset($_POST['anime_leadactor']) ?
        trim($_POST['anime_leadactor']) : '';
        if (empty($anime_leadactor)) {
            $error[] = urlencode('Please select a lead actor.');
        }
        $anime_director = isset($_POST['anime_director']) ?
        trim($_POST['anime_director']) : '';
        if (empty($anime_director)) {
            $error[] = urlencode('Please select a director.');
        }
        if (empty($error)) {
        $query = 'INSERT INTO
            anime
                (anime_name, anime_year, anime_type, anime_leadactor,
                anime_director)
            VALUES
                ("' . $_POST['anime_name'] . '",
                 ' . $_POST['anime_year'] . ',
                 ' . $_POST['anime_type'] . ',
                 ' . $_POST['anime_leadactor'] . ',
                 ' . $_POST['anime_director'] . ')';
        } else {
            header('Location:anime.php?action=add' . '&error=' . join($error    , urlencode('<br/>')));
        }
        break;

    
    case 'caracter':
        $query = 'INSERT INTO 
            caracter
                (caracter_fullname, caracter_isactor, caracter_isdirector)
            VALUES
                ("' . $_POST['caracter_fullname'] . '",
                 ' . $_POST['caracter_isactor'] . ',
                 ' . $_POST['caracter_isdirector'] . ')';
        break;
    }
    break;

case 'edit':
    switch ($_GET['type']) {
    case 'anime':
        $error = array();
        $anime_name = isset($_POST['anime_name']) ?
            trim($_POST['anime_name']) : '';
        if (empty($anime_name)) {
            $error[] = urlencode('Please enter a anime name.');
        }
        $anime_type = isset($_POST['anime_type']) ?
            trim($_POST['anime_type']) : '';
        if (empty($anime_type)) {
            $error[] = urlencode('Please select a anime type.');
        }
        $anime_year = isset($_POST['anime_year']) ?
            trim($_POST['anime_year']) : '';
        if (empty($anime_year)) {
            $error[] = urlencode('Please select a anime year.');
        }
        $anime_leadactor = isset($_POST['anime_leadactor']) ?
            trim($_POST['anime_leadactor']) : '';
        if (empty($anime_leadactor)) {
            $error[] = urlencode('Please select a lead actor.');
        }
        $anime_director = isset($_POST['anime_director']) ?
            trim($_POST['anime_director']) : '';
        if (empty($anime_director)) {
            $error[] = urlencode('Please select a director.');
        }
        if (empty($error)) {
        $query = 'UPDATE anime SET
                anime_name = "' . $_POST['anime_name'] . '",
                anime_year = ' . $_POST['anime_year'] . ',
                anime_type = ' . $_POST['anime_type'] . ',
                anime_leadactor = ' . $_POST['anime_leadactor'] . ',
                anime_director = ' . $_POST['anime_director'] . '
            WHERE
                anime_id = ' . $_POST['anime_id'];
        break;
        } else {
            header('Location:anime.php?action=edit&id=' . $_POST['anime_id'] .
              '&error=' . join($error, urlencode('<br/>')));
        }
        break;
    
    case 'caracter':
        $query = 'UPDATE caracter SET
                caracter_fullname = "' . $_POST['caracter_fullname'] . '",
                caracter_isactor = ' . $_POST['caracter_isactor'] . ',
                caracter_isdirector = ' . $_POST['caracter_isdirector'] . '
            WHERE
                caracter_id = ' . $_POST['caracter_id'];
        break;
    }
}
if (isset($query)) {
    $result = mysqli_query($db, $query) or die(mysqli_error($db));
}
?>
     <p>Done!, Volver para ver los resultados -> <a href="admin.php">Home</a></p>
 </body>
</html>
