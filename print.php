<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Generate PDF Example</title>
</head>
<body>

<button id="generatePdfBtn">Generate PDF</button>
<div id="pdfContainer"></div>

<script>
    document.getElementById('generatePdfBtn').addEventListener('click', function() {
        // Make an AJAX request to generate the PDF
        var xhr = new XMLHttpRequest();
        xhr.open('GET', 'generate_pdf.php', true);
        xhr.responseType = 'arraybuffer'; // Use 'arraybuffer' to handle binary data

        xhr.onload = function() {
            if (xhr.status === 200) {
                // Create a blob from the PDF content
                var blob = new Blob([xhr.response], { type: 'application/pdf' });

                // Display the PDF using an object URL
                var objectUrl = URL.createObjectURL(blob);
                var pdfContainer = document.getElementById('pdfContainer');
                pdfContainer.innerHTML = '<iframe width="100%" height="600px" src="' + objectUrl + '"></iframe>';
            }
        };

        xhr.send();
    });
</script>

</body>
</html>
