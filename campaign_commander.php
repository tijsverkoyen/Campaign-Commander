<?php

/**
 * Campaign Commander class
 *
 * This source file can be used to communicate with Campaign Commander (http://campaigncommander.com)
 *
 * The class is documented in the file itself. If you find any bugs help me out and report them. Reporting can be done by sending an email to php-campaign-commander-member-bugs[at]verkoyen[dot]eu.
 * If you report a bug, make sure you give me enough information (include your code).
 *
 * Changelog since 1.0.0
 * - modified the class to reflect the current API.
 * - implemented all Message-methods.
 * - implemented all URL-management-methods.
 * - implemented all test-group-methods.
 *
 *
 * License
 * Copyright (c), Tijs Verkoyen. All rights reserved.
 *
 * Redistribution and use in source and binary forms, with or without modification, are permitted provided that the following conditions are met:
 *
 * 1. Redistributions of source code must retain the above copyright notice, this list of conditions and the following disclaimer.
 * 2. Redistributions in binary form must reproduce the above copyright notice, this list of conditions and the following disclaimer in the documentation and/or other materials provided with the distribution.
 * 3. The name of the author may not be used to endorse or promote products derived from this software without specific prior written permission.
 *
 * This software is provided by the author "as is" and any express or implied warranties, including, but not limited to, the implied warranties of merchantability and fitness for a particular purpose are disclaimed. In no event shall the author be liable for any direct, indirect, incidental, special, exemplary, or consequential damages (including, but not limited to, procurement of substitute goods or services; loss of use, data, or profits; or business interruption) however caused and on any theory of liability, whether in contract, strict liability, or tort (including negligence or otherwise) arising in any way out of the use of this software, even if advised of the possibility of such damage.
 *
 * @author			Tijs Verkoyen <php-campaign-commander-member@verkoyen.eu>
 * @version			1.1.0
 *
 * @copyright		Copyright (c), Tijs Verkoyen. All rights reserved.
 * @license			BSD License
 */
class CampaignCommander
{
	// internal constant to enable/disable debugging
	const DEBUG = false;

	// URL for the api
	const WSDL_URL = 'apiccmd/services/CcmdService?wsdl';

	// current version
	const VERSION = '1.1.0';


	/**
	 * The API-key that will be used for authenticating
	 *
	 * @var	string
	 */
	private $key;


	/**
	 * The login that will be used for authenticating
	 *
	 * @var	string
	 */
	private $login;


	/**
	 * The password that will be used for authenticating
	 *
	 * @var	string
	 */
	private $password;


	/**
	 * The server to use
	 *
	 * @var	string
	 */
	private $server = 'http://emvapi.emv3.com';


	/**
	 * The SOAP-client
	 *
	 * @var	SoapClient
	 */
	private $soapClient;


	/**
	 * The token
	 *
	 * @var	string
	 */
	private $token = null;


	/**
	 * The timeout
	 *
	 * @var	int
	 */
	private $timeOut = 60;


	/**
	 * The user agent
	 *
	 * @var	string
	 */
	private $userAgent;


// class methods
	/**
	 * Default constructor
	 *
	 * @return	void
	 * @param	string $login		Login provided for API access.
	 * @param	string $password	The password.
	 * @param	string $key			Manager Key copied from the CCMD web application.
	 */
	public function __construct($login, $password, $key, $server = null)
	{
		$this->setLogin($login);
		$this->setPassword($password);
		$this->setKey($key);
		if($server !== null) $this->setServer($server);
	}


	/**
	 * Destructor
	 *
	 * @return	void
	 */
	public function __destruct()
	{
		// is the connection open?
		if($this->soapClient !== null)
		{
			try
			{
				// close
				$this->closeApiConnection();
			}

			// catch exceptions
			catch(Exception $e)
			{
				// do nothing
			}

			// reset vars
			$this->soapClient = null;
			$this->token = null;
		}
	}


	/**
	 * Make the call
	 *
	 * @return	mixed
	 * @param	string $method					The method to be called.
	 * @param	array[optional] $parameters		The parameters.
	 */
	private function doCall($method, array $parameters = array())
	{
		// open connection if needed
		if($this->soapClient === null || $this->token === null)
		{
			// build options
			$options = array('soap_version' => SOAP_1_1,
							 'trace' => self::DEBUG,
							 'exceptions' => false,
							 'connection_timeout' => $this->getTimeOut(),
							 'user_agent' => $this->getUserAgent());

			// create client
			$this->soapClient = new SoapClient($this->getServer() . '/' . self::WSDL_URL, $options);

			// build login parameters
			$loginParameters['login'] = $this->getLogin();
			$loginParameters['pwd'] = $this->getPassword();
			$loginParameters['key'] = $this->getKey();

			// make the call
			$response = $this->soapClient->__soapCall('openApiConnection', array($loginParameters));

			// validate
			if(is_soap_fault($response))
			{
				// init var
				$message = 'Internal Error';

				// more detailed message available
				if(isset($response->detail->ConnectionServiceException->description)) $message = (string) $response->detail->ConnectionServiceException->description;

				// internal debugging enabled
				if(self::DEBUG)
				{
					echo '<pre>';
					echo 'last request<br />';
					var_dump($this->soapClient->__getLastRequest());
					echo 'response<br />';
					var_dump($response);
					echo '</pre>';
				}

				// throw exception
				throw new CampaignCommanderException($message);
			}

			// validate response
			if(!isset($response->return)) throw new CampaignCommanderException('Invalid response');

			// set token
			$this->token = (string) $response->return;
		}

		// redefine
		$method = (string) $method;
		$parameters = (array) $parameters;

		// loop parameters
		foreach($parameters as $key => $value)
		{
			// strings should be UTF8
			if(gettype($value) == 'string') $parameters[$key] = utf8_encode($value);
		}

		// add token
		$parameters['token'] = $this->token;

		// make the call
		$response = $this->soapClient->__soapCall($method, array($parameters));

		// validate response
		if(is_soap_fault($response))
		{
			// init var
			$message = 'Internal Error';

			// more detailed message available
			if(isset($response->detail->ConnectionServiceException->description)) $message = (string) $response->detail->ConnectionServiceException->description;
			if(isset($response->detail->MemberServiceException->description)) $message = (string) $response->detail->MemberServiceException->description;
			if(isset($response->detail->CcmdServiceException->description))
			{
				$message = (string) $response->detail->CcmdServiceException->description;
				if(isset($response->detail->CcmdServiceException->fields)) $message .= ' fields: ' . $response->detail->CcmdServiceException->fields;
				if(isset($response->detail->CcmdServiceException->status)) $message .= ' status: ' . $response->detail->CcmdServiceException->status;
			}

			// internal debugging enabled
			if(self::DEBUG)
			{
				echo '<pre>';
				var_dump(htmlentities($this->soapClient->__getLastRequest()));
				var_dump($this);
				echo '</pre>';
			}

			// throw exception
			throw new CampaignCommanderException($message);
		}

		// empty reply
		if(!isset($response->return)) return null;

		// return the response
		return $response->return;
	}


