<?php
/*
Plugin Name: Tucker Toys Kite-A-Pult Certificate
Plugin URI:
Description: Generate custom certificates for Kite-A-Pult Achievements
Version: 1.0
Author: Kevin J. McMahon Jr.
Author URI:
License:GPLv2
*/
?>
<?php

require(plugin_dir_path( __FILE__ ) . 'fpdf/fpdf.php');

// Add Shortcode
function generate_kiteapult_certificate() {

  // Get Data From POST
  $certificate_type = $_GET['kitepilotcertificate'];
  $presented_to_name = $_GET['kitepilotname'];
  $date_presented = $_GET['kitepilotdate'];
  
  // Create Image From Existing File
  if ($certificate_type === "Airman"){
	  $certificate = imagecreatefrompng(plugin_dir_path( __FILE__ ) . 'kite-a-pult-airman-certificate-web.png');
	  echo '<p class="certificate-status-message">Awesome flying! Here\'s your Airman Certificate of Achievement. Keep at it and come back when you\'ve earned your wings to become an Ace!</p>';
  }
  else if ($certificate_type === "Ace"){
	  $certificate = imagecreatefrompng(plugin_dir_path( __FILE__ ) . 'kite-a-pult-ace-certificate-web.png');
	  echo '<p class="certificate-status-message">Woah! You\'re a Kite-A-Pult master! You\'ve earned your Ace Certificate of Achievement. We\'re impressed and hope you continue having a blast with your Kite-A-Pult!</p>';
  }
  else{
	  echo '<p class="certificate-status-message">There may have been an error creating your certificate, please make sure you\'ve filled out your flight history on the Kite-A-Pult main page.</p>';
	  return;
  }

  // Allocate A Color For The Text
  $text_color = imagecolorallocate($certificate, 0, 0, 0);

  // Set Path to Font File
  $fontfile = plugin_dir_path( __FILE__ ) . 'fonts/arial.ttf';
  //Set Font Size
  $font_size = 32;
  
  // Calculate Bounding Box and Text Positions
  $name_bounding_box = imagettfbbox($font_size, 0, $fontfile, $presented_to_name);
  $name_x_position = (772 + ((1314 - 772) / 2));
  $name_x_position = $name_x_position - (($name_bounding_box[2] - $name_bounding_box[0]) /2);
  $name_y_position = 560;
  
  $date_bounding_box = imagettfbbox($font_size, 0, $fontfile, $date_presented);
  $date_x_position = (238 + ((666 - 238) / 2));
  $date_x_position = $date_x_position - (($date_bounding_box[2] - $date_bounding_box[0]) /2);
  $date_y_position = 990;

  
  // Print Text On Image
  imagettftext($certificate, $font_size, 0, $name_x_position, $name_y_position, $text_color, $fontfile, $presented_to_name);
  imagettftext($certificate, $font_size, 0, $date_x_position, $date_y_position, $text_color, $fontfile, $date_presented);

  // Send Image to Browser
  $id = $certificate_type . $presented_to_name . $date_presented;
  $pattern = '/[^a-zA-Z0-9]/';
  $id = preg_replace($pattern, '', (string) $id);
  $temp_image =  plugin_dir_path( __FILE__ ) . $id . ".png";
  imagepng($certificate, $temp_image);
  
  // Clear Memory
  imagedestroy($certificate);
  
  $certificate_output = base64_encode(file_get_contents($temp_image));
  
  // Create PDF
  $pdf = new FPDF('L', 'in', array(10,8));
  $pdf->AddPage();
  $pdf->SetMargins(0,0);
  $pdf->Image($temp_image, 0, 0, -150);
  $pdf->Output("F", plugin_dir_path( __FILE__ ) . $id . '.pdf');
  
  $certificate_pdf = base64_encode(file_get_contents(plugin_dir_path( __FILE__ ) . $id . '.pdf'));
  
  unlink($temp_image);
  unlink(plugin_dir_path( __FILE__ ) . $id . '.pdf');
  
  echo '<div class="certificate-wrapper"><img class="kite-a-pult-certificate" src="data:image/png;base64,' . $certificate_output . '" width="1501" height="1201" alt="Kite-A-Pult Certificate" style="width: 100%; height:auto;"><input type="button" value="Download As Image" class="download-certificate" /><input type="button" value="Download As PDF" class="download-pdf" data-pdf="data:application/pdf;base64,' . $certificate_pdf . '" /></div>';
  echo '<script src="' . plugins_url( 'download.js', __FILE__ ) . '"></script>';
  echo '<script src="' . plugins_url( 'send-certificate-to-printer.js', __FILE__ ) . '"></script>';
}
add_shortcode( 'kiteapult_certificate', 'generate_kiteapult_certificate' );

?>