SMHack Ticket System
======

This is a PHP based ticketing system that allows us to add, edit, and activate events that in turn are offered to our community.  Participants can pay for a ticket using PayPal.  Tickets are given to participants in the form of a QR code. At the time of the event tickets are scanned and validated with a green screen or a red screen.  QR codes are marked as used when scanned making them a one time use code.

Upon activation of a submitted event a mechanism will send out valid tickets to dues paying members of the space.

== Credit ==

We have implemented the PHP QR Code library which is located here: http://phpqrcode.sourceforge.net/.  Using this library allows us to generate our QR codes that we send out.

We have also implemented the Portable PHP password hashing framework for the backend. http://www.openwall.com/phpass/

== What's Needed ==

You will need to include the /ticket/sendticket.php file in your IPN (PayPal) file.  Here is an example of how our ipn is handled.

switch($txn_type){
case 'web_accept':
if ($item_number == 'Class'){
include('./ticket/sendticket.php'); 
}
break;
}

I suggest looking into the class here https://github.com/Quixotix/PHP-PayPal-IP to make your IPN intergration easier.
