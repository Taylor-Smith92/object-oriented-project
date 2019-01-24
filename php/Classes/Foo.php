<?php
//namespace tsmith179\object-oriented-project;

//require_once("autoload.php");
//require_once(dirname(__DIR__, 2) . "/vendor/autoload.php");

/**
 * Basic type of profile for a social networking site.
 *
 * This is an example of how data about a user is collected and stored.
 *
 * @author Taylor Smith <taylorleesmith92@gmail.com>
 **/
class author{
	/**
	 * id for this author; this is the primary key
	 **/
	private $authorId;
	/**
	 * url for this author's avatar photo
	 **/
	private $authorAvatarUrl;
	/**
	 * this author's email address
	 **/
	private $authorEmail;
	/**
	 * this author's username
	 */
	private $authorUsername;



	/**
	 * this author's activation token
	 **/
	private $authorActivationToken;
	/**
	 * this author's password
	 */
	private $authorHash;


	/**
	 * accessor method for author Id
	 *
	 * @return int value of author Id
	 **/
	public function getAuthorId() {
		return $this->authorId;
	}
	/**
	 * mutator method for author Id
	 *
	 * @param int $newAuthorId new value of author Id
	 * @throws UnexpectedValueException if $newAuthorId is not an integer
	 **/
	public function setAuthorId($newAuthorId) {
		// verify that the author Id is valid
		$newAuthorId = filter_var($newAuthorId, Filter_Validate_Int);
		if ($newAuthorId === false) {
			throw(new UnexpectedValueException("Author Id is Not a Valid Integer"));
		}
		//convert and store new author id
		$this->authorId = intval($newAuthorId);
	}

	/**
	 * accessor method for the author's avatar photo url
	 *
	 * @return string of the avatar photo url
	 **/
	public function getauthorAvatarUrl() {
		return $this->authorAvatarUrl;
	}
	/**
	 * mutator method for author avatar photo url
	 *
	 * @param mixed $newAuthorAvatarUrl new url for avatar photo
	 * @throws InvalidArgumentException if $newAuthorAvatarUrl is not valid
	 **/
	public function setAuthorAvatarUrl($newAuthorAvatarUrl) {
		//verify thart the url is valid
		$newAuthorAvatarUrl = filter_var($newAuthorAvatarUrl, FILTER_VALIDATE_URL);
		if ($newAuthorAvatarUrl === false) {
			throw(new InvalidArgumentException("Url is not valid"));
		}
		//store new url
		$this->authorAvatarUrl = $newAuthorAvatarUrl;
	}

	/**
	 * accessor method for author's email
	 *
	 * @return mixed author's unique email address
	 **/
	public function getAuthorEmail() {
		return $this->authorEmail;
	}
	/**
	 * mutator method for author's email
	 *
	 * @param string $newAuthorEmail new email for this account
	 * @throw InvalidArgumentException if $newAuthorEmail is not a valid email
	 **/
	public function setAuthorEmail($newAuthorEmail) {
		//verify that the email is valid
		$newAuthorEmail = filter_var($newAuthorEmail, FILTER_VALIDATE_EMAIL);
		if ($newAuthorEmail === false) {
			throw(new InvalidArgumentException("This email address is not valid"));
		}
		//store new email address
		$this->authorEmail = $newAuthorEmail;
	}

	/**
	 * accessor method for author's username
	 *
	 * @return string author's current username
	 */
	public function getAuthorUsername() {
		return $this->authorUsername;
	}
	/**
	 * mutator method for author's username
	 *
	 * @param $newAuthorUsername string value of author's username
	 * @throw UnexpectedValueException if username is not valid
	 **/
	public function setAuthorUsername($newAuthorUsername) {
		//verify that the username is valid
		$newAuthorUsername = filter_var($newAuthorUsername, FILTER_SANITIZE_STRING);
		if ($newAuthorUsername === false) {
			throw(new UnexpectedValueException("Username is nat a valid string"));
		}
		//store username
		$this->authorUsername = $newAuthorUsername;
	}

}
