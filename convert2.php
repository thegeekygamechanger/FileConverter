<?php

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['pdfFile'])) {
    // Set your PSPDFKit API key here
    $apiKey = 'pdf_live_0Uq0TCRx6I6iv8skT3FvaRssyKJ3DDUJ5Lznl2I86IT';

    // Temporary directory for storing images
    $tempDir = 'images';
    if (!is_dir($tempDir)) {
        mkdir($tempDir);
    }

    // Prepare the PSPDFKit API request data
    $instructions = '{
        "parts": [
            {
                "file": "document"
            }
        ],
        "output": {
            "type": "image",
            "pages": {"start": 0, "end": -1},
            "format": "jpg",
            "width": 500
          }
    }';

    $postData = array(
        'instructions' => $instructions,
        'document' => new CURLFile($_FILES['pdfFile']['tmp_name'])
    );

    // Initialize cURL session
    $curl = curl_init();
    curl_setopt_array($curl, array(
        CURLOPT_URL => 'https://api.pspdfkit.com/build',
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_POSTFIELDS => $postData,
        CURLOPT_HTTPHEADER => array(
            'Authorization: Bearer ' . $apiKey
        ),
    ));

    // Execute the API request and get the response
    $response = curl_exec($curl);

    if ($response === false) {
        echo 'Error: ' . curl_error($curl);
    } else {
        // Save the ZIP file temporarily
        $zipPath = $tempDir . '/converted_images.zip';
        file_put_contents($zipPath, $response);

        // Close the cURL session
        curl_close($curl);

        // Set headers to force download
        header('Content-Type: application/zip');
        header('Content-Disposition: attachment; filename="converted_images.zip"');
        header('Content-Length: ' . filesize($zipPath));

        // Output the ZIP file content
        readfile($zipPath);

        // Clean up temporary files
        unlink($zipPath);
    }
}
?>
