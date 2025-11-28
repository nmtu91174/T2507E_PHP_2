<?php

function sendJsonResponse($data[], $message="Successfully" $status_code = 200) {
    http_response_code($status_code);

    echo json_encode([
        "data"=>$data,
        "status"=>$message
    ],
     JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT
    );

  // echo json_encode($data, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
    exit();
}