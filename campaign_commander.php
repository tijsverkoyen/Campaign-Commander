<?php

/**
 * Campaign Commander class
 *
 * This source file can be used to communicate with Campaign Commander (http://campaigncommander.com)
 *
 * The class is documented in the file itself. If you find any bugs help me out and report them. Reporting can be done by sending an email to php-campaign-commander-member-bugs[at]verkoyen[dot]eu.
 * If you report a bug, make sure you give me enough information (include your code).
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
 * @version			1.0.0
 *
 * @copyright		Copyright (c), Tijs Verkoyen. All rights reserved.
 * @license			BSD License
 */
class CampaignCommander
{
	// internal constant to enable/disable debugging
	const DEBUG = false;

	// URL for the api
	const WSDL_URL = 'http://emvapi.emv3.com/apiccmd/services/CcmdService?wsdl';

	// current version
	const VERSION = '1.0.0';


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
	public function __construct($login, $password, $key)
	{
		$this->setLogin($login);
		$this->setPassword($password);
		$this->setKey($key);
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
			$this->soapClient = new SoapClient(self::WSDL_URL, $options);

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
	 * @param	string $desc						Description of the message.
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
	public function createEmailMessage($name, $desc, $subject, $from, $fromEmail, $to, $body, $encoding, $replyTo, $replyToEmail, $bounceback = false, $unsubscribe = false, $unsublinkpage = null)
	{
		// build member-object
		$parameters['name'] = (string) $name;
		$parameters['desc'] = (string) $desc;
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
		throw new CampaignCommanderException('Not implemented', 500);
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
	public function createSMSMessage($name, $desc, $from, $body)
	{
		throw new CampaignCommanderException('Not implemented', 500);
	}


	/**
	 * Create SMS-message.
	 *
	 * @return	string				The message ID.
	 * @param	array $message		The message object.
	 */
	public function createSmsMessageByObj(array $message)
	{
		throw new CampaignCommanderException('Not implemented', 500);
	}


	/**
	 * Delete message.
	 *
	 * @return	bool			true if delete was successful.
	 * @param	string $id		ID of the message.
	 */
	public function deleteMessage($id)
	{
		throw new CampaignCommanderException('Not implemented', 500);
	}


	/**
	 * Update message.
	 *
	 * @return	bool			true if the update was successful.
	 * @param	string $id		ID of the message.
	 * @param	string $field	The field to update.
	 * @param	string $value	The value to set.
	 */
	public function updateMessage($id, $field, $value)
	{
		throw new CampaignCommanderException('Not implemented', 500);
	}


	/**
	 * Update email-message.
	 *
	 * @return	bool				true if the update was successful.
	 * @param	array $message		The message object.
	 */
	public function updateEmailMessageByObj(array $message)
	{
		throw new CampaignCommanderException('Not implemented', 500);
	}


	/**
	 * Clone message.
	 *
	 * @return	string				ID of the newly created message.
	 * @param	string $id			ID of the message.
	 * @param	string $newName		Name of the newly created message.
	 */
	public function cloneMessage($id, $newName)
	{
		throw new CampaignCommanderException('Not implemented', 500);
	}


	/**
	 * Get message.
	 *
	 * @return	array			The message object.
	 * @param	string $id		ID of the message.
	 */
	public function getMessage($id)
	{
		$parameters['id'] = (string) $id;

		return (array) $this->doCall('getMessage', $parameters);
	}


	/**
	 * Get last email-messages.
	 *
	 * @return	array			IDs of messages.
	 * @param	string $limit	Maximum number of messages to retrieve.
	 */
	public function getLastEmailMessages($limit)
	{
		$parameters['limit'] = (int) $limit;

		return (array) $this->doCall('getLastEmailMessages', $parameters);
	}


	/**
	 * Get last SMS-messages.
	 *
	 * @return	array			IDs of messages.
	 * @param	string $limit	Maximum number of messages to retrieve.
	 */
	public function getLastSmsMessages($limit)
	{
		$parameters['limit'] = (int) $limit;

		return (array) $this->doCall('getLastSmsMessages', $parameters);
	}


	/**
	 * Get email-messages by field.
	 *
	 * @return	array			IDs of messages matching the search.
	 * @param	string $field	Field to search.
	 * @param	string $value	Value to search.
	 */
	public function getEmailMessagesByField($field, $value)
	{
		throw new CampaignCommanderException('Not implemented', 500);
	}


	/**
	 * Get SMS-messages by field.
	 *
	 * @return	array				IDs of messages matching the search.
	 * @param	string $field		Field to search.
	 * @param	string $value		Value to search.
	 * @param	string $limit		Maximum number of messages to retrieve.
	 */
	public function getSmsMessagesByField($field, $value, $limit)
	{
		throw new CampaignCommanderException('Not implemented', 500);
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
		$parameters['dateBegin'] = date('Y-m-d H:i:s', (int) $dateBegin);
		$parameters['dateEnd'] = date('Y-m-d H:i:s', (int) $dateEnd);

		return (array) $this->doCall('getMessagesByPeriod', $parameters);
	}


	/**
	 * Get email-message preview.
	 *
	 * @return	array				Preview of the message.
	 * @param	string $messageId	ID of the message.
	 * @param	string $part		Part of the message to preview (HTML or text).
	 */
	public function getEmailMessagePreview($messageId, $part)
	{
		throw new CampaignCommanderException('Not implemented', 500);
	}


	/**
	 * Get SMS-message preview.
	 *
	 * @return	string				Preview of the SMS-message.
	 * @param	string $messageId	ID of the message.
	 */
	public function getSmsMessagePreview($messageId)
	{
		throw new CampaignCommanderException('Not implemented', 500);
	}


	/**
	 * Track all links.
	 *
	 * @return	array
	 * @param	string $id		ID of the message.
	 */
	public function trackAllLinks($id)
	{
		throw new CampaignCommanderException('Not implemented', 500);
	}


	/**
	 * Untrack all links.
	 *
	 * @return	bool			true if the untrack operation was successful.
	 * @param	string $id		ID of the message.
	 */
	public function untrackAllLinks($id)
	{
		throw new CampaignCommanderException('Not implemented', 500);
	}


	/**
	 * Track link by position.
	 *
	 * @return	array				Link order.
	 * @param	string $id			ID of the message.
	 * @param	string $position	Position of the link to update in the message.
	 * @param	string $part		HTML or text.
	 */
	public function trackLinkByPosition($id, $position, $part)
	{
		throw new CampaignCommanderException('Not implemented', 500);
	}


	/**
	 * Get all links.
	 *
	 * @return	array			List of IDs of the links.
	 * @param	string $id		ID of the message.
	 */
	public function getAllLinks($id)
	{
		throw new CampaignCommanderException('Not implemented', 500);
	}


	/**
	 * Get all tracked links.
	 *
	 * @return	array			List of IDs of the tracked links.
	 * @param	string $id		ID of the message.
	 */
	public function getAllTrackedLinks($id)
	{
		throw new CampaignCommanderException('Not implemented', 500);
	}


	/**
	 * Get all unused tracked links.
	 *
	 * @return	array			List of IDs of the unused tracked links.
	 * @param	string $id		ID of the message.
	 */
	public function getAllUnusedTrackedLinks($id)
	{
		throw new CampaignCommanderException('Not implemented', 500);
	}


	/**
	 * Get all trackable links.
	 *
	 * @return	array			List of IDs of the trackable links.
	 * @param	string $id		ID of the message.
	 */
	public function getAllTrackableLinks($id)
	{
		throw new CampaignCommanderException('Not implemented', 500);
	}


// segment methods
	/**
	 * Create basic segment.
	 *
	 * @return	string							The ID of the created segment.
	 * @param	string $name					Name of the segment.
	 * @param	string[optional] $desc			Description of the segment.
	 * @param	string[optional] $criteria		Criteria in Natural Language to select members.
	 */
	public function createBasicSegment($name, $desc = null, $criteria = null)
	{
		throw new CampaignCommanderException('Not implemented', 500);
	}


	/**
	 * Create basic segment.
	 *
	 * @return	string			The ID of the created segment.
	 * @param	array $segment	The segment object.
	 */
	public function createBasicSegmentByObj(array $segment)
	{
		throw new CampaignCommanderException('Not implemented', 500);
	}


	/**
	 * Get segment
	 *
	 * @return	array			The segment object
	 * @param	string $id		ID of the segment.
	 */
	public function getSegment($id)
	{
		$parameters['id'] = (string) $id;

		return (array) $this->doCall('getSegment', $parameters);
	}


	/**
	 * Create combined segment.
	 *
	 * @return	string				ID of the created segment.
	 * @param	string $name		Name of the combined segment.
	 * @param	string $desc		Description of the new segment.
	 * @param	string $segment1	ID of the first segment.
	 * @param	string $segment2	ID of teh second segment.
	 * @param	string $operartor	Operators to combine the two segments, possible values are: AND, OR.
	 */
	public function createCombinedSegment($name, $desc, $segment1, $segment2, $operartor)
	{
		throw new CampaignCommanderException('Not implemented', 500);
	}


	/**
	 * Delete a segment.
	 *
	 * @return	bool			true if the delete operation was successful.
	 * @param	string $id		ID of the segment.
	 */
	public function deleteSegment($id)
	{
		throw new CampaignCommanderException('Not implemented', 500);
	}


	/**
	 * Update a segment.
	 *
	 * @return	bool			true if the update was successful.
	 * @param	string $id		ID of the segment.
	 * @param	string $field	The field to update.
	 * @param	string $value	Th value to set.
	 */
	public function updateSegment($id, $field, $value)
	{
		throw new CampaignCommanderException('Not implemented', 500);
	}


	/**
	 * Get last segments.
	 *
	 * @return	array			List of segment IDs.
	 * @param	string $limit	Maximum number of segment IDs to return.
	 */
	public function getLastSegments($limit)
	{
		$parameters['limit'] = (int) $limit;

		return (array) $this->doCall('getLastSegments', $parameters);
	}


	/**
	 * Get segments by field.
	 *
	 * @return	array				List of segment IDs.
	 * @param	string $field		Name of the field to search.
	 * @param	string $value		Value of the field to search.
	 * @param	string $limit		Max number of segment ID's to return.
	 */
	public function getSegmentsByField($field, $value, $limit)
	{
		throw new CampaignCommanderException('Not implemented', 500);
	}


	/**
	 * Member count.
	 *
	 * @return	int				Number of members in the segment.
	 * @param	string $id		ID of the segment.
	 */
	public function membersCount($id)
	{
		// build member-object
		$parameters['id'] = $id;

		// make the call
		return (int) $this->doCall('membersCount', $parameters);
	}


	/**
	 * Distinct member count.
	 *
	 * @return	int				Distinct member count of the segment.
	 * @param	string $id		ID of the segment.
	 */
	public function distinctMembersCount($id)
	{
		// build member-object
		$parameters['id'] = $id;

		// make the call
		return (int) $this->doCall('mailingListDistinctCount', $parameters);
	}


	/**
	 * Update a segment.
	 *
	 * @return	bool				true if successfull.
	 * @param	array $segment		The segment object.
	 */
	public function updateSegmentByObj($segment)
	{
		throw new CampaignCommanderException('Not implemented', 500);
	}


// mailing list methods
	/**
	 * Create a mailingList.
	 *
	 * @return	string							The ID of the created mailingList.
	 * @param	string $name					The name of the mailingList.
	 * @param	string $desc					A description for the mailingList.
	 * @param	string[optional] $segmentID		ID of the segment to associate to the mailingList.
	 */
	public function createMailingList($name, $desc, $segmentID = null)
	{
		throw new CampaignCommanderException('Not implemented', 500);
	}


	/**
	 * Create a mailingList.
	 *
	 * @return	string					The ID of the created mailingList.
	 * @param	array $mailingList		The mailingList object.
	 */
	public function createMailingListByObj(array $mailingList)
	{
		throw new CampaignCommanderException('Not implemented', 500);
	}


	/**
	 * Update a mailingList.
	 *
	 * @return	bool					true if the update was successful.
	 * @param	array $mailingList		The mailing list object.
	 */
	public function updateMailingListByObj(array $mailingList)
	{
		throw new CampaignCommanderException('Not implemented', 500);
	}


	/**
	 * Get a mailingList
	 *
	 * @return	array			The mailingList
	 * @param	string $id		The ID of the mailingList.
	 */
	public function getMailingList($id)
	{
		throw new CampaignCommanderException('Not implemented', 500);
	}


	/**
	 * MailingList count
	 *
	 * @return	int					Count fo the specified mailingList.
	 * @param	string $id			The ID of the mailingList.
	 */
	public function mailingListCount($id)
	{
		// build member-object
		$parameters['id'] = $id;

		// make the call
		return (int) $this->doCall('mailingListCount', $parameters);
	}


	/**
	 * MailingList distinct count.
	 *
	 * @return	int					Distinct count (without duplicates) of the specified mailingList.
	 * @param	string $id			The ID of the mailingList.
	 */
	public function mailingListDistinctCount($id)
	{
		throw new CampaignCommanderException('Not implemented', 500);
	}


	/**
	 * Delete a mailingList
	 *
	 * @return	bool				true if delete was successful.
	 * @param	string $id			The ID of the mailingList.
	 */
	public function deleteMailingList($id)
	{
		throw new CampaignCommanderException('Not implemented', 500);
	}


	/**
	 * Update a mailingList
	 *
	 * @return	bool				true if the update wass successful.
	 * @param	string $id			The ID of the mailingList.
	 * @param	string $field		Name of the field to update.
	 * @param	string $value		Value to set.
	 */
	public function updateMailingList($id, $field, $value)
	{
		throw new CampaignCommanderException('Not implemented', 500);
	}


	/**
	 * Clone a mailing list.
	 *
	 * @return	string				The ID of the newly created mailingList.
	 * @param	string $id			The ID of the mailingList.
	 * @param	string $name		Name of the newly created mailingList.
	 */
	public function cloneMailingList($id, $name)
	{
		throw new CampaignCommanderException('Not implemented', 500);
	}


	/**
	 * Get last mailing lists.
	 *
	 * @return	array			The IDs of the mailingLists.
	 * @param	string $limit	Number of mailingList ID's to retrieve (max 300).
	 */
	public function getLastMailingLists($limit)
	{
		throw new CampaignCommanderException('Not implemented', 500);
	}


	/**
	 * Get mailing lists by period.
	 *
	 * @return	array				The IDs of the mailingLists.
	 * @param	int $dateBegin		Begin data of the period to retrieve.
	 * @param	int $dateEnd		End date of the period to retrieve.
	 */
	public function getMailingListsByPeriod($dateBegin, $dateEnd)
	{
		throw new CampaignCommanderException('Not implemented', 500);
	}


	/**
	 * Get mailing list by field.
	 *
	 * @return	array				IDs of the retrieved mailinglist.
	 * @param	string $id			The ID of the mailingList.
	 * @param	string $field		Name of the field to search.
	 * @param	string $value		Value to search in the field.
	 */
	public function getMailingListsByField($id, $field, $value)
	{
		throw new CampaignCommanderException('Not implemented', 500);
	}


	/**
	 * Add a segment.
	 *
	 * @return	array				true if the segment was succesfully added.
	 * @param	string $id			The ID of the mailingList.
	 * @param	string $segmentId	ID of the segment.
	 */
	public function addSegment($id, $segmentId)
	{
		throw new CampaignCommanderException('Not implemented', 500);
	}


	/**
	 * Remove a segment.
	 *
	 * @return	bool				true if the segment was successfully removed.
	 * @param	string $id			The ID of the mailingList.
	 * @param	string $segmentId	ID of the segment.
	 */
	public function removeSegment($id, $segmentId)
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
		// build member-object
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


// URL methods
	/**
	 * Creates a standard URL.
	 *
	 * @return	string				ID of the created URL.
	 * @param	string $messageId	ID of the message.
	 * @param	string $name		Name of the URL.
	 * @param	string $url			URL to add.
	 */
	public function createStandardUrl($messageId, $name, $url)
	{
		throw new CampaignCommanderException('Not implemented', 500);
	}


	/**
	 * Creates an Unsubscribe URL.
	 *
	 * @return	string					ID of the created URL.
	 * @param	string $messageId		ID of the message.
	 * @param	string $name			Name of the URL.
	 * @param	string $pageOk			URL to call when unsubscribe was successful.
	 * @param	string $messageOk		Message to display when unsubscribe was successful.
	 * @param	string $pageError		URL to call when unsubscribe was unsuccessful.
	 * @param	string $messageError	Message to display when unsubscribe was unsuccessful.
	 */
	public function createUnsubscribeUrl($messageId, $name, $pageOk, $messageOk, $pageError, $messageError)
	{
		throw new CampaignCommanderException('Not implemented', 500);
	}


	/**
	 * Creates an personalised URL.
	 *
	 * @return	string				ID of the created URL.
	 * @param	string $messageId	ID of the message.
	 * @param	string $name		Name of the URL.
	 * @param	string $url			URL to add.
	 */
	public function createPersonalisedUrl($messageId, $name, $url)
	{
		throw new CampaignCommanderException('Not implemented', 500);
	}


	/**
	 * Creates an update URL.
	 *
	 * @return	string					ID of the created URL.
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
		throw new CampaignCommanderException('Not implemented', 500);
	}


	/**
	 * Creates a mirror URL
	 *
	 * @return	string				ID of the created URL.
	 * @param	string $messageId	ID of the message.
	 * @param	string $name		Name of the URL.
	 */
	public function createMirrorUrl($messageId, $name)
	{
		throw new CampaignCommanderException('Not implemented', 500);
	}


	/**
	 * Update an URL by field
	 *
	 * @return	bool				true if the update was successful.
	 * @param	string $messageId	ID of the message.
	 * @param	int $order			Order of the URL.
	 * @param	string $field		Field to update.
	 * @param	string $value		Value to set.
	 */
	public function updateUrlByField($messageId, $order, $field, $value)
	{
		throw new CampaignCommanderException('Not implemented', 500);
	}


	/**
	 * Delete an URL
	 *
	 * @return	bool				true if the delete was successful.
	 * @param	string $messageId	ID of the message.
	 * @param	int $order			Order of the URL.
	 */
	public function deleteUrl($messageId, $order)
	{
		throw new CampaignCommanderException('Not implemented', 500);
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
		throw new CampaignCommanderException('Not implemented', 500);
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