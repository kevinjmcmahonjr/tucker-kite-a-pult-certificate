document.addEventListener('DOMContentLoaded', findCertificate, false);

function getMobileBrowser() {
  var userAgent = navigator.userAgent || navigator.vendor || window.opera;
    if (/windows phone/i.test(userAgent)) {
        return "mobile";
    }
    if (/android/i.test(userAgent)) {
        return "mobile";
    }
    if (/iPad|iPhone|iPod/.test(userAgent) && !window.MSStream) {
        return "mobile";
    }
    return "unknown";
}

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
	if (getMobileBrowser() === "mobile"){
		window.open(imageData);
	}
	else{
		download(imageData, "certificate.png", "image/png");
	}
}

function downloadCertificatePDF(){
	var imageData = this.parentNode;
	imageData = imageData.getElementsByClassName('download-pdf')[0];
	imageData = imageData.getAttribute('data-pdf');
	if (getMobileBrowser() === "mobile"){
		window.open(imageData);
	}
	else{
		download(imageData, "certificate.pdf", "application/pdf");
	}
}