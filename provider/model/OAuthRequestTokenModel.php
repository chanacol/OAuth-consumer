<?php

#TODO comments
#TODO return $this in setters for chaining?

class OAuthRequestTokenModel extends ModelBase
{

//OAuth access token specific fields

	/**
	 * @var int
	 */
	private $tokenId 				= null;
	/**
	 * @var string
	 */
	private $token					= null;
	/**
	 * @var string
	 */
	private $tokenSecret			= null;
	/**
	 * @var string
	 */
	private $tokenVerificationCode	= null;
	/**
	 * @var int
	 */
	private $tokenUserId			= null;
	/**
	 * @var int (timestamp)
	 */
	private $tokenDate				= null;
	/**
	 * @var string
	 */
	private $tokenConsumerKey		= null;
	/**
	 * @var string
	 */
	private $tokenCallback			= null;
	/**
	 * @var string
	 */
	private $tokenScope				= null;

//methods

	/**
	 * Serves as factory method. Loads the data for a request token based on the token
	 * string.
	 *
	 * @static
	 * @param 	string $token
	 * @param 	mixed $DataStore
	 * @return 	bool|OAuthRequestTokenModel
	 */
	public static function loadFromToken($token, $DataStore)
	{
		$sql = "SELECT *
				FROM `oauth_provider_request_token`
				WHERE `request_token_token` = '" . $DataStore->real_escape_string($token) . "'";

		$result = $DataStore->query($sql);

		if (!$result || $result->num_rows < 1) {
			return false;
		}

		$data 	= $result->fetch_assoc();
		$result->close();
#TODO set fields directly?
		$RequestToken = new OAuthRequestTokenModel($DataStore);
		$RequestToken->setId($data['request_token_id']);
		$RequestToken->setToken($data['request_token_token']);
		$RequestToken->setTokenSecret($data['request_token_secret']);
		$RequestToken->setTokenVerificationCode($data['request_token_verification_code']);
		$RequestToken->setTokenUserId($data['request_token_user_id']);
		$RequestToken->setTokenDate($data['request_token_date']);
		$RequestToken->setTokenConsumerKey($data['request_token_consumer_key']);
		$RequestToken->setTokenCallback($data['request_token_callback']);
		$RequestToken->setTokenScope($data['request_token_scope']);

		return $RequestToken;
	}

//CRUD

	/**
	 * Creates a new row for this Access token in the datastore. MUST set the field tokenId here.
	 *
	 * @return void
	 */
	protected function create()
	{
		#TODO not all fields are required at once here, how to solve this?
		$sql = "INSERT INTO `oauth_provider_request_token`
				SET `request_token_token` = '" . $this->DataStore->real_escape_string($this->token) . "',
					`request_token_secret` = '" . $this->DataStore->real_escape_string($this->tokenSecret) . "',
					`request_token_verification_code` = '" . $this->DataStore->real_escape_string($this->tokenVerificationCode) . "',
					`request_token_user_id` = '" . $this->DataStore->real_escape_string($this->tokenUserId) . "',
					`request_token_date` = '" . $this->DataStore->real_escape_string($this->tokenDate) . "',
					`request_token_consumer_key` = '" . $this->DataStore->real_escape_string($this->tokenConsumerKey) . "',
					`request_token_callback` = '" . $this->DataStore->real_escape_string($this->tokenCallback) . "',
					`request_token_scope` = '" . $this->DataStore->real_escape_string($this->tokenScope) . "'";

		if ($this->DataStore->query($sql)) {
			$this->tokenId = $this->DataStore->insert_id;
		} else {
			#TODO throw exception?
		}
	}

	/**
	 * Reads and returns the data for the access token with id $tokenId
	 *
	 * @param 	$tokenId
	 * @return 	array $data  An associative array with the data for $tokenId
	 */
	protected function read()
	{
		#TODO error handling. What if the token Id isn't found for instance
		$sql = "SELECT request_token_id`, `request_token_token`, `request_token_secret`, `request_token_verification_code`,
					`request_token_user_id`, `request_token_date`, `request_token_consumer_key`, `request_token_callback`,
					`request_token_scope`
				FROM `oauth_provider_request_token`
				WHERE `request_token_id` = '" . $this->DataStore->real_escape_string($this->tokenId) . "'";

		$result = $this->DataStore->query($sql);
		$data 	= $result->fetch_assoc();
		$result->close();

		return $data;
	}