	/**
	 * Get the key
	 *
	 * @return	string
	 */
	private function getKey()
	{
		return (string) $this->key;
	}


	/**
	 * Get the login
	 *
	 * @return	string
	 */
	private function getLogin()
	{
		return (string) $this->login;
	}


	/**
	 * Get the password
	 *
	 * @return	string
	 */
	private function getPassword()
	{
		return $this->password;
	}


	/**
	 * Get the server
	 *
	 * @return	string
	 */
	private function getServer()
	{
		return $this->server;
	}


	/**
	 * Get the timeout that will be used
	 *
	 * @return	int
	 */
	public function getTimeOut()
	{
		return (int) $this->timeOut;
	}


	/**
	 * Get the useragent that will be used. Our version will be prepended to yours.
	 * It will look like: "PHP Campaign Commander/<version> <your-user-agent>"
	 *
	 * @return	string
	 */
	public function getUserAgent()
	{
		return (string) 'PHP Campaign Commander/' . self::VERSION . ' ' . $this->userAgent;
	}


	/**
	 * Set the Key that has to be used
	 *
	 * @return	void
	 * @param	string $key		The key to set.
	 */
	private function setKey($key)
	{
		$this->key = (string) $key;
	}


	/**
	 * Set the login that has to be used
	 *
	 * @return	void
	 * @param	string $login	The login to use.
	 */
	private function setLogin($login)
	{
		$this->login = (string) $login;
	}


	/**
	 * Set the password that has to be used
	 *
	 * @return	void
	 * @param	string $password	The password to use.
	 */
	private function setPassword($password)
	{
		$this->password = (string) $password;
	}


	/**
	 * Set the server that has to be used.
	 *
	 * @return	void
	 * @param	string $server
	 */
	private function setServer($server)
	{
		$this->server = (string) $server;
	}


	/**
	 * Set the timeout
	 * After this time the request will stop. You should handle any errors triggered by this.
	 *
	 * @return	void
	 * @param	int $seconds	The timeout in seconds.
	 */
	public function setTimeOut($seconds)
	{
		$this->timeOut = (int) $seconds;
	}


	/**
	 * Set the user-agent for you application
	 * It will be appended to ours, the result will look like: "PHP Campaign Commander/<version> <your-user-agent>"
	 *
	 * @return	void
	 * @param	string $userAgent	Your user-agent, it should look like <app-name>/<app-version>.
	 */
	public function setUserAgent($userAgent)
	{
		$this->userAgent = (string) $userAgent;
	}


// connection methods
	/**
	 * Close the connection
	 *
	 * @return	bool	true if the connection was closes, otherwise false
	 */
	public function closeApiConnection()
	{
		// make the call
		$response = $this->doCall('closeApiConnection');

		// validate response
		if($response == 'connection closed')
		{
			// reset vars
			$this->soapClient = null;
			$this->token = null;

			return true;
		}

		// fallback
		return false;
	}


// message methods
	/**
	 * Create email-message.
	 *
	 * @return	string								The message ID.
	 * @param	string $name						Name of the message.
	 * @param	string $description					Description of the message.
	 * @param	string $subject						Subject of the message.
	 * @param	string $from						From name.
	 * @param	string $fromEmail					From email-address.
	 * @param	string $to							To name.
	 * @param	string $body						Body of the email.
	 * @param	string $encoding					Encoding to use.
	 * @param	string $replyTo						Reply-to name.
	 * @param	string $replyToEmail				Reply-to email.
	 * @param	bool[optional] $bounceback			Use as bounceback message?
	 * @param	bool[optional] $unsubscribe			Use unsubscribe feature of Windows Live Mail.
	 * @param	string[optional] $unsublinkpage		Unjoin URL, imporve deliverability displaying a unsubscribe button in Windows Live Mail.
	 */
	public function createEmailMessage($name, $description, $subject, $from, $fromEmail, $to, $body, $encoding, $replyTo, $replyToEmail, $bounceback = false, $unsubscribe = false, $unsublinkpage = null)
	{
		// build parameters
		$parameters = array();
		$parameters['name'] = (string) $name;
		$parameters['description'] = (string) $description;
		$parameters['subject'] = (string) $subject;
		$parameters['from'] = (string) $from;
		$parameters['fromEmail'] = (string) $fromEmail;
		$parameters['to'] = (string) $to;
		$parameters['body'] = (string) $body;
		$parameters['encoding'] = (string) $encoding;
		$parameters['replyTo'] = (string) $replyTo;
		$parameters['replyToEmail'] = (string) $replyToEmail;
		$parameters['isBounceback'] = ($bounceback) ? '1' : '0';
		$parameters['hotmailUnsubFlg'] = ($unsubscribe) ? '1' : '0';
		if($unsublinkpage !== null) $parameters['hotmailUnsubUrl'] = (string) $unsublinkpage;

		// make the call
		return $this->doCall('createEmailMessage', $parameters);
	}


	/**
	 * Create email-message.
	 *
	 * @return	string				The message ID.
	 * @param	array $message		The message object.
	 */
	public function createEmailMessageByObj(array $message)
	{
		// build parameters
		$parameters = array();
		$parameters['message'] = $message;

		// make the call
		return $this->doCall('createEmailMessageByObj', $parameters);
	}


	/**
	 * Create SMS-message.
	 *
	 * @return	string				The message ID.
	 * @param	string $name		Name of the message.
	 * @param	string $desc		Description of the message.
	 * @param	string $from		From name.
	 * @param	string $body		Body of the SMS.
	 */
	public function createSmsMessage($name, $desc, $from, $body)
	{
		// build parameters
		$parameters = array();
		$parameters['name'] = (string) $name;
		$parameters['desc'] = (string) $desc;
		$parameters['from'] = (string) $from;
		$parameters['body'] = (string) $body;

		// make the call
		return $this->doCall('createSMSMessage', $parameters);
	}


	/**
	 * Create SMS-message.
	 *
	 * @return	string				The message ID.
	 * @param	array $message		The message object.
	 */
	public function createSmsMessageByObj(array $message)
	{
		// build parameters
		$parameters = array();
		$parameters['message'] = $message;

		// make the call
		return $this->doCall('createSmsMessageByObj', $parameters);
	}


	/**
	 * Delete message.
	 *
	 * @return	bool			true if delete was successful.
	 * @param	string $id		ID of the message.
	 */
	public function deleteMessage($id)
	{
		// build parameters
		$parameters = array();
		$parameters['id'] = $message;

		// make the call
		return $this->doCall('deleteMessage', $parameters);
	}


	/**
	 * Update a message field.
	 *
	 * @return	bool			true if the update was successful.
	 * @param	string $id		ID of the message.
	 * @param	string $field	The field to update.
	 * @param	mixed $value	The value to set.
	 */
	public function updateMessage($id, $field, $value)
	{
		// build parameters
		$parameters = array();
		$parameters['id'] = (string) $id;
		$parameters['field'] = (string) $field;
		$parameters['value'] = $mixed;

		// make the call
		return $this->doCall('updateMessage', $parameters);
	}


