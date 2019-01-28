<?php
namespace TaylorSmith\objectOrientedProject;

require_once("autoload.php");
require_once(dirname(__DIR__, 2) . "/vendor/autoload.php");

use Ramsey\Uuid\Uuid;

/**
 * Basic type of profile for a social networking site.
 *
 * This is an example of how data about a user is collected and stored.
 *
 * @author Taylor Smith <taylorleesmith92@gmail.com>
 **/
class author implements \JsonSerializable {
	use ValidateUuid;
	/**
	 * id for this author; this is the primary key
	 * @var Uuid $authorId
	 **/
	private $authorId;
	/**
	 * url for this author's avatar photo
	 * @var $authorAvatarUrl
	 **/
	private $authorAvatarUrl;
	/**
	 * token used to verify that the author is valid
	 * @var $authorActivationToken
	 */
	private $authorActivationToken;
	/**
	 * this author's email address
	 * @var $authorEmail
	 **/
	private $authorEmail;
	/**
	 * hash for author password
	 * @var $authorHash
	 */
	private $authorHash;
	/**
	 * this author's username
	 * @var $authorUsername
	 **/
	private $authorUsername;

	/**
	 * constructor for author
	 *
	 * @param Uuid $newAuthorId id of this author
	 * @param string $newAuthorActivationToken
	 * @param string $newAuthorAvatarUrl the url for the author's chosen avatar photo
	 * @param string $newAuthorEmail this author's email address
	 * @param $newAuthorHash author's password hash
	 * @param string $newAuthorUsername this author's username
	 * @throws \InvalidArgumentException if data is not valid
	 * @throws \RangeException if data is out of bounds
	 * @throws \TypeError if data type violates a hint
	 * @throws \Exception if non defined exception occurs
	 **/
	public function __construct($newAuthorId, ?string $newAuthorActivationToken, string $newAuthorAvatarUrl,
										 string $newAuthorEmail, $newAuthorHash, string $newAuthorUsername) {
		try {
			$this->setAuthorId($newAuthorId);
			$this->setAuthorActivationToken($newAuthorActivationToken);
			$this->setAuthorAvatarUrl($newAuthorAvatarUrl);
			$this->setAuthorEmail($newAuthorEmail);
			$this->setAuthorHash($newAuthorHash);
			$this->setAuthorUsername($newAuthorUsername);
		} catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
			$exceptionType = get_class($exception);
			throw(new $exceptionType($exception->getMessage(), 0, $exception));
		}
	}
	/**
	 * accessor method for author Id
	 *
	 * @return Uuid value of author Id (or null if new Author)
	 **/
	public function getAuthorId(): Uuid {
		return $this->authorId;
	}
	/**
	 * mutator method for author Id
	 *
	 * @param Uuid | string $newAuthorId new value of author Id
	 * @throws \RangeException if $newAuthorId is not positive
	 * @throws \TypeError if the author id is not a Uuid or string
	 **/
	public function setAuthorId($newAuthorId): void {
		// verify that the author Id is valid
		try {
			$uuid = self::validateUuid($newAuthorId);
		} catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
			$exceptionType = get_class($exception);
			throw(new $exceptionType($exception->getMessage(), 0, $exception));
		}
		//convert and store new author id
		$this->authorId = $uuid;
	}
	/**
	 * accessor method for author activation token
	 *
	 * @return string value of activation token
	 */
	public function getAuthorActivationToken() : ?string {
		return $this->authorActivationToken;
	}
	/**
	 * mutator method for author activation token
	 *
	 * @param string $newAuthorActivationToken
	 * @throws \InvalidArgumentException  if the token is not a string or insecure
	 * @throws \RangeException if the token is not exactly 32 characters
	 * @throws \TypeError if the activation token is not a string
	 */
	public function setAuthorActivationToken(?string $newAuthorActivationToken) : void {
		if ($newAuthorActivationToken === null) {
			$this->authorActivationToken = null;
			return;
		}
		$newAuthorActivationToken = strtolower(trim($newAuthorActivationToken));
		if (ctype_xdigit($newAuthorActivationToken) === false) {
			throw(new\RangeException("user activation is not valid"));
		}
		//make sure that activation token is 32 characters
		if(strlen($newAuthorActivationToken) !== 32) {
			throw(new\RangeException("user activation token has to be 32 characters long"));
		}
		//save the activation token
		$this->authorActivationToken = $newAuthorActivationToken;
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
	 * @param string $newAuthorAvatarUrl new url for avatar photo
	 * @throws \InvalidArgumentException if $newAuthorAvatarUrl is empty or insecure
	 * @throws \RangeException if $newAuthorAvatar url > 128 characters
	 **/
	public function setAuthorAvatarUrl($newAuthorAvatarUrl) {
		//verify that the url is valid
		$newAuthorAvatarUrl = trim($newAuthorAvatarUrl);
		$newAuthorAvatarUrl = filter_var($newAuthorAvatarUrl, FILTER_VALIDATE_URL);
		if(empty($newAuthorAvatarUrl) === true) {
			throw(new\InvalidArgumentException("Url is empty or insecure"));
		}
		//verify that url length is within the limit
		if(strlen($newAuthorAvatarUrl) > 128) {
			throw(new\RangeException("Avatar Url is too long"));
		}
		//store new url
		$this->authorAvatarUrl = $newAuthorAvatarUrl;
	}
	/**
	 * accessor method for author's email
	 *
	 * @return string value of author's email address
	 **/
	public function getAuthorEmail() {
		return $this->authorEmail;
	}
	/**
	 * mutator method for author's email
	 *
	 * @param string $newAuthorEmail new value of email for this account
	 * @throws \InvalidArgumentException if $newAuthorEmail is not valid or is insecure
	 * @throws \RangeException if $newAuthorEmail is over 128 characters
	 * @throws \TypeError if $newAuthorEmail is not a string
	 **/
	public function setAuthorEmail($newAuthorEmail) {
		//verify that the email is valid
		$newAuthorEmail = trim($newAuthorEmail);
		$newAuthorEmail = filter_var($newAuthorEmail, FILTER_VALIDATE_EMAIL);
		if (empty($newAuthorEmail) === true) {
			throw(new\InvalidArgumentException("This email address is empty or insecure"));
		}
		// verify email is within length restriction
		if(strlen($newAuthorEmail) > 128) {
			throw(new\RangeException("Author Email is too large"));
		}
		//store new email address
		$this->authorEmail = $newAuthorEmail;
	}

	/**
	 * accessor method for author's hash
	 *
	 * @return $this->authorHash;
	 */
	public function getAuthorHash(): string {
		return $this->authorHash;
	}
	/**
	 * mutator method for author hash
	 *
	 * @param $newAuthorHash
	 * @throws \InvalidArgumentException if the $newAuthorHash is not secure
	 * @throws \RangeException if $newAuthorHash is not 128 characters
	 * @throws \TypeError if $newAuthorHash is not a string
	 */
	public function setAuthorHash($newAuthorHash) {
		//make sure the hash is formatted correctly
		$newAuthorHash = trim($newAuthorHash);
		if(empty($newAuthorHash) === true) {
			throw(new\InvalidArgumentException("password hash is empty or insecure"));
		}
		//enforce argon hash
		$authorHashInfo = password_get_info($newAuthorHash);
		if($authorHashInfo["algoName"] !== "argon2i") {
			throw(new\InvalidArgumentException("author hash is not valid"));
		}
		//make sure that hash is 97 characters
		if(strlen($newAuthorHash) !== 97) {
			throw(new\RangeException("author hash must be 97 characters"));
		}
		//store the hash
		$this->authorHash = $newAuthorHash;
	}
	/**
	 * accessor method for author's username
	 *
	 * @return string value of username
	 */
	public function getAuthorUsername(): string {
		return $this->authorUsername;
	}
	/**
	 * mutator method for author's username
	 *
	 * @param string $newAuthorUsername new value of author's username
	 * @throw \InvalidArgumentException if $newAuthorUsername is not a string or is insecure
	 * @throw \RangeException if $newAuthorUsername is over 32 characters long
	 * @throw \TypeError if $newAuthorUsername is not a string
	 **/
	public function setAuthorUsername(string $newAuthorUsername) : void {
		//verify that the username is secure
		$newAuthorUsername = trim($newAuthorUsername);
		$newAuthorUsername = filter_var($newAuthorUsername, FILTER_SANITIZE_STRING,
			FILTER_FLAG_NO_ENCODE_QUOTES);
		if (empty($newAuthorUsername) === true) {
			throw(new\InvalidArgumentException("Author username is empty or insecure"));
		}
		//verify that username is within limit
		if(strlen($newAuthorUsername) > 32) {
			throw(new\RangeException("That username is too long"));
		}
		//store username
		$this->authorUsername = $newAuthorUsername;
	}
	/**
	 * inserts this author into mySQL
	 *
	 * @param \PDO $pdo PDO connection object
	 * @throws \PDOException when ySQL errors occur
	 * @throws \TypeError when $pdo is not a PDO connection object
	 **/
	public function insert(\PDO $pdo) : void {
		//create query template
		$query = "INSERT INTO author(authorId, authorActivationToken, authorAvatarUrl, authorEmail, authorHash, authorUsername) VALUES(:authorId, :authorActivationToken, :authorAvatarUrl, :authorEmail, :authorHash, :authorUsername)";
		$statement = $pdo->prepare($query);
		//bind the member variables to the place holder in the template
		$parameters = ["authorId" => $this->authorId->getBytes(), "authorActivationToken" => $this->authorActivationToken, "authorAvatarUrl" => $this->authorAvatarUrl, "authorEmail" => $this->authorEmail, "authorHash" => $this->authorHash, "authorUsername" => $this->authorUsername];
		$statement->execute($parameters);
	}
	/**
	 * deletes this author from mySQL
	 *
	 * @param \PDO $pdo PDO connection object
	 * @throws \PDOException when ySQL errors occur
	 * @throws \TypeError when $pdo is not a PDO connection object
	 **/
	public function delete(\PDO $pdo) : void {
		//create query template
		$query = "DELETE FROM author WHERE authorId = :authorId";
		$statement = $pdo->prepare($query);
		//bind the member variables to the placeholder in the template
		$parameters = ["authorId" => $this->authorId->getBytes()];
		$statement->execute($parameters);
	}
	/**
	 * updates author in mySQL
	 *
	 * @param \PDO $pdo PDO connection object
	 * @throws \PDOException when mySQL errors occur
	 * @throws \TypeError when $pdo is not a PDO connection object
	 **/
	public function update(\PDO $pdo) : void {
		//create query template
		$query = "UPDATE author SET authorActivationToken = :authorActivationToken, authorAvatarUrl = :authorAvatarUrl, authorEmail = :authorEmail, authorHash = :authorHash, authorUsername = :authorUsername WHERE authorId = :authorId";
		$statement = $pdo->prepare($query);
		//bind the member variables to the placeholder in the template
		$parameters = ["authorId" => $this->authorId->getBytes(), "authorActivationToken" => $this->authorActivationToken, "authorAvatarUrl" => $this->authorAvatarUrl, "authorEmail" => $this->authorEmail, "authorHash" => $this->authorHash, "authorUsername" => $this->authorUsername];
		$statement->execute($parameters);
	}
	/**
	 * gets Author by authorId
	 *
	 * @param \PDO $pdo PDO connection object
	 * @param Uuid|string $authorId author id to search for
	 * @return Author|null Author found or null if not found
	 * @throws \PDOException when mySQL errors occur
	 * @throws \TypeError if a variable type is not correct
	 **/
	public function getAuthorByAuthorId(\PDO $pdo, $authorId) : ?Author {
		//sanitize author id before search
		try {
			$authorId = self::validateUuid($authorId);
		} catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
			throw(new \PDOException($exception->getMessage(), 0, $exception));
		}
		//crete query template
		$query = "SELECT authorId, authorEmail, authorUsername FROM author WHERE authorId = :authorId";
		$statement = $pdo->prepare($query);
		//bind the author id to the placeholder in the template
		$parameters = ["authorId" => $authorId->getBytes()];
		$statement->execute($parameters);
		//grab author from mySQL
		try {
			$author = null;
			$statement->setFetchMode(\PDO::FETCH_ASSOC);
			$row = $statement->fetch();
			if($row !== false) {
				$author = new Author($row["authorId"], $row["authorEmail"], $row["authorUsername"]);
			}
		} catch(\Exception $exception) {
			// if the row could not be converted properly
			throw(new \PDOException($exception->getMessage(), 0, $exception));
		}
		return ($author);
	}
	/**
	 * gets Author by username
	 *
	 * @param \PDO $pdo PDO connection object
	 * @param string $authorUsername username to search for
	 * @return \SplFixedArray SplFixedArray of authors found
	 * @throws \PDOException when mySQL errors occur
	 * @throws \TypeError when variables are not the correct data type
	 **/
	public static function getAuthorByAuthorUsername(\PDO $pdo, string $authorUsername) {
		// sanitize username before search
		$authorUsername = trim($authorUsername);
		$authorUsername = filter_var($authorUsername, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
		if(empty($authorUsername) === true) {
			throw(new \PDOException("username is invalid"));
		}
		//escape any mySQL wildcards
		$authorUsername = str_replace("_", "\\_", str_replace("%", "\\%", $authorUsername));
		//create query template
		$query = "SELECT authorId, authorUsername, authorAvatarUrl FROM author WHERE authorUsername LIKE :authorUsername";
		$statement = $pdo->prepare($query);
		//bind the username to the placeholder in the template
		$authorUsername = "%$authorUsername%";
		$parameters = ["authorUsername" => $authorUsername];
		$statement->execute($parameters);
		//build an array of users
		$authors = new \SplFixedArray($statement->rowCount());
		$statement->setFetchMode(\PDO::FETCH_ASSOC);
		while(($row = $statement->fetch()) !== false) {
			try {
				$author = new Author($row["authorId"], $row["authorUsername"], $row["authorAvatarUrl"]);
				$authors[$authors->key()] = $author;
				$authors->next();
			} catch(\Exception $exception) {
				//if the row couldn't be converted, rethrow it
				throw(new \PDOException($exception->getMessage(), 0, $exception));
			}
		}
		return ($authors);
	}

	/**
	 * gets all authors
	 *
	 * @param \PDO $pdo PDO connection object
	 * @return \SplFixedArray SplFixedArray of authors found or null if not found
	 * @throws \PDOException when mySQL errors occur
	 * @throws \TypeError when variables are not the correct data type
	 **/
	public static function getAllAuthors(\PDO $pdo) : \SplFixedArray {
		//create query template
		$query = "SELECT authorId, authorUsername, authorAvatarUrl FROM author";
		$statement = $pdo->prepare($query);
		$statement->execute();
		//build array of authors
		$authors = new \SplFixedArray($statement->rowCount());
		$statement->setFetchMode(\PDO::FETCH_ASSOC);
		while(($row = $statement->fetch()) !== false) {
			try {
				$author = new Author($row["authorId"], $row["authorUsername"], $row["authorAvatarUrl"]);
				$authors[$authors->key()] = $author;
				$authors->next();
			} catch(\Exception $exception) {
				//if the row could not be converted, rethrow it
				throw(new \PDOException($exception->getMessage(), 0, $exception));
			}
		}
		return ($authors);
	}

	public function jsonSerialize() : array {
		$fields = get_object_vars($this);

		$fields["authorId"] = $this->authorId->toString();

		return ($fields);
	}
}
