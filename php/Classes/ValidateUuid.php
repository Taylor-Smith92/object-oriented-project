<?php
namespace TaylorSmith\objectOrientedProject;

require_once(dirname(__DIR__, 2) . "/vendor/autoload.php");

use Ramsey\Uuid\Uuid;
/**
 * Trait that will validate uuid
 *
 * Trait accepts uuids in three different formats;
 * human readable (16 bytes)
 * binary string (16 bytes)
 * Ramsey\Uuid\Uuid object
 *
 * @author Taylor Smith <taylorleesmith92@gmail.com>
 **/
trait ValidateUuid {
	/**
	 * validates all forms of uuid
	 *
	 * @param string|Uuid $newUuid uuid to validate
	 * @return Uuid object with a validated uuid
	 * @throws \InvalidArgumentException if $newUuid is not valid
	 * @throws \RangeException if $newUuid is not a valid uuid v4
	 **/
	private static function validateUuid($newUuid) : Uuid {
		// verify a Uuid in string format
		if(gettype($newUuid) === "string") {
			// 16 character is binary from mySQL
			if(strlen($newUuid) === 16) {
				$newUuid = bin2hex($newUuid);
				$newUuid = substr($newUuid, 0, 8) . "-" . substr($newUuid, 8, 4) . "-" .
					substr($newUuid, 12, 4) . "-" . substr($newUuid, 16, 4) . "-" .
					substr($newUuid, 20, 12);
			}
			// 36 characters is human readable uuid format
			if(strlen($newUuid) === 36) {
				if(Uuid::isValid($newUuid) === false) {
					throw(new\InvalidArgumentException("uuid is invalid"));
				}
				$uuid = Uuid::fromString($newUuid);
			} else {
				throw(new\InvalidArgumentException("uuid is invalid"));
			}
		} else if (getType($newUuid) === "object" && get_class($newUuid) === "Ramsey\\Uuid\\Uuid") {
			$uuid = $newUuid;
		} else {
			// for anything not defined
			throw(new\InvalidArgumentException("uuid is invalid"));
		}
		// verify that uuid is uuid v4
		if($uuid->getVersion() !== 4){
			throw(new\RangeException("uuid is incorrect version"));
		}
		return($uuid);
	}
}
