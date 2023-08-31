<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $instructions = '{
        "parts": [
            {
                "file": "document"
            }
        ],
        "actions": [
            {
                "type": "watermark",
                "image": "logo",
                "width": "50%",
                "opacity": 0.3
            }
        ]
    }';

    $apiToken = 'YOUR_PSPDFKIT_API_TOKEN';

    $documentFile = $_FILES['document'];
    $logoFile = $_FILES['logo'];

    $curl = curl_init();

    $postFields = array(
        'instructions' => $instructions,
        'document' => new CURLFILE($documentFile['tmp_name']),
        'logo' => new CURLFILE($logoFile['tmp_name'])
    );

    curl_setopt_array($curl, array(
        CURLOPT_URL => 'https://api.pspdfkit.com/build',
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_POSTFIELDS => $postFields,
        CURLOPT_HTTPHEADER => array(
            'Authorization: Bearer pdf_live_0Uq0TCRx6I6iv8skT3FvaRssyKJ3DDUJ5Lznl2I86IT'
        ),
    ));

    $response = curl_exec($curl);

    if ($response !== false) {
        header('Content-Disposition: attachment; filename="result.pdf"');
        header('Content-Type: application/pdf');
        echo $response;
    } else {
        echo 'Error generating watermarked PDF.';
    }

    curl_close($curl);
}
?>