	/**
	 * Update email-message.
	 *
	 * @return	bool				true if the update was successful.
	 * @param	array $message		The message object.
	 */
	public function updateMessageByObj(array $message)
	{
		// build parameters
		$parameters = array();
		$parameters['message'] = $message;

		// make the call
		return $this->doCall('updateMessageByObj', $parameters);
	}


	/**
	 * Clone a message.
	 *
	 * @return	string				ID of the newly created message.
	 * @param	string $id			ID of the message.
	 * @param	string $newName		Name of the newly created message.
	 */
	public function cloneMessage($id, $newName)
	{
		// build parameters
		$parameters = array();
		$parameters['id'] = (string) $id;
		$parameters['newName'] = (string) $newName;

		// make the call
		return $this->doCall('cloneMessage', $parameters);
	}


	/**
	 * Get message.
	 *
	 * @return	array			The message object.
	 * @param	string $id		ID of the message.
	 */
	public function getMessage($id)
	{
		// build parameters
		$parameters['id'] = (string) $id;

		// make the call
		return (array) $this->doCall('getMessage', $parameters);
	}


	/**
	 * Get last email-messages.
	 *
	 * @return	array			IDs of messages.
	 * @param	int $limit	Maximum number of messages to retrieve.
	 */
	public function getLastEmailMessages($limit)
	{
		// build parameters
		$parameters['limit'] = (int) $limit;

		// make the call
		return (array) $this->doCall('getLastEmailMessages', $parameters);
	}


	/**
	 * Get last SMS-messages.
	 *
	 * @return	array			IDs of messages.
	 * @param	int $limit	Maximum number of messages to retrieve.
	 */
	public function getLastSmsMessages($limit)
	{
		// build parameters
		$parameters['limit'] = (int) $limit;

		// make the call
		return (array) $this->doCall('getLastSmsMessages', $parameters);
	}


	/**
	 * Get email-messages by field.
	 *
	 * @return	array			IDs of messages matching the search.
	 * @param	string $field	Field to search.
	 * @param	mixed $value	Value to search.
	 * @param	int $limit		Maximum number of messages to retrieve.
	 */
	public function getEmailMessagesByField($field, $value, $limit)
	{
		// build parameters
		$parameters = array();
		$parameters['field'] = (string) $field;
		$parameters['value'] = $value;
		$parameters['limit'] = (int) $limit;

		// make the call
		return $this->doCall('getEmailMessagesByField', $parameters);
	}


	/**
	 * Get SMS-messages by field.
	 *
	 * @return	array			IDs of messages matching the search.
	 * @param	string $field	Field to search.
	 * @param	mixed $value	Value to search.
	 * @param	int $limit		Maximum number of messages to retrieve.
	 */
	public function getSmsMessagesByField($field, $value, $limit)
	{
		// build parameters
		$parameters = array();
		$parameters['field'] = (string) $field;
		$parameters['value'] = $value;
		$parameters['limit'] = (int) $limit;

		// make the call
		return $this->doCall('getSmsMessagesByField', $parameters);
	}


	/**
	 * Get messages by period.
	 *
	 * @return	array				IDs of messages matching the search.
	 * @param	int $dateBegin		Begin date of the period.
	 * @param	int $dateEnd		End date of the period.
	 */
	public function getMessagesByPeriod($dateBegin, $dateEnd)
	{
		// build parameters
		$parameters['dateBegin'] = date('Y-m-d H:i:s', (int) $dateBegin);
		$parameters['dateEnd'] = date('Y-m-d H:i:s', (int) $dateEnd);

		// make the call
		return (array) $this->doCall('getMessagesByPeriod', $parameters);
	}


	/**
	 * Get email-message preview.
	 *
	 * @return	array				Preview of the message.
	 * @param	string $messageId	ID of the message.
	 * @param	string $part		Part of the message to preview (HTML or text).
	 */
	public function getEmailMessagePreview($messageId, $part = 'HTML')
	{
		// @todo	validate
		// build parameters
		$parameters = array();
		$parameters['messageId'] = (string) $messageId;
		$parameters['part'] = $part;

		// make the call
		return $this->doCall('getEmailMessagePreview', $parameters);
	}


	/**
	 * Get SMS-message preview.
	 *
	 * @return	string				Preview of the SMS-message.
	 * @param	string $messageId	ID of the message.
	 */
	public function getSmsMessagePreview($messageId)
	{
		// build parameters
		$parameters = array();
		$parameters['messageId'] = (string) $messageId;

		// make the call
		return $this->doCall(getSmsMessagePreview'', $parameters);
	}


	/**
	 * Activate tracking for all links.
	 *
	 * @return	array
	 * @param	string $id		ID of the message.
	 */
	public function trackAllLinks($id)
	{
		// build parameters
		$parameters = array();
		$parameters['id'] = (string) $id;

		// make the call
		return $this->doCall('trackAllLinks', $parameters);
	}


	/**
	 * Deactivate link tracking for all links.
	 *
	 * @return	bool			true if the untrack operation was successful.
	 * @param	string $id		ID of the message.
	 */
	public function untrackAllLinks($id)
	{
		// build parameters
		$parameters = array();
		$parameters['id'] = (string) $id;

		// make the call
		return $this->doCall('untrackAllLinks', $parameters);
	}


	/**
	 * Tracks a link based on its position in an email.
	 *
	 * @return	array				The order number of the URL.
	 * @param	string $id			ID of the message.
	 * @param	string $position	Position of the link to update in the message.
	 * @param	string $part		HTML or text.
	 */
	public function trackLinkByPosition($id, $position, $part = 'HTML')
	{
		// @todo	validate
		// build parameters
		$parameters = array();
		$parameters['id'] = (string) $id;
		$parameters['position'] = (string) $position;
		$parameters['part'] = (string) $part;

		// make the call
		return $this->doCall('trackLinkByPosition', $parameters);
	}


	/**
	 * Get a list of all teh tracked links in an email.
	 *
	 * @return	array			List of IDs of the tracked links.
	 * @param	string $id		ID of the message.
	 */
	public function getAllTrackedLinks($id)
	{
		// build parameters
		$parameters = array();
		$parameters['id'] = (string) $id;

		// make the call
		return $this->doCall('getAllTrackedLinks', $parameters);
	}


	/**
	 * Retrieves the unused tracked links for an email.
	 *
	 * @return	array			List of IDs of the unused tracked links.
	 * @param	string $id		ID of the message.
	 */
	public function getAllUnusedTrackedLinks($id)
	{
		// build parameters
		$parameters = array();
		$parameters['id'] = (string) $id;

		// make the call
		return $this->doCall('getAllUnusedTrackedLinks', $parameters);
	}


	/**
	 * Retrieves all the trackable links in an email.
	 *
	 * @return	array			List of IDs of the trackable links.
	 * @param	string $id		ID of the message.
	 */
	public function getAllTrackableLinks($id)
	{
		// build parameters
		$parameters = array();
		$parameters['id'] = (string) $id;

		// make the call
		return $this->doCall('getAllTrackableLinks', $parameters);
	}


