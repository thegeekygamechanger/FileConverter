<?php

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $instructions = array(
        'parts' => array()
    );

    foreach ($_FILES['images']['tmp_name'] as $index => $tmpName) {
        if (is_uploaded_file($tmpName)) {
            $originalFileName = $_FILES['images']['name'][$index];
            $instructions['parts'][] = array(
                'file' => $originalFileName
            );
        }
    }

    $postData = array(
        'instructions' => json_encode($instructions)
    );

    foreach ($_FILES['images']['tmp_name'] as $index => $tmpName) {
        if (is_uploaded_file($tmpName)) {
            $originalFileName = $_FILES['images']['name'][$index];
            $postData[$originalFileName] = new CURLFile($tmpName);
        }
    }

    $curl = curl_init();
    curl_setopt_array($curl, array(
        CURLOPT_URL => 'https://api.pspdfkit.com/build',
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_POSTFIELDS => $postData,
        CURLOPT_HTTPHEADER => array(
            'Authorization: Bearer pdf_live_0Uq0TCRx6I6iv8skT3FvaRssyKJ3DDUJ5Lznl2I86IT'
        ),
    ));

    $response = curl_exec($curl);

    if ($response === false) {
        echo 'Error: ' . curl_error($curl);
    } else {
        $httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        if ($httpCode == 200) {
            // Set appropriate headers for download
            header('Content-Disposition: attachment; filename="converted.pdf"');
            header('Content-Type: application/pdf');
            echo $response;
        } else {
            echo 'API Error: ' . $response;
        }
    }

    curl_close($curl);
} else {
    header('Location: index.html');
    exit();
}
?>
