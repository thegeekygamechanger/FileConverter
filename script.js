function toggleFileInput() {
    const selectedOption = document.getElementById('conversionType').value;
    const fileInput = document.getElementById('fileInput');
    fileInput.style.display = selectedOption ? 'block' : 'none';
}

function convertPdfToJpg(file) {
    return fetch('https://v2.convertapi.com/convert/pdf/to/jpg?Secret=your api key&download=attachment', {
        method: 'POST',
        body: file,
    });
}

function convertPdfToPng(file) {
    return fetch('https://v2.convertapi.com/convert/pdf/to/png?Secret=your api key&download=attachment', {
        method: 'POST',
        body: file,
    });
}

function convertJpgToPng(file) {
    return fetch('https://v2.convertapi.com/convert/jpg/to/png?Secret=your api key&download=attachment', {
        method: 'POST',
        body: file,
    });
}

function convertPngToJpg(file) {
    return fetch('https://v2.convertapi.com/convert/png/to/jpg?Secret=your api key&download=attachment', {
        method: 'POST',
        body: file,
    });
}

function convertPngToPdf(file) {
    return fetch('https://v2.convertapi.com/convert/png/to/pdf?Secret=your api key&download=attachment', {
        method: 'POST',
        body: file,
    });
}

function convertJpgToPdf(file) {
    return fetch('https://v2.convertapi.com/convert/jpg/to/pdf?Secret=your api key&download=attachment', {
        method: 'POST',
        body: file,
    });
}

function convertWordToPdf(file) {
    return fetch('https://v2.convertapi.com/convert/docx/to/pdf?Secret=your api key&download=attachment', {
        method: 'POST',
        body: file,
    });
}
function convertPdfToWord(file) {
    return fetch('https://v2.convertapi.com/convert/pdf/to/docx?Secret=your api key&download=attachment', {
        method: 'POST',
        body: file,
    });
}
function convertFile() {
    const selectedOption = document.getElementById('conversionType').value;
    const selectedFile = document.getElementById('fileInput').files[0];

    if (!selectedOption || !selectedFile) {
        alert('Please select both a conversion type and a file.');
        return;
    }

    const formData = new FormData();
    formData.append('File', selectedFile);

    let conversionPromise;

    switch (selectedOption) {
        case 'pdf_to_jpg':
            conversionPromise = convertPdfToJpg(formData);
            break;
        case 'pdf_to_png':
            conversionPromise = convertPdfToPng(formData);
            break;
        case 'jpg_to_png':
            conversionPromise = convertJpgToPng(formData);
            break;
        case 'png_to_jpg':
            conversionPromise = convertPngToJpg(formData);
            break;
        case 'png_to_pdf':
            conversionPromise = convertPngToPdf(formData);
            break;
        case 'jpg_to_pdf':
            conversionPromise = convertJpgToPdf(formData);
            break;
        case 'word_to_pdf':
            conversionPromise = convertWordToPdf(formData);
            break;
        case 'pdf_to_word':
            conversionPromise = convertPdfToWord(formData);
            break;
        default:
            alert('Invalid option selected.');
            return;
    }

    conversionPromise
        .then((response) => response.blob())
        .then((blob) => {
            const downloadUrl = window.URL.createObjectURL(blob);
            const a = document.createElement('a');
            a.href = downloadUrl;
            a.download = `converted_file.${selectedOption.split('_')[2]}`;
            a.click();
        })
        .catch((error) => {
            console.error('Conversion error:', error);
        });
        
}