	/**
	 * Sends a test email campaign to a group of recipients.
	 *
	 * @return							true if successfull, false otherwise.
	 * @param	string $id				The ID of the message to test.
	 * @param	string $groupId			The ID of the group to use for the test.
	 * @param	string $campaignName	The name of the test campaign.
	 * @param	string $subject			The subject of the message to test.
	 * @param	string $part			The part of the message to send, allowed values are: HTML, TXT, MULTIPART.
	 */
	public function testEmailMessageByGroup($id, $groupId, $campaignName, $subject, $part = 'MULTIPART')
	{
		// @todo	validate
		// build parameters
		$parameters = array();
		$parameters['id'] = (string) $id;
		$parameters['groupId'] = (string) $groupId;
		$parameters['campaignName'] = (string) $campaignName;
		$parameters['subject'] = (string) $subject;
		$parameters['part'] = (string) $part;

		// make the call
		return $this->doCall('testEmailMessageByGroup', $parameters);
	}


	/**
	 * Sends a test email campaign to a member.
	 *
	 * @return							true if successfull, false otherwise.
	 * @param	string $id				The ID of the message to test.
	 * @param	string $memberId		The ID of the member to use for the test.
	 * @param	string $campaignName	The name of the test campaign.
	 * @param	string $subject			The subject of the message to test.
	 * @param	string $part			The part of the message to send, allowed values are: HTML, TXT, MULTIPART.
	 */
	public function testEmailMessageByMember($id, $memberId, $campaignName, $subject, $part = 'MULTIPART')
	{
		// @todo	validate
		// build parameters
		$parameters = array();
		$parameters['id'] = (string) $id;
		$parameters['memberId'] = (string) $memberId;
		$parameters['campaignName'] = (string) $campaignName;
		$parameters['subject'] = (string) $subject;
		$parameters['part'] = (string) $part;

		// make the call
		return $this->doCall('testEmailMessageByMember', $parameters);
	}


	/**
	 * Sends a test email campaign to a member.
	 *
	 * @return							true if successfull, false otherwise.
	 * @param	string $id				The ID of the message to test.
	 * @param	string $memberId		The ID of the member to use for the test.
	 * @param	string $campaignName	The name of the test campaign.
	 */
	public function testSmsMessage($id, $memberId, $campaignName)
	{
		// build parameters
		$parameters = array();
		$parameters['id'] = (string) $id;
		$parameters['memberId'] = (string) $memberId;
		$parameters['campaignName'] = (string) $campaignName;

		// make the call
		return $this->doCall('testSmsMessage', $parameters);
	}


	/**
	 * Retrieves the email address of the default sender.
	 *
	 * @return	string		The email address of the default sender.
	 */
	public function getDefaultSender()
	{
		// make the call
		return $this->doCall('getDefaultSender');
	}


	/**
	 * Get a list of validated alternate senders.
	 *
	 * @return	array	The list of email addresses.
	 */
	public function getValidatedAltSenders()
	{
		// make the call
		return $this->doCall('getValidatedAltSenders');
	}


	/**
	 * Get a list of not validated alternate senders.
	 *
	 * @return	array	The list of email addresses.
	 */
	public function getNotValidatedSenders()
	{
		// make the call
		return $this->doCall('getNotValidatedSenders');
	}


// url management methods
	/**
	 * Creates a standard link for an email.
	 *
	 * @return	string				ID of the created URL.
	 * @param	string $messageId	ID of the message.
	 * @param	string $name		Name of the URL.
	 * @param	string $url			URL to add.
	 */
	public function createStandardUrl($messageId, $name, $url)
	{
		// build parameters
		$parameters = array();
		$parameters['messageId'] = (string) $messageId;
		$parameters['name'] = (string) $name;
		$parameters['url'] = (string) $url;

		// make the call
		return $this->doCall('createStandardUrl', $parameters);
	}


	/**
	 * Scans your message from top to bottom and replaces first occurrence of &&& with [EMV LINK]ORDER[EMV /LINK] (where ORDER is the standard link order number).
	 *
	 * @return	int					The order number of the url.
	 * @param	string $messageId	The ID for the message.
	 * @param	string $name		The name of the URL.
	 * @param	string $url			The url of the link.
	 */
	public function createAndAddStandardUrl($messageId, $name, $url)
	{
		// build parameters
		$parameters = array();
		$parameters['messageId'] = (string) $messageId;
		$parameters['name'] = (string) $name;
		$parameters['url'] = (string) $url;

		// make the call
		return $this->doCall('createAndAddStandardUrl', $parameters);
	}


	/**
	 * Creates an unsubscribe link for an email.
	 *
	 * @return	string							ID of the created URL.
	 * @param	string $messageId				ID of the message.
	 * @param	string $name					Name of the URL.
	 * @param	string[optional] $pageOk		URL to call when unsubscribe was successful.
	 * @param	string[optional] $messageOk		Message to display when unsubscribe was successful.
	 * @param	string[optional] $pageError		URL to call when unsubscribe was unsuccessful.
	 * @param	string[optional] $messageError	Message to display when unsubscribe was unsuccessful.
	 */
	public function createUnsubscribeUrl($messageId, $name, $pageOk = null, $messageOk = null, $pageError = null, $messageError = null)
	{
		// build parameters
		$parameters = array();
		$parameters['messageId'] = (string) $messageId;
		$parameters['name'] = (string) $name;
		if($pageOk !== null) $parameters['pageOK'] = (string) $pageOk;
		if($messageOk !== null) $parameters['messageOK'] = (string) $messageOk;
		if($pageError !== null) $parameters['pageError'] = (string) $pageError;
		if($messageError !== null) $parameters['messageError'] = (string) $messageError;

		// make the call
		return $this->doCall('createUnsubscribeUrl', $parameters);
	}


	/**
	 * Scans your message from top to bottom and replaces the first occurrence of &&& with [EMV LINK]ORDER[EMV /LINK] (where ORDER is the unsubscribe link order number).
	 *
	 * @return	string							The order number of the url.
	 * @param	string $messageId				ID of the message.
	 * @param	string $name					Name of the URL.
	 * @param	string[optional] $pageOk		URL to call when unsubscribe was successful.
	 * @param	string[optional] $messageOk		Message to display when unsubscribe was successful.
	 * @param	string[optional] $pageError		URL to call when unsubscribe was unsuccessful.
	 * @param	string[optional] $messageError	Message to display when unsubscribe was unsuccessful.
	 */
	public function createAndAddUnsubscribeUrl($messageId, $name, $pageOk = null, $messageOk = null, $pageError = null, $messageError = null)
	{
		// build parameters
		$parameters = array();
		$parameters['messageId'] = (string) $messageId;
		$parameters['name'] = (string) $name;
		if($pageOk !== null) $parameters['pageOK'] = (string) $pageOk;
		if($messageOk !== null) $parameters['messageOK'] = (string) $messageOk;
		if($pageError !== null) $parameters['pageError'] = (string) $pageError;
		if($messageError !== null) $parameters['messageError'] = (string) $messageError;

		// make the call
		return $this->doCall('createAndAddUnsubscribeUrl', $parameters);
	}


