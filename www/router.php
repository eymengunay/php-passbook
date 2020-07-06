<?php

if (preg_match('/\.(?:png|jpg|jpeg|gif)$/', $_SERVER["REQUEST_URI"])) {
    return false;
}

if (preg_match('/\.(?:pkpass)$/', $_SERVER["REQUEST_URI"])) {
    header('Content-Type: application/vnd.apple.pkpass');
    echo file_get_contents(trim($_SERVER["REQUEST_URI"], '/'));
    return;
}

$dir = './passes/';
$passes = [];
if ($handle = opendir($dir)) {
    while (false !== ($entry = readdir($handle))) {
        if ($entry != "." && $entry != ".." && strpos($entry, '.pkpass')) {
            $passes[] = $entry;
        }
    }
    closedir($handle);
}
?>

<html>
    <head>
        <title>PHP-Passbook test server</title>
        <meta name="viewport" content="width=device-width">
    </head>
    <body>
        <table border="1">
            <tr>
                <th>File</th>
                <th>Size</th>
                <th>Created</th>
            </tr>
            <?php
            foreach ($passes as $pass) {
                echo "<tr>";
                    echo '<td><a href="'.$dir.$pass.'">'.$pass.'</a></td>';
                    echo "<td>".round(filesize($dir.$pass) / 1024)."KB</td>";
                    echo "<td>".date('Y-m-d H:i:s', filectime($dir.$pass))."</td>";
                echo "</tr>";
            }
            ?>
        </table>
    </body>
</html>