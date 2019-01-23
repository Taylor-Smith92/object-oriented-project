/**create table author(
authorId binary(16) not null,
authorAvatarUrl varchar(255),
authorActivationToken char(32),
authorEmail varchar(128) not null,
authorHash char(97) not null,
authorUsername varchar(32) not null,
unique(authorEmail),
unique(authorUsername),
INDEX(authorEmail),
primary key(authorId)
);
**/

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
	 * this author's activation token
	 **/
	private $authorActivationToken;
	/**
	 * this author's email address
	 **/
	private $authorEmail;
	/**
	 * this author's password
	 */
	private $authorHash
	/**
	 * this author's username
	 */
	private $authorUsername;

	/**
	 * accessor method for author Id
	 *
	 * @return int value of author Id
	 **/
	public function getAuthorId() {
		return($this->authorId);
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
}
?>