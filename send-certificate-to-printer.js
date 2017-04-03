document.addEventListener('DOMContentLoaded', findCertificate, false);

function findCertificate(){
    var certificates = document.getElementsByClassName('certificate-wrapper');
    for (i = 0; i < certificates.length; i++){
		var tempPNG = certificates[i].getElementsByClassName('download-certificate')[0];
        tempPNG.addEventListener("click", downloadCertificatePNG);
		var tempPDF = certificates[i].getElementsByClassName('download-pdf')[0];
        tempPDF.addEventListener("click", downloadCertificatePDF);
    }
}

function downloadCertificatePNG(){
	var imageData = this.parentNode;
	imageData = imageData.getElementsByClassName('kite-a-pult-certificate')[0];
	imageData = imageData.getAttribute('src');
	download(imageData, "certificate.png", "image/png");
}

function downloadCertificatePDF(){
	var imageData = this.parentNode;
	imageData = imageData.getElementsByClassName('download-pdf')[0];
	imageData = imageData.getAttribute('data-pdf');
	download(imageData, "certificate.pdf", "application/pdf");
}