	/**
	 * Updates the row in the datastore for this OAuth access token.
	 *
	 * @return void
	 */
	protected function update()
	{
		#TODO not all fields are required at once here, how to solve this?
		$sql = "UPDATE `oauth_provider_request_token`
				SET `request_token_token` = '" . $this->DataStore->real_escape_string($this->token) . "',
					`request_token_secret` = '" . $this->DataStore->real_escape_string($this->tokenSecret) . "',
					`request_token_verification_code` = '" . $this->DataStore->real_escape_string($this->tokenVerificationCode) . "',
					`request_token_user_id` = '" . $this->DataStore->real_escape_string($this->tokenUserId) . "',
					`request_token_date` = '" . $this->DataStore->real_escape_string($this->tokenDate) . "',
					`request_token_consumer_key` = '" . $this->DataStore->real_escape_string($this->tokenConsumerKey) . "',
					`request_token_callback` = '" . $this->DataStore->real_escape_string($this->tokenCallback) . "',
					`request_token_scope` = '" . $this->DataStore->real_escape_string($this->tokenScope) . "'
				WHERE `request_token_id` = '" . $this->DataStore->real_escape_string($this->tokenId) . "'";

		if (!$this->DataStore->query($sql)) {
			#TODO throw exception?
		}
	}

	/**
	 * Deletes the row in the datastore for this OAuth access token.
	 *
	 * @return void
	 */
	protected function delete()
	{
		$sql = "DELETE FROM `oauth_provider_request_token`
				WHERE `request_token_id` = '" . $this->DataStore->real_escape_string($this->tokenId) . "'";

		if (!$this->DataStore->query($sql)) {
			#TODO throw exception?
		}
	}

//getters and setters

	/**
	 * @param string $token
	 */
	public function setToken($token)
	{
		$this->token = $token;
	}

	/**
	 * @return string
	 */
	public function getToken()
	{
		return $this->token;
	}

	/**
	 * @param string $tokenCallback
	 */
	public function setTokenCallback($tokenCallback)
	{
		$this->tokenCallback = $tokenCallback;
	}

	/**
	 * @return string
	 */
	public function getTokenCallback()
	{
		return $this->tokenCallback;
	}

	/**
	 * @param string $tokenConsumerKey
	 */
	public function setTokenConsumerKey($tokenConsumerKey)
	{
		$this->tokenConsumerKey = $tokenConsumerKey;
	}

	/**
	 * @return string
	 */
	public function getTokenConsumerKey()
	{
		return $this->tokenConsumerKey;
	}

	/**
	 * @param int (timestamp) $tokenDate
	 */
	public function setTokenDate($tokenDate)
	{
		$this->tokenDate = $tokenDate;
	}

	/**
	 * @return int (timestamp)
	 */
	public function getTokenDate()
	{
		return $this->tokenDate;
	}

	/**
	 * @param int $tokenId
	 */
	public function setId($tokenId)
	{
		$this->tokenId = $tokenId;
	}

	/**
	 * @return int
	 */
	public function getId()
	{
		return $this->tokenId;
	}

	/**
	 * @param string $tokenScope
	 */
	public function setTokenScope($tokenScope)
	{
		$this->tokenScope = $tokenScope;
	}

	/**
	 * @return string
	 */
	public function getTokenScope()
	{
		return $this->tokenScope;
	}

	/**
	 * @param string $tokenSecret
	 */
	public function setTokenSecret($tokenSecret)
	{
		$this->tokenSecret = $tokenSecret;
	}

	/**
	 * @return string
	 */
	public function getTokenSecret()
	{
		return $this->tokenSecret;
	}

	/**
	 * @param int $tokenUserId
	 */
	public function setTokenUserId($tokenUserId)
	{
		$this->tokenUserId = $tokenUserId;
	}

	/**
	 * @return int
	 */
	public function getTokenUserId()
	{
		return $this->tokenUserId;
	}

	/**
	 * @param string $tokenVerificationCode
	 */
	public function setTokenVerificationCode($tokenVerificationCode)
	{
		$this->tokenVerificationCode = $tokenVerificationCode;
	}

	/**
	 * @return string
	 */
	public function getTokenVerificationCode()
	{
		return $this->tokenVerificationCode;
	}


}