	/**
	 * Creates an personalised link for an email
	 *
	 * @return	string				The order number of the URL.
	 * @param	string $messageId	ID of the message.
	 * @param	string $name		Name of the URL.
	 * @param	string $url			URL to add.
	 */
	public function createPersonalisedUrl($messageId, $name, $url)
	{
		// build parameters
		$parameters = array();
		$parameters['messageId'] = (string) $messageId;
		$parameters['name'] = (string) $name;
		$parameters['url'] = (string) $url;

		// make the call
		return $this->doCall('createPersonalisedUrl', $parameters);
	}


	/**
	 * Scans your message from top to bottom and replaces the first occirrence of &&& with [EMV LINK]ORDER[EMV /LINK] (where ORDER is the personalized link order number).
	 *
	 * @return	string				The order number of the URL.
	 * @param	string $messageId	ID of the message.
	 * @param	string $name		Name of the URL.
	 * @param	string $url			URL to add.
	 */
	public function createAndAddPersonalisedUrl($messageId, $name, $url)
	{
		// build parameters
		$parameters = array();
		$parameters['messageId'] = (string) $messageId;
		$parameters['name'] = (string) $name;
		$parameters['url'] = (string) $url;

		// make the call
		return $this->doCall('createAndAddPersonalisedUrl', $parameters);
	}


	/**
	 * Creates an update URL.
	 *
	 * @return	string					The order number of the URL.
	 * @param	string $messageId		ID of the message.
	 * @param	string $name			Name of the URL.
	 * @param	mixed $parameters		Update parameters to apply to the member table (for a particular member).
	 * @param	string $pageOk			Url to call when unsubscribe was successful.
	 * @param	string $messageOk		Message to display when unsubscribe was successful.
	 * @param	string $pageError		Url to call when unsubscribe was unsuccessful.
	 * @param	string $messageError	Message to display when unsubscribe was unssuccessful.
	 */
	public function createUpdateUrl($messageId, $name, $parameters, $pageOk, $messageOk, $pageError, $messageError)
	{
		// build parameters
		$parameters = array();
		$parameters['messageId'] = (string) $messageId;
		$parameters['name'] = (string) $name;
		$parameters['parameters'] = $parameters;
		$parameters['pageOK'] = (string) $pageOk;
		$parameters['messageOK'] = (string) $messageOk;
		$parameters['pageError'] = (string) $pageError;
		$parameters['messageError'] = (string) $messageError;

		// make the call
		return $this->doCall('createUpdateUrl', $parameters);
	}


	/**
	 * Scans your message from top to bottom and replaces the first occirrence of &&& with [EMV LINK]ORDER[EMV /LINK] (where ORDER is the update link order number).
	 *
	 * @return	string					The order number of the URL.
	 * @param	string $messageId		ID of the message.
	 * @param	string $name			Name of the URL.
	 * @param	mixed $parameters		Update parameters to apply to the member table (for a particular member).
	 * @param	string $pageOk			Url to call when unsubscribe was successful.
	 * @param	string $messageOk		Message to display when unsubscribe was successful.
	 * @param	string $pageError		Url to call when unsubscribe was unsuccessful.
	 * @param	string $messageError	Message to display when unsubscribe was unssuccessful.
	 */
	public function createAndAddUpdateUrl($messageId, $name, $parameters, $pageOk, $messageOk, $pageError, $messageError)
	{
		// build parameters
		$parameters = array();
		$parameters['messageId'] = (string) $messageId;
		$parameters['name'] = (string) $name;
		$parameters['parameters'] = $parameters;
		$parameters['pageOK'] = (string) $pageOk;
		$parameters['messageOK'] = (string) $messageOk;
		$parameters['pageError'] = (string) $pageError;
		$parameters['messageError'] = (string) $messageError;

		// make the call
		return $this->doCall('createAndAddUpdateUrl', $parameters);
	}


	/**
	 * Creates an action link for an email.
	 *
	 * @return									The order number of the URL.
	 * @param	string $messageId				The ID of the message to which to add a URL.
	 * @param	string $name					The name of the URL.
	 * @param	string $action					The action to perform.
	 * @param	string[optional] $pageOk		URL to call when unsubscribe was successful.
	 * @param	string[optional] $messageOk		Message to display when unsubscribe was successful.
	 * @param	string[optional] $pageError		URL to call when unsubscribe was unsuccessful.
	 * @param	string[optional] $messageError	Message to display when unsubscribe was unsuccessful.
	 */
	public function createActionUrl($messageId, $name, $action, $pageOk = null, $messageOk = null, $pageError = null, $messageError = null)
	{
		// build parameters
		$parameters = array();
		$parameters['messageId'] = (string) $messageId;
		$parameters['name'] = (string) $name;
		$parameters['action'] = (string) $action;
		if($pageOk !== null) $parameters['pageOK'] = (string) $pageOk;
		if($messageOk !== null) $parameters['messageOK'] = (string) $messageOk;
		if($pageError !== null) $parameters['pageError'] = (string) $pageError;
		if($messageError !== null) $parameters['messageError'] = (string) $messageError;

		// make the call
		return $this->doCall('createActionUrl', $parameters);
	}


	/**
	 * Scans your message from top to bottom and replaces the first occirrence of &&& with [EMV LINK]ORDER[EMV /LINK] (where ORDER is the action link order number).
	 *
	 * @return									The order number of the URL.
	 * @param	string $messageId				The ID of the message to which to add a URL.
	 * @param	string $name					The name of the URL.
	 * @param	string $action					The action to perform.
	 * @param	string[optional] $pageOk		URL to call when unsubscribe was successful.
	 * @param	string[optional] $messageOk		Message to display when unsubscribe was successful.
	 * @param	string[optional] $pageError		URL to call when unsubscribe was unsuccessful.
	 * @param	string[optional] $messageError	Message to display when unsubscribe was unsuccessful.
	 */
	public function createdAndAddActionUrl($messageId, $name, $action, $pageOk = null, $messageOk = null, $pageError = null, $messageError = null)
	{
		// build parameters
		$parameters = array();
		$parameters['messageId'] = (string) $messageId;
		$parameters['name'] = (string) $name;
		$parameters['action'] = (string) $action;
		if($pageOk !== null) $parameters['pageOK'] = (string) $pageOk;
		if($messageOk !== null) $parameters['messageOK'] = (string) $messageOk;
		if($pageError !== null) $parameters['pageError'] = (string) $pageError;
		if($messageError !== null) $parameters['messageError'] = (string) $messageError;

		// make the call
		return $this->doCall('createdAndAddActionUrl', $parameters);
	}


