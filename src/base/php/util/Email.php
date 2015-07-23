<?php

namespace base;

/**
 * Class to send and test emails.
 * Dev note: we need double quotes in this class, else mail() doesn't work properly.
 *
 * @author Marvin Blum
 */
class Email{
	const DEFAULT_CHARSET = "ISO-8859-1";
	const FROM = "From";
	const CC = "Cc";
	const BCC = "Bcc";
	const REPLY = "Reply-To";
	const CONTENT_TYPE = "Content-type";
	const CONTENT_TYPE_HTML = "text/html";
	const CLRF = "\r\n";
	const MESSAGE_WORD_WRAP = 70;

	// basic data
	private $to = array();
	private $subject;
	private $message;

	// additional data
	private $from = array();
	private $cc = array();
	private $bcc = array();
	private $reply = array();
	private $contentType = ""; // default by mail
	private $wrapWord = false;

	/**
	 * Constructor.
	 *
	 * @param to receiver of email, optional
	 * @param toName receiver name, optional
	 * @param subject the subject of the email, optional
	 * @param message the message content of the email, optional
	 */
	function __construct($to = "", $toName = "", $subject = "", $message = ""){
		if(!empty($to)){
			addTo($to, $toName);
		}

		$this->subject = $subject;
		$this->message = $message;
	}

	private function addEmail(&$list, $email, $name){
		if($this->emailOrNameExists($list, $email, 0)){
			return false;
		}

		$list[] = array($email, $name);

		return true;
	}

	private function emailOrNameExists(&$list, $key, $index){
		$key = strtolower(trim($key));

		foreach($list AS $mail){
			if($key == strtolower($mail[$index])){
				return true;
			}
		}

		return false;
	}

	private function removeEmail(&$list, $email){
		$email = strtolower(trim($email));

		foreach($list AS $key => $mail){
			if($email == strtolower($mail[0])){
				unset($list[$key]);
				return true;
			}
		}

		return false;
	}

	private function getEmail(&$list, $index){
		if($index == -1){
			return $list;
		}

		return $list[$index];
	}

	/**
	 * Adds a receiver with email and optional name.
	 *
	 * @param email the receiver email
	 * @param name the receiver name, optional
	 * @return true if the receiver was added, false if receiver is in list already
	 */
	function addTo($email, $name = ""){
		return $this->addEmail($this->to, $email, $name);
	}

	/**
	 * Checks if an email exists in receiver list.
	 *
	 * @param email the email to check for
	 * @return true if email is contained in list, else false
	 */
	function toEmailExists($email){
		return $this->emailOrNameExists($this->to, $email, 0);
	}

	/**
	 * Checks if an receiver exists in receiver list by name.
	 *
	 * @param name the name to check for
	 * @return true if receiver is contained in list, else false
	 */
	function toNameExists($name){
		return $this->emailOrNameExists($this->to, $name, 1);
	}

	/**
	 * Removes a receiver from receiver list by email if found.
	 *
	 * @param email the receiver email
	 * @return true if the receiver was found and removed, else false
	 */
	function removeTo($email){
		return $this->removeEmail($this->to, $email);
	}

	/**
	 * Clears receiver list.
	 *
	 * @return void
	 */
	function clearTo(){
		$this->to = array();
	}

	/**
	 * Returns an receiver by index or all receiver.
	 *
	 * @param index if -1, all receiver are returned, else the receiver at index
	 * @return all receiver or receiver at index
	 */
	function getTo($index = -1){
		return $this->getEmail($this->to, $index);
	}

	/**
	 * Sets the emails subject.
	 *
	 * @param subject subject of the email as string
	 * @return void
	 */
	function setSubject($subject){
		$this->subject = $subject;
	}

	/**
	 * Returns the subject of the email.
	 *
	 * @return emails subject
	 */
	function getSubject(){
		return $this->subject;
	}

	/**
	 * Sets the emails message.
	 *
	 * @param message message of the email as string
	 * @return void
	 */
	function setMessage($message){
		$this->message = $message;
	}

	/**
	 * Returns the message of the email.
	 *
	 * @return emails message
	 */
	function getMessage(){
		return $this->message;
	}

	/**
	 * @see addTo()
	 */
	function addFrom($email, $name = ""){
		return $this->addEmail($this->from, $email, $name);
	}

	/**
	 * @see toEmailExists()
	 */
	function fromEmailExists($email){
		return $this->emailOrNameExists($this->from, $email, 0);
	}

	/**
	 * @see toNameExists()
	 */
	function fromNameExists($name){
		return $this->emailOrNameExists($this->from, $name, 1);
	}

	/**
	 * @see removeTo()
	 */
	function removeFrom($email){
		return $this->removeEmail($this->from, $email);
	}

	/**
	 * @see clearTo()
	 */
	function clearFrom(){
		$this->from = array();
	}

	/**
	 * @see getTo()
	 */
	function getFrom($index = -1){
		return $this->getEmail($this->from, $index);
	}

	/**
	 * @see addTo()
	 */
	function addCc($email, $name = ""){
		return $this->addEmail($this->cc, $email, $name);
	}

