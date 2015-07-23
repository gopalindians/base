# Utilities

Base provides some utility classes, which are described here.

## Email

*Email* builds and sends e-mails. It allows most of the options you need, like adding multiple receiver, Cc, Bcc and so on. Currently file attachments are not supported.

Example usage:

```PHP
$email = new base\Email(); // optional you can pass data for very basic usage

$email->setSubject('This is the subject!');
$email->setMessage('<html><head></head><body><h1>Content</h1>This is the content.</body></html>'); // HTML is supported...
$email->enableHTML(); // ... if you enable it

// test adding emails
$email->addTo('one@marvinblum.de'); // add receiver
$email->addTo('two@marvinblum.de');
$email->clearTo(); // clear all receiver
$email->addTo('admin@marvinblum.de', 'Marvin Blum');
$email->addTo('admin@marvinblum.de', 'Marvin Blum'); // skips e-mails, if already added
$email->addTo('fish@mau.de', 'Mr. Fish');
$email->addTo('different@marvinblum.de', 'Marvin jr Blum');
$email->removeTo(' fIsh@mAU.de  '); // removes fish@mau.de

base\dump($email->getTo(0)); // returns first added receiver (note that different@marvinblum.de whould be index 2!)
base\dump($email->toEmailExists('   admin@marVinblum.de')); // check for existance by e-mail
base\dump($email->toNameExists('   Marvin BLUm  ')); // check for existance by receiver name

// add header data, work like addTo(), removeTo(), ...
$email->addFrom('test@marvinblum.de');
$email->addCc('cc@marvinblum.de');
$email->addBcc('bcc@marvinblum.de');
$email->addReply('reply@marvinblum.de');

// this is how you can test the output ("mock")
$data = $email->test();
base\dump($data['receiver']);
base\dump($data['subject']);
base\dump($data['message']);
base\dump($data['header']);

// or send it finally
$email->send();
```

## FormValidator

The *FormValidator* validates user input providing different check methods. The data (e.g. from a HTML form) is added as an array to the constructor. Then you can perform different checks and get fields that failed your checks (at once).

Example usage:

```PHP
$fv = new base\FormValidator($formData); // add data from somewhere

$fv->notEmpty(); // checks all field for emptiness
$fv->notEmpty('field'); // checks a single field for emptiness
$fv->equal('fieldA', 'fieldB'); // compares two field to be equal, pass keys
$fv->isEmail('field'); // checks if the field is an valid e-mail

$fv->which(); // returns keys of fields that failed checks
```

## dump

*dump()* is function to pritty print data to the page. Internally it calls *var_dump()* PHP function. If the passed data is a string, HTML will be stripped.

Example usage:

```PHP
base\dump(array('some', 'data'));
base\dump('<b>HTML code</b>'); // will print: <b>HTML code</b>
```