	/**
	 * Creates a mirror URL for an email.
	 *
	 * @return	string				The order number of the url.
	 * @param	string $messageId	ID of the message.
	 * @param	string $name		Name of the URL.
	 */
	public function createMirrorUrl($messageId, $name)
	{
		// build parameters
		$parameters = array();
		$parameters['messageId'] = (string) $messageId;
		$parameters['name'] = (string) $name;

		// make the call
		return $this->doCall('createMirrorUrl', $parameters);
	}


	/**
	 * Scans your message from top to bottom and automatically replaces the first occurrence of &&& with [EMV LINK]ORDER[EMV /LINK] (where ORDER is the mirror link order number).
	 *
	 * @return	string				The order number of the url.
	 * @param	string $messageId	ID of the message.
	 * @param	string $name		Name of the URL.
	 */
	public function createAndAddMirrorUrl($messageId, $name)
	{
		// build parameters
		$parameters = array();
		$parameters['messageId'] = (string) $messageId;
		$parameters['name'] = (string) $name;

		// make the call
		return $this->doCall('createAndAddMirrorUrl', $parameters);
	}


	/**
	 * Scans your message from top to bottom and automatically replaces the first occurrence of &&& with [EMV SHARE lang=xx] (where xx is the language identifier).
	 *
	 * @return	bool
	 * @param	string $messageId				The ID of the message.
	 * @param	bool $linkType					The link type, true for link, false for button.
	 * @param	string[optional] $buttonUrl		The URL of the sharebutton.
	 * @param	string[optional] $language		The language, possible values are: us, en, fr, de, nl, es, ru, sv, it, cn, tw, pt, br, da, ja, ko.
	 */
	public function addShareLink($messageId, $linkType, $buttonUrl = null, $language = null)
	{
		// @todo	validate
		// build parameters
		$parameters = array();
		$parameters['messageId'] = (string) $messageId;
		$parameters['linkType'] = (bool) $linkType;
		if($buttonUrl !== null) $parameters['buttonUrl'] = (string) $buttonUrl;
		if($language !== null) $parameters['language'] = (string) $language;

		// make the call
		return $this->doCall('addShareLink', $parameters);
	}


	/**
	 * Update an URL by field.
	 *
	 * @return	bool				true if the update was successful.
	 * @param	string $messageId	ID of the message.
	 * @param	int $order			Order of the URL.
	 * @param	string $field		Field to update.
	 * @param	mixed $value		Value to set.
	 */
	public function updateUrlByField($messageId, $order, $field, $value)
	{
		// build parameters
		$parameters = array();
		$parameters['messageId'] = (string) $messageId;
		$parameters['order'] = (int) $order;
		$parameters['field'] = (string) $field;
		$parameters['value'] = $value;

		// make the call
		return $this->doCall('updateUrlByField', $parameters);
	}


	/**
	 * Delete an URL.
	 *
	 * @return	bool				true if the delete was successful.
	 * @param	string $messageId	ID of the message.
	 * @param	int $order			Order of the URL.
	 */
	public function deleteUrl($messageId, $order)
	{
		// build parameters
		$parameters = array();
		$parameters['messageId'] = (string) $messageId;
		$parameters['order'] = (int) $order;

		// make the call
		return $this->doCall('deleteUrl', $parameters);
	}


	/**
	 * Get an URL by his order
	 *
	 * @return	array				The URL parameters.
	 * @param	string $messageId	ID of the message.
	 * @param	int $order			Order of the URL.
	 */
	public function getUrlByOrder($messageId, $order)
	{
		// build parameters
		$parameters = array();
		$parameters['messageId'] = (string) $messageId;
		$parameters['order'] = (int) $order;

		// make the call
		return $this->doCall('getUrlByOrder', $parameters);
	}


// segment methods
	public function segmentationCreateSegment()
	{
		throw new CampaignCommanderException('Not implemented', 500);
	}


	public function segmentationDeleteSegment()
	{
		throw new CampaignCommanderException('Not implemented', 500);
	}


	public function segmentationAddStringDemographicCriteriaByObj()
	{
		throw new CampaignCommanderException('Not implemented', 500);
	}


	public function segmentationAddNumericDemographicCriteriaByObj()
	{
		throw new CampaignCommanderException('Not implemented', 500);
	}


	public function segmentationAddDateDemographicCriteriaByObj()
	{
		throw new CampaignCommanderException('Not implemented', 500);
	}


	public function segmentationAddCampaignActionCriteriaByObj()
	{
		throw new CampaignCommanderException('Not implemented', 500);
	}


	public function segmentationAddCampaignTrackableLinkCriteriaByObj()
	{
		throw new CampaignCommanderException('Not implemented', 500);
	}


	public function segmentationAddSerieActionCriteriaByObj()
	{
		throw new CampaignCommanderException('Not implemented', 500);
	}


	public function segmentationAddSerieTrackableLinkCriteriaByObj()
	{
		throw new CampaignCommanderException('Not implemented', 500);
	}


	public function segmentationAddSocialNetworkCriteriaByObj()
	{
		throw new CampaignCommanderException('Not implemented', 500);
	}


	public function segmentationAddRecencyCriteriaByObj()
	{
		throw new CampaignCommanderException('Not implemented', 500);
	}


	public function segmentationAddDataMartCriteriaByObj()
	{
		throw new CampaignCommanderException('Not implemented', 500);
	}


	public function segmentationGetSegmentById()
	{
		throw new CampaignCommanderException('Not implemented', 500);
	}


	public function segmentationGetSegmentList()
	{
		throw new CampaignCommanderException('Not implemented', 500);
	}


	public function segmentationGetSegmentCriterias()
	{
		throw new CampaignCommanderException('Not implemented', 500);
	}


	public function segmentationGetPersoFragList()
	{
		throw new CampaignCommanderException('Not implemented', 500);
	}


	public function segmentationDeleteCriteria()
	{
		throw new CampaignCommanderException('Not implemented', 500);
	}


	public function segmentationUpdateSegment()
	{
		throw new CampaignCommanderException('Not implemented', 500);
	}


	public function segmentationUpdateStringDemographicCriteriaByObj()
	{
		throw new CampaignCommanderException('Not implemented', 500);
	}


	public function segmentationUpdateNumericDemographicCriteriaByObj()
	{
		throw new CampaignCommanderException('Not implemented', 500);
	}


	public function segmentationUpdateDateDemographicCriteriaByObj()
	{
		throw new CampaignCommanderException('Not implemented', 500);
	}


	public function segmentationUpdateCampaignActionCriteriaByObj()
	{
		throw new CampaignCommanderException('Not implemented', 500);
	}


	public function segmentationUpdateCampaignTrackableLinkCriteriaByObj()
	{
		throw new CampaignCommanderException('Not implemented', 500);
	}


	public function segmentationUpdateSerieActionCriteriaByObj()
	{
		throw new CampaignCommanderException('Not implemented', 500);
	}


	public function segmentationUpdateSerieTrackableLinkCriteriaByObj()
	{
		throw new CampaignCommanderException('Not implemented', 500);
	}


	public function segmentationUpdateSocialNetworkCriteriaByObj()
	{
		throw new CampaignCommanderException('Not implemented', 500);
	}


