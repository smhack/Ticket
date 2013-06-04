SMHack Ticket System
======

This is a PHP based ticketing system that allows us to add, edit, and activate events that in turn are offered to our community.  Participants can pay for a ticket using PayPal.  Tickets are given to participants in the form of a QR code. At the time of the event tickets are scanned and validated with a green screen or a red screen.  QR codes are marked as used when scanned making them a one time use code.

Upon activation of a submitted event a mechanism will send out valid tickets to dues paying members of the space.

== Credit ==

We have implemented the PHP QR Code library which is located here: http://phpqrcode.sourceforge.net/.  Using this library allows us to generate our QR codes that we send out.
