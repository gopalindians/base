<?php
$email = new base\Email();

$email->setSubject('This is the subject');
$email->setMessage('<html><head></head><body><h1>Content</h1>This is the content.</body></html>');
$email->enableHTML();

// test adding emails
$email->addTo('one@marvinblum.de');
$email->addTo('two@marvinblum.de');
$email->clearTo();
$email->addTo('admin@marvinblum.de', 'Marvin Blum');
$email->addTo('admin@marvinblum.de', 'Marvin Blum');
$email->addTo('fish@mau.de', 'Mr. Fish');
$email->addTo('different@marvinblum.de', 'Marvin jr Blum');
$email->removeTo(' fIsh@mAU.de 	');

base\dump($email->getTo(0));
base\dump($email->toEmailExists('   admin@marVinblum.de'));
base\dump($email->toNameExists('   Marvin BLUm 	'));

// test header emails
$email->addFrom('test@marvinblum.de');
$email->addCc('cc@marvinblum.de');
$email->addBcc('bcc@marvinblum.de');
$email->addReply('reply@marvinblum.de');

$data = $email->test();
base\dump($data['receiver']);
base\dump($data['subject']);
base\dump($data['message']);
base\dump($data['header']);
?>
