<?php
    $db = mysqli_connect('localhost', 'root') or 
    die ('Unable to connect. Check your connection parameters.');
    mysqli_select_db($db, 'animesite') or die(mysqli_error($db));
    if (isset($_GET['error']) && $_GET['error'] != '') {
        echo '<div id="error">' . $_GET['error'] . '</div>';
    }
    if ($_GET['action'] == 'edit') {
        $query = 'SELECT * FROM anime WHERE anime_id = ' . $_GET['id'];
        $result = mysqli_query($db, $query) or die(mysqli_error($db));
        extract(mysqli_fetch_assoc($result));
    } else {
        $anime_name = '';
        $anime_type = 0;
        $anime_year = date('Y');
        $anime_leadactor = 0;
        $anime_director = 0;
    }
?>
<html>
    <head>
        <title><?php echo ucfirst($_GET['action']);?> Anime</title>
        <style>
            td{
                padding:5px;
            }
            #error { background-color: #600; border: 1px solid #FF0; color: #FFF;
            text-align: center; margin: 10px; padding: 10px; }
        </style>
    </head>
    <body>
        <form action="commit.php?action=<?php echo $_GET['action'];?>&type=anime" method="post">
            <table align="center" border="1">
                <tr>
                    <td>Anime Name</td>
                    <td><input type="text" name="anime_name" value="<?php echo $anime_name;?>"/></td>
                </tr>
                <tr>
                    <td>Anime Type</td>
                    <td>
                        <select name="anime_type">
                            <?php
                                $query = 'SELECT 
                                            animetype_id, animetype_label
                                        FROM
                                            animetype
                                        ORDER BY
                                            animetype_label';
                                $result = mysqli_query($db, $query) or die(mysqli_error($db));
                                while ($row = mysqli_fetch_assoc($result)) {
                                    extract($row);
                                        if ($row['animetype_id'] == $anime_type) {
                                            echo '<option value="' . $row['animetype_id'] .
                                                '" selected="selected">';
                                        } else {
                                            echo '<option value="' . $row['animetype_id'] . '">';
                                        }
                                        echo $row['animetype_label'] . '</option>';
                                    }
                            ?>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td>Anime Year</td>
                    <td>
                        <select name="anime_year">
                            <?php
                                for ($anio = date("Y"); $anio >= 1970; $anio--) {
                                    if ($anio == $anime_year) {
                                        echo '<option value="' . $anio . '" selected="selected">' . $anio .
                                            '</option>';
                                    } else {
                                        echo '<option value="' . $anio . '">' . $anio . '</option>';
                                    }
                                }
                            ?>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td>Lead Actor</td>
                    <td>
                        <select name="anime_leadactor">
                            <?php
                                $query = 'SELECT 
                                            caracter_id, caracter_fullname
                                          FROM
                                            caracter
                                          WHERE
                                            caracter_isactor = 1
                                          ORDER BY
                                            caracter_fullname';
                                $result = mysqli_query($db, $query) or die(mysqli_error($db));
                                while ($row = mysqli_fetch_assoc($result)) {
                                    extract($row);
                                        if ($row['caracter_id'] == $anime_leadactor) {
                                            echo '<option value="' . $row['caracter_id'] .
                                                '" selected="selected">';
                                        } else {
                                            echo '<option value="' . $row['caracter_id'] . '">';
                                        }
                                        echo $row['caracter_fullname'] . '</option>';
                                    }
                            ?>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td>Director</td>
                    <td>
                        <select name="anime_director">
                            <?php
                            // select director records
                            $query = 'SELECT
                                    caracter_id, caracter_fullname
                                FROM
                                    caracter
                                WHERE
                                    caracter_isdirector = 1
                                ORDER BY
                                    caracter_fullname';
                            $result = mysqli_query($db, $query) or die(mysqli_error($db));
                            // populate the select options with the results
                            while ($row = mysqli_fetch_assoc($result)) {
                                extract($row);
                                    if ($row['caracter_id'] == $anime_director) {
                                        echo '<option value="' . $row['caracter_id'] .
                                            '" selected="selected">';
                                    } else {
                                        echo '<option value="' . $row['caracter_id'] . '">';
                                    }
                                    echo $row['caracter_fullname'] . '</option>';
                                }
                            ?>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td colspan="2" style="text-align: center;">
                        <?php
                        if ($_GET['action'] == 'edit') {
                            echo '<input type="hidden" value="' . $_GET['id'] . '" name="anime_id" />';
                        }
                        ?>
                        <input type="submit" name="submit"
                        value="<?php echo ucfirst($_GET['action']); ?>" />
                    </td>         
                </tr>
            </table>
        </form>
    </body>
</html>