	public function segmentationUpdateRecencyCriteriaByObj()
	{
		throw new CampaignCommanderException('Not implemented', 500);
	}


	public function segmentationUpdateDataMartCriteriaByObj()
	{
		throw new CampaignCommanderException('Not implemented', 500);
	}


	public function segmentationCount()
	{
		throw new CampaignCommanderException('Not implemented', 500);
	}


	public function segmentationDistinctCount()
	{
		throw new CampaignCommanderException('Not implemented', 500);
	}

// campaign methods
	/**
	 * Create a campaign.
	 *
	 * @return	string								The ID of the campaign.
	 * @param	string $name						Name of the campaign.
	 * @param	int $sendDate						Date for the campaign to be scheduled.
	 * @param	string $messageId					Id of the message to send.
	 * @param	string $mailingListId				Id of the mailing list to be send the campaign to.
	 * @param	string[optional] $description		The description.
	 * @param	bool[optional] $notifProgress		Should you be notified of the progress of the campaign by email.
	 * @param	bool[optional] $postClickTracking	Use post click tracking?
	 * @param	bool[optional] $emaildedupfig		Deduplicate the mailing list?
	 */
	public function createCampaign($name, $sendDate, $messageId, $mailingListId, $description = null, $notifProgress = false, $postClickTracking = false, $emaildedupfig = false)
	{
		// build parameters
		$parameters = array();
		$parameters['name'] = (string) $name;
		if($description !== null) $parameters['desc'] = (string) $description;
		$parameters['sendDate'] = date('Y-m-d H:i:s', (int) $sendingDate);
		$parameters['messageId'] = (string) $messageId;
		$parameters['mailingListId'] = (string) $mailingListId;
		$parameters['notifProgress'] = (bool) $notifProgress;
		$parameters['postClickTracking'] = (bool) $postClickTracking;
		$parameters['emaildedupflg'] = (bool) $emaildedupfig;

		// make the call
		return $this->doCall('createCampaign', $parameters);
	}


	/**
	 * Create a campaign.
	 *
	 * @return	string								The ID of the campaign.
	 * @param	string $name						Name of the campaign.
	 * @param	int $sendDate						Date for the campaign to be scheduled.
	 * @param	string $messageId					Id of the message to send.
	 * @param	string $mailingListId				Id of the mailing list to be send the campaign to.
	 * @param	string[optional] $description		The description.
	 * @param	bool[optional] $notifProgress		Should you be notified of the progress of the campaign by email.
	 * @param	bool[optional] $postClickTracking	Use post click tracking?
	 * @param	bool[optional] $emaildedupfig		Deduplicate the mailing list?
	 */
	public function createCampaignWithAnalytics($name, $sendDate, $messageId, $mailingListId, $description = null, $notifProgress = false, $postClickTracking = false, $emaildedupfig = false)
	{
		// build parameters
		$parameters = array();
		$parameters['name'] = (string) $name;
		if($description !== null) $parameters['desc'] = (string) $description;
		$parameters['sendDate'] = date('Y-m-d H:i:s', (int) $sendingDate);
		$parameters['messageId'] = (string) $messageId;
		$parameters['mailingListId'] = (string) $mailingListId;
		$parameters['notifProgress'] = (bool) $notifProgress;
		$parameters['postClickTracking'] = (bool) $postClickTracking;
		$parameters['emaildedupflg'] = (bool) $emaildedupfig;

		// make the call
		return $this->doCall('createCampaignWithAnalytics', $parameters);
	}


	/**
	 * Create a campaign.
	 *
	 * @return	string				The ID of the campaign.
	 * @param	array $campaign		The campaign object.
	 */
	public function createCampaignByObj(array $campaign)
	{
		throw new CampaignCommanderException('Not implemented', 500);
	}


	/**
	 * Delete a campaign.
	 *
	 * @return	bool			true if delete was successful.
	 * @param	string $id		The ID of the campaign.
	 */
	public function deleteCampaign($id)
	{
		throw new CampaignCommanderException('Not implemented', 500);
	}


	/**
	 * Update a campaign.
	 *
	 * @return	bool				true of update was successful.
	 * @param	string $id			The ID of the campaign.
	 * @param	string $field		Field to update.
	 * @param	string $value		Value to set.
	 */
	public function updateCampaign($id, $field, $value)
	{
		throw new CampaignCommanderException('Not implemented', 500);
	}


	/**
	 * Update a campaign.
	 *
	 * @return	bool				true if the update was successful.
	 * @param	array $campaign		The campaign object.
	 */
	public function updateCampaignByObj(array $campaign)
	{
		throw new CampaignCommanderException('Not implemented', 500);
	}


	/**
	 *  Post a campaign.
	 *
	 * @return	bool			true if post was successful.
	 * @param	string $id		The ID of the campaign.
	 */
	public function postCampaign($id)
	{
		throw new CampaignCommanderException('Not implemented', 500);
	}


	/**
	 * Unpost a campaign.
	 *
	 * @return	bool			true if unpost was successful.
	 * @param	string $id		The ID of the campaign.
	 */
	public function unpostCampaign($id)
	{
		throw new CampaignCommanderException('Not implemented', 500);
	}


	/**
	 * Get a campign.
	 *
	 * @return	array			The campaign parameters.
	 * @param	string $id		The ID of the campaign.
	 */
	public function getCampaign($id)
	{
		throw new CampaignCommanderException('Not implemented', 500);
	}


	/**
	 * Get campaigns by field.
	 *
	 * @return	array			List of IDS of campaigns matching the search.
	 * @param	string $field	Field to update.
	 * @param	string $value	Value to set in that field.
	 * @param	string $limit	Maximum number of elements to retrieve.
	 */
	public function getCampaignsByField($field, $value, $limit)
	{
		throw new CampaignCommanderException('Not implemented', 500);
	}


	public static function getCampaignsByStatus()
	{

	}


	public static function getCampaignsByPeriod()
	{

	}


	/**
	 * Get the status for a campaign.
	 *
	 * @return	string			Status of the campaign.
	 * @param	string $id		The ID of the campaign.
	 */
	public function getCampaignStatus($id)
	{
		throw new CampaignCommanderException('Not implemented', 500);
	}


	/**
	 * Get last campaigns
	 *
	 * @return	array
	 * @param	int $limit		Maximum number of campaigns to retrieve.
	 */
	public function getLastCampaigns($limit)
	{
		throw new CampaignCommanderException('Not implemented', 500);
	}


	public function testCampaignByGroup()
	{
		throw new CampaignCommanderException('Not implemented', 500);
	}


	public function testCampaignByMember()
	{
		throw new CampaignCommanderException('Not implemented', 500);
	}


	public function pauseCampaign()
	{
		throw new CampaignCommanderException('Not implemented', 500);
	}


	public function unpauseCampaign()
	{
		throw new CampaignCommanderException('Not implemented', 500);
	}


	public function getCampaignSnapshotReport()
	{
		throw new CampaignCommanderException('Not implemented', 500);
	}


// banner methods
	public function createBanner()
	{
		throw new CampaignCommanderException('Not implemented', 500);
	}