	/**
	 * @see toEmailExists()
	 */
	function ccEmailExists($email){
		return $this->emailOrNameExists($this->cc, $email, 0);
	}

	/**
	 * @see toNameExists()
	 */
	function ccNameExists($name){
		return $this->emailOrNameExists($this->cc, $name, 1);
	}

	/**
	 * @see removeTo()
	 */
	function removeCc($email){
		return $this->removeEmail($this->cc, $email);
	}

	/**
	 * @see clearTo()
	 */
	function clearCc(){
		$this->cc = array();
	}

	/**
	 * @see getTo()
	 */
	function getCc($index = -1){
		return $this->getEmail($this->cc, $index);
	}

	/**
	 * @see addTo()
	 */
	function addBcc($email, $name = ""){
		return $this->addEmail($this->bcc, $email, $name);
	}

	/**
	 * @see toEmailExists()
	 */
	function bccEmailExists($email){
		return $this->emailOrNameExists($this->bcc, $email, 0);
	}

	/**
	 * @see toNameExists()
	 */
	function bccNameExists($name){
		return $this->emailOrNameExists($this->bcc, $name, 1);
	}

	/**
	 * @see removeTo()
	 */
	function removeBcc($email){
		return $this->removeEmail($this->bcc, $email);
	}

	/**
	 * @see clearTo()
	 */
	function clearBcc(){
		$this->bcc = array();
	}

	/**
	 * @see getTo()
	 */
	function getBcc($index = -1){
		return $this->getEmail($this->bcc, $index);
	}

	/**
	 * @see addTo()
	 */
	function addReply($email, $name = ""){
		return $this->addEmail($this->reply, $email, $name);
	}

	/**
	 * @see toEmailExists()
	 */
	function replyEmailExists($email){
		return $this->emailOrNameExists($this->reply, $email, 0);
	}

	/**
	 * @see toNameExists()
	 */
	function replyNameExists($name){
		return $this->emailOrNameExists($this->reply, $name, 1);
	}

	/**
	 * @see removeTo()
	 */
	function removeReply($email){
		return $this->removeEmail($this->reply, $email);
	}

	/**
	 * @see clearTo()
	 */
	function clearReply(){
		$this->reply = array();
	}

	/**
	 * @see getTo()
	 */
	function getReply($index = -1){
		return $this->getEmail($this->reply, $index);
	}

	/**
	 * Sets the content type of header. If not modified, the default PHP mail() content type will be used.
	 * The content type is also modified by enableHTML().
	 *
	 * @param contentType the content type, do not pass charset
	 * @return void
	 */
	function setContentType($contentType){
		$this->contentType = $contentType;
	}

	/**
	 * Modifies the content type, so that emails message is interpreted as HTML.
	 *
	 * @param enable pass true, to enable HTML content type, false to disable; true is default
	 * @return void
	 */
	function enableHTML($enable = true){
		if($enable){
			$this->contentType = Email::CONTENT_TYPE_HTML;
			return;
		}

		$this->contentType = "";
	}

	/**
	 * Enables word wrapping after 70 characters.
	 *
	 * @param wrap pass true, to enable word wrapping, fals to disable; true is default
	 * @return void
	 */
	function enableWordWrapping($wrap = true){
		$this->wrapWord = $wrap;
	}

	/**
	 * Sends the email.
	 *
	 * @return void
	 */
	function send(){
		return mail($this->getEmails($this->to),
					$this->subject,
					$this->getEmailContent(),
					$this->getHeader());
	}

	/**
	 * Method to test mail output when send().
	 *
	 * @return an array containing the mail parameters: receiver, subject, message, header
	 */
	function test(){
		return array("receiver" => $this->getEmails($this->to),
					 "subject" => $this->subject,
					 "message" => $this->getEmailContent(),
					 "header" => $this->getHeader());
	}

	private function getHeader(){
		$header = "";

		$header = $this->appendHeaderEmails($header, Email::FROM, $this->from);
		$header = $this->appendHeaderEmails($header, Email::CC, $this->cc);
		$header = $this->appendHeaderEmails($header, Email::BCC, $this->bcc);
		$header = $this->appendHeaderEmails($header, Email::REPLY, $this->reply);

		if(!empty($this->contentType)){
			$header .= Email::CONTENT_TYPE.": ".$this->contentType."; charset=".Email::DEFAULT_CHARSET;
		}

		return $header;
	}

	private function appendHeaderEmails(&$header, $type, &$list){
		if(!count($list)){
			return;
		}

		$header .= $type.": ".$this->getEmails($list);
		$header .= Email::CLRF;

		return $header;
	}

	private function getEmails(&$list){
		$str = "";
		$first = true;

		foreach($list AS $mail){
			if(!$first){
				$str .= ",";
			}
			else{
				$first = false;
			}

			if(empty($mail[1])){
				$str .= $mail[0];
			}
			else{
				$str .= $mail[1]." <".$mail[0].">";
			}
		}

		return $str;
	}

	private function getEmailContent(){
		$content = $this->message;

		if($this->wrapWord){
			$content = wordwrap($content, MESSAGE_WORD_WRAP);
		}

		return $content;
	}
}
?>
