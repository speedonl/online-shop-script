<?php
$QUERYSTING = $_SERVER['QUERY_STRING'];
$errors = '';
$myemail = 'ENTER_EMAIL';//<-----Put Your email address here.
$to = 'ENTER_EMAIL'; /* shop's email */
$email_address = $_POST['email']; 

$content = $_POST; /* receiving SimpleCart order array */
$body = ''; /* declaring the email body */
/*Formulier variabelen*/
$firstname = 'first_name'; /* extra field variable */
$lastname = 'last_name'; /* extra field variable */
$email_from = 'email'; /* extra field variable */
$phone = 'phone'; /* extra field variable */
$straat = 'straat'; /* extra field variable */
$zip = 'zip'; /* extra field variable */
$comments = 'comments'; /* extra field variable */



$body .= '=================================='."\n";
$body .= "Klant: ".$content[$firstname]."\n"; /* using extra field variable */
// $body .= "Last Name: ".$content[$lastname]."\n"; /* using extra field variable */
$body .= "Email adres: ".$content[$email_from]."\n"; /* using extra field variable */
$body .= "Straat: ".$content[$straat]."\n"; /* using extra field variable */
$body .= "Postcode & Woonplaats:".$content[$zip]."\n"; /* using extra field variable */
$body .= "Telefoon: ".$content[$phone]."\n"; /* using extra field variable */
$body .= 'Heeft de volgende bestelling geplaatst:'."\n";
$body .= "\n";
$body .= '=================================='."\n";

/* starting the loop to get all orders from the stored array */

for($i=1; $i < $content['itemCount'] + 1; $i++) {
$name = 'item_name_'.$i; /* product name variable */
$quantity = 'item_quantity_'.$i; /* product quantity variable */
$price = 'item_price_'.$i; /* product price variable */
$total = $content[$quantity]*$content[$price]; /* product total price variable (price*quantity) */
$grandTotal += $total; /* accumulating the total of all items */
$body .= 'Order #'.$i.': '.$content[$name]."\n".'Qty x '.$content[$quantity].' --- Unit Price €'.number_format($content[$price], 2, '.', '')."\n".'Subtotal €'.number_format($total, 2, '.', '')."\n"; /* creating a semantic format for each ordered product */
$body .= '=================================='."\n";
}

/* ending the loop to get all orders from the stored array */

$body .= 'Order Total: €'.number_format($grandTotal, 2, '.', '')."\n"; /* total amount of the order */
$body .= '=================================='."\n";
$body .= "\n";
$body .= "Comments: ".$content[$comments]."\n"; /* using extra field variable */
$headers = 'From: ' . $email_from . "\r\n" .
'Reply-To: ' . $email_from."\r\n" .
'X-Mailer: PHP/' . phpversion() .
'MIME-Version: 1.0\r\n'.
'Content-Type: text/html; charset=ISO-8859-1\r\n'; /* essential if you're using HTML tags on your mail */

/*Error controle*/
if(empty($_POST['email'])) 
{
    $errors .= "\n Fout: Geef een email adres in b.v. jan@jansen.com";
}
if(empty($_POST['straat'])) 
{
    $errors .= "\n Fout: Vul de gegevens straat en huisnummer in s.v.p";
}

$name = $_POST['firstname']; 
$email_address = $_POST['email']; 

if (!preg_match(
"/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$/i", 
$email_address))
{
    $errors .= "\n Error: Niet geldig email adres";
}
/*einde error controle*/
if( empty($errors)){
$subject = 'Ezelstal shop bestelling'; /* your desired subject to be displayed on the sent email */
$headers = "From: $myemail\n";
$headers .= "Reply-To: $email_address";
$headers .= "\r\n" . 'BCC:egbert@egbertkappert.com' . "\r\n"; /*20160225 bijgevoegd, niet getest!!*/
mail($to, $subject, $body, $headers); /* building the mail() function */
header('Location: order-form-thank-you.html'.$QUERYSTING);/* declaring the page to redirect if the mail is sent successfully */
}
if ($_POST['leaveblank'] != '' or $_POST['dontchange'] != 'http://') {
   // display message that the form submission was rejected
}
else {
   // accept form submission
}
?>
<!DOCTYPE HTML> 
<html lang="nl">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<meta name="viewport" content="width=device-width, maximum-scale=1.0, minimum-scale=1.0, initial-scale=1.0" />
		<link rel="stylesheet" href="../css/foundation.css" />
		<link rel="stylesheet" href="../css/app.css">
		<link rel="stylesheet" href="../css/lightbox.css">
		<link rel="stylesheet" href="../assets/foundation/foundation-icons/foundation-icons.css">
	<title>Contact form handler</title>
	<style>
		html, body { 
			max-width: 800px;
			margin: 0 auto;
			padding-left: 2rem;
			background-color: white; 
			color: #222; 
			font-weight: normal;
		}
	</style>
</head>

<body>
		
		<div class="row">
			<div class="large-centered large-6 columns whiteBackground">
				<!-- This page is displayed only if there is some error -->
				<?php
				echo nl2br($errors);
				?>
				
			</div>
			<div class="large-centered large-6 columns">
			<img class="animated bounce" src="../img/ezel.png" alt="">
			<a class="button success" href="http://www.ezelstal.net/shop/index.html">Terug naar de shop!</a>
		</div>	
		</div>
</body>
</html>