	public function createBannerByObj()
	{
		throw new CampaignCommanderException('Not implemented', 500);
	}


	public function deleteBanner()
	{
		throw new CampaignCommanderException('Not implemented', 500);
	}


	public function updateBanner()
	{
		throw new CampaignCommanderException('Not implemented', 500);
	}


	public function updateBannerByObj()
	{
		throw new CampaignCommanderException('Not implemented', 500);
	}


	public function cloneBanner()
	{
		throw new CampaignCommanderException('Not implemented', 500);
	}


	public function getBannerPreview()
	{
		throw new CampaignCommanderException('Not implemented', 500);
	}


	public function getBanner()
	{
		throw new CampaignCommanderException('Not implemented', 500);
	}


	public function getBannersByField()
	{
		throw new CampaignCommanderException('Not implemented', 500);
	}


	public function getBannersByPeriod()
	{
		throw new CampaignCommanderException('Not implemented', 500);
	}


	public function getLastBanners()
	{
		throw new CampaignCommanderException('Not implemented', 500);
	}


	public function trackAllBannerLinks()
	{
		throw new CampaignCommanderException('Not implemented', 500);
	}


	public function untrackAllBannerLinks()
	{
		throw new CampaignCommanderException('Not implemented', 500);
	}


	public function trackBannerLinkByPosition()
	{
		throw new CampaignCommanderException('Not implemented', 500);
	}


	public function  untrackBannerLinkByOrder()
	{
		throw new CampaignCommanderException('Not implemented', 500);
	}


	public function getAllBannerTrackedLinks()
	{
		throw new CampaignCommanderException('Not implemented', 500);
	}


	public function getAllUnusedBannerTrackedLinks()
	{
		throw new CampaignCommanderException('Not implemented', 500);
	}


	public function getAllBannerTrackableLinks()
	{
		throw new CampaignCommanderException('Not implemented', 500);
	}




// banner link management methods
	public function createStandardBannerLink()
	{
		throw new CampaignCommanderException('Not implemented', 500);
	}


	public function createAndAddStandardBannerLink()
	{
		throw new CampaignCommanderException('Not implemented', 500);
	}


	public function createUnsubscribeBannerLink()
	{
		throw new CampaignCommanderException('Not implemented', 500);
	}


	public function createAndAddUnsubscribeBannerLink()
	{
		throw new CampaignCommanderException('Not implemented', 500);
	}


	public function createPersonalisedBannerLink()
	{
		throw new CampaignCommanderException('Not implemented', 500);
	}


	public function createAndAddPersonalisedBannerLink()
	{
		throw new CampaignCommanderException('Not implemented', 500);
	}


	public function createUpdateBannerLink()
	{
		throw new CampaignCommanderException('Not implemented', 500);
	}


	public function createAndAddUpdateBannerLink()
	{
		throw new CampaignCommanderException('Not implemented', 500);
	}


	public function createActionBannerLink()
	{
		throw new CampaignCommanderException('Not implemented', 500);
	}


	public function createAndAddActionBannerLink()
	{
		throw new CampaignCommanderException('Not implemented', 500);
	}


	public function createMirrorBannerLink()
	{
		throw new CampaignCommanderException('Not implemented', 500);
	}


	public function createAndAddMirrorBannerLink()
	{
		throw new CampaignCommanderException('Not implemented', 500);
	}


	public function updateBannerLinkByField()
	{
		throw new CampaignCommanderException('Not implemented', 500);
	}


	public function getBannerLinkByOrder()
	{
		throw new CampaignCommanderException('Not implemented', 500);
	}


// test group methods
	/**
	 * Creates a test group of members.
	 *
	 * @return	string			The ID of the newly created test group.
	 * @param	string $name	The name of the test group.
	 */
	public function createTestGroup($name)
	{
		// build parameters
		$parameters = array();
		$parameters['Name'] = (string) $name;

		// make the call
		return $this->doCall('createTestGroup', $parameters);
	}


	/**
	 * Creates a test group.
	 *
	 * @return	string				The ID of the created test group.
	 * @param	array $testGroup	The test group object.
	 */
	public function createTestGroupByObj(array $testGroup)
	{
		// build parameters
		$parameters = array();
		$parameters['testGroup'] = $testGroup;

		// make the call
		return $this->doCall('createTestGroupByObj', $parameters);
	}


	/**
	 * Adds a member to a test group.
	 *
	 * @return	bool				true if it was successfull, false otherwise.
	 * @param	string $memberId	The ID of the member to add.
	 * @param	string $groupId		The ID of the group to which to add the member.
	 */
	public function addTestMember($memberId, $groupId)
	{
		// build parameters
		$parameters = array();
		$parameters['memberId'] = (string) $memberId;
		$parameters['groupId'] = (string) $groupId;

		// make the call
		return $this->doCall('addTestMember', $parameters);
	}


	/**
	 * Removes a member from a test group
	 *
	 * @return	bool				true if it was successfull, false otherwise.
	 * @param	string $memberId	The ID of the member to add.
	 * @param	string $groupId		The ID of the group to which to add the member.
	 */
	public function removeTestMember($memberId, $groupId)
	{
		// build parameters
		$parameters = array();
		$parameters['memberId'] = (string) $memberId;
		$parameters['groupId'] = (string) $groupId;

		// make the call
		return $this->doCall('removeTestMember', $parameters);
	}


	/**
	 * Deletes a test group.
	 *
	 * @return	bool				true if it was successfull, false otherwise.
	 * @param	string $groupId		The ID of the group to which to add the member.
	 */
	public function deleteTestGroup($groupId)
	{
		// build parameters
		$parameters = array();
		$parameters['groupId'] = (string) $groupId;

		// make the call
		return $this->doCall('deleteTestGroup', $parameters);
	}


	/**
	 * Updates a test group.
	 *
	 * @return	bool				true if it was successfull, false otherwise.
	 * @param	array $testGroup	The test group object.
	 */
	public function updateTestGroupByObj(array $testGroup)
	{
		// build parameters
		$parameters = array();
		$parameters['testGroup'] = $testGroup;

		// make the call
		return $this->doCall('updateTestGroupByObj', $parameters);
	}


	/**
	 * Retrieves the list of members in a test group.
	 *
	 * @return	array				The list of member ID's in that group
	 * @param	string $groupId		The ID fo the group.
	 */
	public function getTestGroup($groupId)
	{
		// build parameters
		$parameters = array();
		$parameters['groupId'] = (string) $groupId;

		// make the call
		return $this->doCall('getTestGroup', $parameters);
	}


	/**
	 * Retrieves a list of test groups.
	 *
	 * @return	array	The list of groups IDs.
	 */
	public function getClientTestGroups()
	{
		// make the call
		return $this->doCall('getClientTestGroups');
	}
}


/**
 * Campaign Commander Exception class
 *
 * @author	Tijs Verkoyen <php-campaign-commander-member@verkoyen.eu>
 */
class CampaignCommanderException extends Exception
{
}

?>