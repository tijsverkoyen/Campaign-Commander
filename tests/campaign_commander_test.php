<?php

require_once 'config.php';
require_once '../campaign_commander.php';

require_once 'PHPUnit/Framework/TestCase.php';

/**
 * CampaignCommander test case.
 */
class CampaignCommanderTest extends PHPUnit_Framework_TestCase
{

	/**
	 * The instance
	 * @var CampaignCommander
	 */
	private $campaignCommander;


	/**
	 * Prepares the environment before running a test.
	 */
	protected function setUp()
	{
		parent::setUp();

		$this->campaignCommander = new CampaignCommander(LOGIN, PASSWORD, KEY);
	}


	/**
	 * Cleans up the environment after running a test.
	 */
	protected function tearDown()
	{
		$this->campaignCommander = null;

		parent::tearDown();
	}


	/**
	 * Tests CampaignCommander->__construct()
	 */
	public function test__construct()
	{
		// TODO Auto-generated CampaignCommanderTest->test__construct()
		$this->markTestIncomplete("__construct test not implemented");

		$this->campaignCommander->__construct(/* parameters */);

	}


	/**
	 * Tests CampaignCommander->__destruct()
	 */
	public function test__destruct()
	{
		// TODO Auto-generated CampaignCommanderTest->test__destruct()
		$this->markTestIncomplete("__destruct test not implemented");

		$this->campaignCommander->__destruct(/* parameters */);

	}


	/**
	 * Tests CampaignCommander->getTimeOut()
	 */
	public function testGetTimeOut()
	{
		// TODO Auto-generated CampaignCommanderTest->testGetTimeOut()
		$this->markTestIncomplete("getTimeOut test not implemented");

		$this->campaignCommander->getTimeOut(/* parameters */);

	}


	/**
	 * Tests CampaignCommander->getUserAgent()
	 */
	public function testGetUserAgent()
	{
		// TODO Auto-generated CampaignCommanderTest->testGetUserAgent()
		$this->markTestIncomplete("getUserAgent test not implemented");

		$this->campaignCommander->getUserAgent(/* parameters */);

	}


	/**
	 * Tests CampaignCommander->setTimeOut()
	 */
	public function testSetTimeOut()
	{
		// TODO Auto-generated CampaignCommanderTest->testSetTimeOut()
		$this->markTestIncomplete("setTimeOut test not implemented");

		$this->campaignCommander->setTimeOut(/* parameters */);

	}


	/**
	 * Tests CampaignCommander->setUserAgent()
	 */
	public function testSetUserAgent()
	{
		// TODO Auto-generated CampaignCommanderTest->testSetUserAgent()
		$this->markTestIncomplete("setUserAgent test not implemented");

		$this->campaignCommander->setUserAgent(/* parameters */);

	}


	/**
	 * Tests CampaignCommander->closeApiConnection()
	 */
	public function testCloseApiConnection()
	{
		// TODO Auto-generated CampaignCommanderTest->testCloseApiConnection()
		$this->markTestIncomplete("closeApiConnection test not implemented");

		$this->campaignCommander->closeApiConnection(/* parameters */);

	}


	/**
	 * Tests CampaignCommander->createEmailMessage()
	 */
	public function testCreateEmailMessage()
	{
		// TODO Auto-generated CampaignCommanderTest->testCreateEmailMessage()
		$this->markTestIncomplete("createEmailMessage test not implemented");

		$this->campaignCommander->createEmailMessage(/* parameters */);

	}


	/**
	 * Tests CampaignCommander->createEmailMessageByObj()
	 */
	public function testCreateEmailMessageByObj()
	{
		// TODO Auto-generated CampaignCommanderTest->testCreateEmailMessageByObj()
		$this->markTestIncomplete("createEmailMessageByObj test not implemented");

		$this->campaignCommander->createEmailMessageByObj(/* parameters */);

	}


	/**
	 * Tests CampaignCommander->createSmsMessage()
	 */
	public function testCreateSmsMessage()
	{
		// TODO Auto-generated CampaignCommanderTest->testCreateSmsMessage()
		$this->markTestIncomplete("createSmsMessage test not implemented");

		$this->campaignCommander->createSmsMessage(/* parameters */);

	}


	/**
	 * Tests CampaignCommander->createSmsMessageByObj()
	 */
	public function testCreateSmsMessageByObj()
	{
		// TODO Auto-generated CampaignCommanderTest->testCreateSmsMessageByObj()
		$this->markTestIncomplete("createSmsMessageByObj test not implemented");

		$this->campaignCommander->createSmsMessageByObj(/* parameters */);

	}


	/**
	 * Tests CampaignCommander->deleteMessage()
	 */
	public function testDeleteMessage()
	{
		// TODO Auto-generated CampaignCommanderTest->testDeleteMessage()
		$this->markTestIncomplete("deleteMessage test not implemented");

		$this->campaignCommander->deleteMessage(/* parameters */);

	}


	/**
	 * Tests CampaignCommander->updateMessage()
	 */
	public function testUpdateMessage()
	{
		// TODO Auto-generated CampaignCommanderTest->testUpdateMessage()
		$this->markTestIncomplete("updateMessage test not implemented");

		$this->campaignCommander->updateMessage(/* parameters */);

	}


	/**
	 * Tests CampaignCommander->updateMessageByObj()
	 */
	public function testUpdateMessageByObj()
	{
		// TODO Auto-generated CampaignCommanderTest->testUpdateMessageByObj()
		$this->markTestIncomplete("updateMessageByObj test not implemented");

		$this->campaignCommander->updateMessageByObj(/* parameters */);

	}


	/**
	 * Tests CampaignCommander->cloneMessage()
	 */
	public function testCloneMessage()
	{
		// TODO Auto-generated CampaignCommanderTest->testCloneMessage()
		$this->markTestIncomplete("cloneMessage test not implemented");

		$this->campaignCommander->cloneMessage(/* parameters */);

	}


	/**
	 * Tests CampaignCommander->getMessage()
	 */
	public function testGetMessage()
	{
		$this->assertArrayHasKey('body', $this->campaignCommander->getMessage('1104992528'));

	}


	public function testGetLastEmailMessages()
	{
		$this->assertArrayHasKey(9, $this->campaignCommander->getLastEmailMessages(10));
	}


	/**
	 * Tests CampaignCommander->getLastSmsMessages()
	 */
	public function testGetLastSmsMessages()
	{
		$this->assertArrayHasKey(0, $this->campaignCommander->getLastEmailMessages(10));
	}


	/**
	 * Tests CampaignCommander->getEmailMessagesByField()
	 */
	public function testGetEmailMessagesByField()
	{
		$this->assertType('array', $this->campaignCommander->getEmailMessagesByField('from', 'Capitole Gent', 10));
	}


	/**
	 * Tests CampaignCommander->getSmsMessagesByField()
	 */
	public function testGetSmsMessagesByField()
	{
		// TODO Auto-generated CampaignCommanderTest->testGetSmsMessagesByField()
		$this->markTestIncomplete("getSmsMessagesByField test not implemented");

		$this->campaignCommander->getSmsMessagesByField(/* parameters */);
	}


	/**
	 * Tests CampaignCommander->getMessagesByPeriod()
	 */
	public function testGetMessagesByPeriod()
	{
		// TODO Auto-generated CampaignCommanderTest->testGetMessagesByPeriod()
		$this->markTestIncomplete("getMessagesByPeriod test not implemented");

		$this->assertType('array', $this->campaignCommander->getMessagesByPeriod(mktime(00, 00, 00, 01, 01, 2010), mktime(23, 59, 59, 12, 31, 2010)));

	}


	/**
	 * Tests CampaignCommander->getEmailMessagePreview()
	 */
	public function testGetEmailMessagePreview()
	{
		$this->assertType('string', $this->campaignCommander->getEmailMessagePreview('1104992528'));
	}


	/**
	 * Tests CampaignCommander->getSmsMessagePreview()
	 */
	public function testGetSmsMessagePreview()
	{
		// TODO Auto-generated CampaignCommanderTest->testGetSmsMessagePreview()
		$this->markTestIncomplete("getSmsMessagePreview test not implemented");

		$this->campaignCommander->getSmsMessagePreview(/* parameters */);

	}


	/**
	 * Tests CampaignCommander->trackAllLinks()
	 */
	public function testTrackAllLinks()
	{
		// TODO Auto-generated CampaignCommanderTest->testTrackAllLinks()
		$this->markTestIncomplete("trackAllLinks test not implemented");

		$this->campaignCommander->trackAllLinks(/* parameters */);

	}


	/**
	 * Tests CampaignCommander->untrackAllLinks()
	 */
	public function testUntrackAllLinks()
	{
		// TODO Auto-generated CampaignCommanderTest->testUntrackAllLinks()
		$this->markTestIncomplete("untrackAllLinks test not implemented");

		$this->campaignCommander->untrackAllLinks(/* parameters */);

	}


	/**
	 * Tests CampaignCommander->trackLinkByPosition()
	 */
	public function testTrackLinkByPosition()
	{
		// TODO Auto-generated CampaignCommanderTest->testTrackLinkByPosition()
		$this->markTestIncomplete("trackLinkByPosition test not implemented");

		$this->campaignCommander->trackLinkByPosition(/* parameters */);

	}


	/**
	 * Tests CampaignCommander->getAllTrackedLinks()
	 */
	public function testGetAllTrackedLinks()
	{
		$this->assertNull($this->campaignCommander->getAllTrackedLinks('1104992528'));
	}


	/**
	 * Tests CampaignCommander->getAllUnusedTrackedLinks()
	 */
	public function testGetAllUnusedTrackedLinks()
	{
		$this->assertNull($this->campaignCommander->getAllUnusedTrackedLinks('1104992528'));
	}


	/**
	 * Tests CampaignCommander->getAllTrackableLinks()
	 */
	public function testGetAllTrackableLinks()
	{
		$this->assertType('array', $this->campaignCommander->getAllTrackableLinks('1104992528'));
	}


	/**
	 * Tests CampaignCommander->testEmailMessageByGroup()
	 */
	public function testTestEmailMessageByGroup()
	{
		// TODO Auto-generated CampaignCommanderTest->testTestEmailMessageByGroup()
		$this->markTestIncomplete("testEmailMessageByGroup test not implemented");

		$this->campaignCommander->testEmailMessageByGroup(/* parameters */);

	}


	/**
	 * Tests CampaignCommander->testEmailMessageByMember()
	 */
	public function testTestEmailMessageByMember()
	{
		// TODO Auto-generated CampaignCommanderTest->testTestEmailMessageByMember()
		$this->markTestIncomplete("testEmailMessageByMember test not implemented");

		$this->campaignCommander->testEmailMessageByMember(/* parameters */);

	}


	/**
	 * Tests CampaignCommander->testSmsMessage()
	 */
	public function testTestSmsMessage()
	{
		// TODO Auto-generated CampaignCommanderTest->testTestSmsMessage()
		$this->markTestIncomplete("testSmsMessage test not implemented");

		$this->campaignCommander->testSmsMessage(/* parameters */);

	}


	/**
	 * Tests CampaignCommander->getDefaultSender()
	 */
	public function testGetDefaultSender()
	{
		$this->assertEquals('email@mhg.ccmdemail.net', $this->campaignCommander->getDefaultSender());
	}


	/**
	 * Tests CampaignCommander->getValidatedAltSenders()
	 */
	public function testGetValidatedAltSenders()
	{
		$this->assertType('array', $this->campaignCommander->getValidatedAltSenders());
	}


	/**
	 * Tests CampaignCommander->getNotValidatedSenders()
	 */
	public function testGetNotValidatedSenders()
	{
		$this->assertNull($this->campaignCommander->getNotValidatedSenders());
	}


	/**
	 * Tests CampaignCommander->createStandardUrl()
	 */
	public function testCreateStandardUrl()
	{
		// TODO Auto-generated CampaignCommanderTest->testCreateStandardUrl()
		$this->markTestIncomplete("createStandardUrl test not implemented");

		$this->campaignCommander->createStandardUrl(/* parameters */);

	}


	/**
	 * Tests CampaignCommander->createAndAddStandardUrl()
	 */
	public function testCreateAndAddStandardUrl()
	{
		// TODO Auto-generated CampaignCommanderTest->testCreateAndAddStandardUrl()
		$this->markTestIncomplete("createAndAddStandardUrl test not implemented");

		$this->campaignCommander->createAndAddStandardUrl(/* parameters */);

	}


	/**
	 * Tests CampaignCommander->createUnsubscribeUrl()
	 */
	public function testCreateUnsubscribeUrl()
	{
		// TODO Auto-generated CampaignCommanderTest->testCreateUnsubscribeUrl()
		$this->markTestIncomplete("createUnsubscribeUrl test not implemented");

		$this->campaignCommander->createUnsubscribeUrl(/* parameters */);

	}


	/**
	 * Tests CampaignCommander->createAndAddUnsubscribeUrl()
	 */
	public function testCreateAndAddUnsubscribeUrl()
	{
		// TODO Auto-generated CampaignCommanderTest->testCreateAndAddUnsubscribeUrl()
		$this->markTestIncomplete("createAndAddUnsubscribeUrl test not implemented");

		$this->campaignCommander->createAndAddUnsubscribeUrl(/* parameters */);

	}


	/**
	 * Tests CampaignCommander->createPersonalisedUrl()
	 */
	public function testCreatePersonalisedUrl()
	{
		// TODO Auto-generated CampaignCommanderTest->testCreatePersonalisedUrl()
		$this->markTestIncomplete("createPersonalisedUrl test not implemented");

		$this->campaignCommander->createPersonalisedUrl(/* parameters */);

	}


	/**
	 * Tests CampaignCommander->createAndAddPersonalisedUrl()
	 */
	public function testCreateAndAddPersonalisedUrl()
	{
		// TODO Auto-generated CampaignCommanderTest->testCreateAndAddPersonalisedUrl()
		$this->markTestIncomplete("createAndAddPersonalisedUrl test not implemented");

		$this->campaignCommander->createAndAddPersonalisedUrl(/* parameters */);

	}


	/**
	 * Tests CampaignCommander->createUpdateUrl()
	 */
	public function testCreateUpdateUrl()
	{
		// TODO Auto-generated CampaignCommanderTest->testCreateUpdateUrl()
		$this->markTestIncomplete("createUpdateUrl test not implemented");

		$this->campaignCommander->createUpdateUrl(/* parameters */);

	}


	/**
	 * Tests CampaignCommander->createAndAddUpdateUrl()
	 */
	public function testCreateAndAddUpdateUrl()
	{
		// TODO Auto-generated CampaignCommanderTest->testCreateAndAddUpdateUrl()
		$this->markTestIncomplete("createAndAddUpdateUrl test not implemented");

		$this->campaignCommander->createAndAddUpdateUrl(/* parameters */);

	}


	/**
	 * Tests CampaignCommander->createActionUrl()
	 */
	public function testCreateActionUrl()
	{
		// TODO Auto-generated CampaignCommanderTest->testCreateActionUrl()
		$this->markTestIncomplete("createActionUrl test not implemented");

		$this->campaignCommander->createActionUrl(/* parameters */);

	}


	/**
	 * Tests CampaignCommander->createdAndAddActionUrl()
	 */
	public function testCreatedAndAddActionUrl()
	{
		// TODO Auto-generated CampaignCommanderTest->testCreatedAndAddActionUrl()
		$this->markTestIncomplete("createdAndAddActionUrl test not implemented");

		$this->campaignCommander->createdAndAddActionUrl(/* parameters */);

	}


	/**
	 * Tests CampaignCommander->createMirrorUrl()
	 */
	public function testCreateMirrorUrl()
	{
		// TODO Auto-generated CampaignCommanderTest->testCreateMirrorUrl()
		$this->markTestIncomplete("createMirrorUrl test not implemented");

		$this->campaignCommander->createMirrorUrl(/* parameters */);

	}


	/**
	 * Tests CampaignCommander->createAndAddMirrorUrl()
	 */
	public function testCreateAndAddMirrorUrl()
	{
		// TODO Auto-generated CampaignCommanderTest->testCreateAndAddMirrorUrl()
		$this->markTestIncomplete("createAndAddMirrorUrl test not implemented");

		$this->campaignCommander->createAndAddMirrorUrl(/* parameters */);

	}


	/**
	 * Tests CampaignCommander->addShareLink()
	 */
	public function testAddShareLink()
	{
		// TODO Auto-generated CampaignCommanderTest->testAddShareLink()
		$this->markTestIncomplete("addShareLink test not implemented");

		$this->campaignCommander->addShareLink(/* parameters */);

	}


	/**
	 * Tests CampaignCommander->updateUrlByField()
	 */
	public function testUpdateUrlByField()
	{
		// TODO Auto-generated CampaignCommanderTest->testUpdateUrlByField()
		$this->markTestIncomplete("updateUrlByField test not implemented");

		$this->campaignCommander->updateUrlByField(/* parameters */);

	}


	/**
	 * Tests CampaignCommander->deleteUrl()
	 */
	public function testDeleteUrl()
	{
		// TODO Auto-generated CampaignCommanderTest->testDeleteUrl()
		$this->markTestIncomplete("deleteUrl test not implemented");

		$this->campaignCommander->deleteUrl(/* parameters */);

	}


	/**
	 * Tests CampaignCommander->getUrlByOrder()
	 */
	public function testGetUrlByOrder()
	{
		// TODO Auto-generated CampaignCommanderTest->testGetUrlByOrder()
		$this->markTestIncomplete("getUrlByOrder test not implemented");

		$this->campaignCommander->getUrlByOrder(/* parameters */);

	}


	/**
	 * Tests CampaignCommander->segmentationCreateSegment()
	 */
	public function testSegmentationCreateSegment()
	{
		// TODO Auto-generated CampaignCommanderTest->testSegmentationCreateSegment()
		$this->markTestIncomplete("segmentationCreateSegment test not implemented");

		$this->campaignCommander->segmentationCreateSegment(/* parameters */);

	}


	/**
	 * Tests CampaignCommander->segmentationDeleteSegment()
	 */
	public function testSegmentationDeleteSegment()
	{
		// TODO Auto-generated CampaignCommanderTest->testSegmentationDeleteSegment()
		$this->markTestIncomplete("segmentationDeleteSegment test not implemented");

		$this->campaignCommander->segmentationDeleteSegment(/* parameters */);

	}


	/**
	 * Tests CampaignCommander->segmentationAddStringDemographicCriteriaByObj()
	 */
	public function testSegmentationAddStringDemographicCriteriaByObj()
	{
		// TODO Auto-generated CampaignCommanderTest->testSegmentationAddStringDemographicCriteriaByObj()
		$this->markTestIncomplete("segmentationAddStringDemographicCriteriaByObj test not implemented");

		$this->campaignCommander->segmentationAddStringDemographicCriteriaByObj(/* parameters */);

	}


	/**
	 * Tests CampaignCommander->segmentationAddNumericDemographicCriteriaByObj()
	 */
	public function testSegmentationAddNumericDemographicCriteriaByObj()
	{
		// TODO Auto-generated CampaignCommanderTest->testSegmentationAddNumericDemographicCriteriaByObj()
		$this->markTestIncomplete("segmentationAddNumericDemographicCriteriaByObj test not implemented");

		$this->campaignCommander->segmentationAddNumericDemographicCriteriaByObj(/* parameters */);

	}


	/**
	 * Tests CampaignCommander->segmentationAddDateDemographicCriteriaByObj()
	 */
	public function testSegmentationAddDateDemographicCriteriaByObj()
	{
		// TODO Auto-generated CampaignCommanderTest->testSegmentationAddDateDemographicCriteriaByObj()
		$this->markTestIncomplete("segmentationAddDateDemographicCriteriaByObj test not implemented");

		$this->campaignCommander->segmentationAddDateDemographicCriteriaByObj(/* parameters */);

	}


	/**
	 * Tests CampaignCommander->segmentationAddCampaignActionCriteriaByObj()
	 */
	public function testSegmentationAddCampaignActionCriteriaByObj()
	{
		// TODO Auto-generated CampaignCommanderTest->testSegmentationAddCampaignActionCriteriaByObj()
		$this->markTestIncomplete("segmentationAddCampaignActionCriteriaByObj test not implemented");

		$this->campaignCommander->segmentationAddCampaignActionCriteriaByObj(/* parameters */);

	}


	/**
	 * Tests CampaignCommander->segmentationAddCampaignTrackableLinkCriteriaByObj()
	 */
	public function testSegmentationAddCampaignTrackableLinkCriteriaByObj()
	{
		// TODO Auto-generated CampaignCommanderTest->testSegmentationAddCampaignTrackableLinkCriteriaByObj()
		$this->markTestIncomplete("segmentationAddCampaignTrackableLinkCriteriaByObj test not implemented");

		$this->campaignCommander->segmentationAddCampaignTrackableLinkCriteriaByObj(/* parameters */);

	}


	/**
	 * Tests CampaignCommander->segmentationAddSerieActionCriteriaByObj()
	 */
	public function testSegmentationAddSerieActionCriteriaByObj()
	{
		// TODO Auto-generated CampaignCommanderTest->testSegmentationAddSerieActionCriteriaByObj()
		$this->markTestIncomplete("segmentationAddSerieActionCriteriaByObj test not implemented");

		$this->campaignCommander->segmentationAddSerieActionCriteriaByObj(/* parameters */);

	}


	/**
	 * Tests CampaignCommander->segmentationAddSerieTrackableLinkCriteriaByObj()
	 */
	public function testSegmentationAddSerieTrackableLinkCriteriaByObj()
	{
		// TODO Auto-generated CampaignCommanderTest->testSegmentationAddSerieTrackableLinkCriteriaByObj()
		$this->markTestIncomplete("segmentationAddSerieTrackableLinkCriteriaByObj test not implemented");

		$this->campaignCommander->segmentationAddSerieTrackableLinkCriteriaByObj(/* parameters */);

	}


	/**
	 * Tests CampaignCommander->segmentationAddSocialNetworkCriteriaByObj()
	 */
	public function testSegmentationAddSocialNetworkCriteriaByObj()
	{
		// TODO Auto-generated CampaignCommanderTest->testSegmentationAddSocialNetworkCriteriaByObj()
		$this->markTestIncomplete("segmentationAddSocialNetworkCriteriaByObj test not implemented");

		$this->campaignCommander->segmentationAddSocialNetworkCriteriaByObj(/* parameters */);

	}


	/**
	 * Tests CampaignCommander->segmentationAddRecencyCriteriaByObj()
	 */
	public function testSegmentationAddRecencyCriteriaByObj()
	{
		// TODO Auto-generated CampaignCommanderTest->testSegmentationAddRecencyCriteriaByObj()
		$this->markTestIncomplete("segmentationAddRecencyCriteriaByObj test not implemented");

		$this->campaignCommander->segmentationAddRecencyCriteriaByObj(/* parameters */);

	}


	/**
	 * Tests CampaignCommander->segmentationAddDataMartCriteriaByObj()
	 */
	public function testSegmentationAddDataMartCriteriaByObj()
	{
		// TODO Auto-generated CampaignCommanderTest->testSegmentationAddDataMartCriteriaByObj()
		$this->markTestIncomplete("segmentationAddDataMartCriteriaByObj test not implemented");

		$this->campaignCommander->segmentationAddDataMartCriteriaByObj(/* parameters */);

	}


	/**
	 * Tests CampaignCommander->segmentationGetSegmentById()
	 */
	public function testSegmentationGetSegmentById()
	{
		// TODO Auto-generated CampaignCommanderTest->testSegmentationGetSegmentById()
		$this->markTestIncomplete("segmentationGetSegmentById test not implemented");

		$this->campaignCommander->segmentationGetSegmentById(/* parameters */);

	}


	/**
	 * Tests CampaignCommander->segmentationGetSegmentList()
	 */
	public function testSegmentationGetSegmentList()
	{
		// TODO Auto-generated CampaignCommanderTest->testSegmentationGetSegmentList()
		$this->markTestIncomplete("segmentationGetSegmentList test not implemented");

		$this->campaignCommander->segmentationGetSegmentList(/* parameters */);

	}


	/**
	 * Tests CampaignCommander->segmentationGetSegmentCriterias()
	 */
	public function testSegmentationGetSegmentCriterias()
	{
		// TODO Auto-generated CampaignCommanderTest->testSegmentationGetSegmentCriterias()
		$this->markTestIncomplete("segmentationGetSegmentCriterias test not implemented");

		$this->campaignCommander->segmentationGetSegmentCriterias(/* parameters */);

	}


	/**
	 * Tests CampaignCommander->segmentationGetPersoFragList()
	 */
	public function testSegmentationGetPersoFragList()
	{
		// TODO Auto-generated CampaignCommanderTest->testSegmentationGetPersoFragList()
		$this->markTestIncomplete("segmentationGetPersoFragList test not implemented");

		$this->campaignCommander->segmentationGetPersoFragList(/* parameters */);

	}


	/**
	 * Tests CampaignCommander->segmentationDeleteCriteria()
	 */
	public function testSegmentationDeleteCriteria()
	{
		// TODO Auto-generated CampaignCommanderTest->testSegmentationDeleteCriteria()
		$this->markTestIncomplete("segmentationDeleteCriteria test not implemented");

		$this->campaignCommander->segmentationDeleteCriteria(/* parameters */);

	}


	/**
	 * Tests CampaignCommander->segmentationUpdateSegment()
	 */
	public function testSegmentationUpdateSegment()
	{
		// TODO Auto-generated CampaignCommanderTest->testSegmentationUpdateSegment()
		$this->markTestIncomplete("segmentationUpdateSegment test not implemented");

		$this->campaignCommander->segmentationUpdateSegment(/* parameters */);

	}


	/**
	 * Tests CampaignCommander->segmentationUpdateStringDemographicCriteriaByObj()
	 */
	public function testSegmentationUpdateStringDemographicCriteriaByObj()
	{
		// TODO Auto-generated CampaignCommanderTest->testSegmentationUpdateStringDemographicCriteriaByObj()
		$this->markTestIncomplete("segmentationUpdateStringDemographicCriteriaByObj test not implemented");

		$this->campaignCommander->segmentationUpdateStringDemographicCriteriaByObj(/* parameters */);

	}


	/**
	 * Tests CampaignCommander->segmentationUpdateNumericDemographicCriteriaByObj()
	 */
	public function testSegmentationUpdateNumericDemographicCriteriaByObj()
	{
		// TODO Auto-generated CampaignCommanderTest->testSegmentationUpdateNumericDemographicCriteriaByObj()
		$this->markTestIncomplete("segmentationUpdateNumericDemographicCriteriaByObj test not implemented");

		$this->campaignCommander->segmentationUpdateNumericDemographicCriteriaByObj(/* parameters */);

	}


	/**
	 * Tests CampaignCommander->segmentationUpdateDateDemographicCriteriaByObj()
	 */
	public function testSegmentationUpdateDateDemographicCriteriaByObj()
	{
		// TODO Auto-generated CampaignCommanderTest->testSegmentationUpdateDateDemographicCriteriaByObj()
		$this->markTestIncomplete("segmentationUpdateDateDemographicCriteriaByObj test not implemented");

		$this->campaignCommander->segmentationUpdateDateDemographicCriteriaByObj(/* parameters */);

	}


	/**
	 * Tests CampaignCommander->segmentationUpdateCampaignActionCriteriaByObj()
	 */
	public function testSegmentationUpdateCampaignActionCriteriaByObj()
	{
		// TODO Auto-generated CampaignCommanderTest->testSegmentationUpdateCampaignActionCriteriaByObj()
		$this->markTestIncomplete("segmentationUpdateCampaignActionCriteriaByObj test not implemented");

		$this->campaignCommander->segmentationUpdateCampaignActionCriteriaByObj(/* parameters */);

	}


	/**
	 * Tests CampaignCommander->segmentationUpdateCampaignTrackableLinkCriteriaByObj()
	 */
	public function testSegmentationUpdateCampaignTrackableLinkCriteriaByObj()
	{
		// TODO Auto-generated CampaignCommanderTest->testSegmentationUpdateCampaignTrackableLinkCriteriaByObj()
		$this->markTestIncomplete("segmentationUpdateCampaignTrackableLinkCriteriaByObj test not implemented");

		$this->campaignCommander->segmentationUpdateCampaignTrackableLinkCriteriaByObj(/* parameters */);

	}


	/**
	 * Tests CampaignCommander->segmentationUpdateSerieActionCriteriaByObj()
	 */
	public function testSegmentationUpdateSerieActionCriteriaByObj()
	{
		// TODO Auto-generated CampaignCommanderTest->testSegmentationUpdateSerieActionCriteriaByObj()
		$this->markTestIncomplete("segmentationUpdateSerieActionCriteriaByObj test not implemented");

		$this->campaignCommander->segmentationUpdateSerieActionCriteriaByObj(/* parameters */);

	}


	/**
	 * Tests CampaignCommander->segmentationUpdateSerieTrackableLinkCriteriaByObj()
	 */
	public function testSegmentationUpdateSerieTrackableLinkCriteriaByObj()
	{
		// TODO Auto-generated CampaignCommanderTest->testSegmentationUpdateSerieTrackableLinkCriteriaByObj()
		$this->markTestIncomplete("segmentationUpdateSerieTrackableLinkCriteriaByObj test not implemented");

		$this->campaignCommander->segmentationUpdateSerieTrackableLinkCriteriaByObj(/* parameters */);

	}


	/**
	 * Tests CampaignCommander->segmentationUpdateSocialNetworkCriteriaByObj()
	 */
	public function testSegmentationUpdateSocialNetworkCriteriaByObj()
	{
		// TODO Auto-generated CampaignCommanderTest->testSegmentationUpdateSocialNetworkCriteriaByObj()
		$this->markTestIncomplete("segmentationUpdateSocialNetworkCriteriaByObj test not implemented");

		$this->campaignCommander->segmentationUpdateSocialNetworkCriteriaByObj(/* parameters */);

	}


	/**
	 * Tests CampaignCommander->segmentationUpdateRecencyCriteriaByObj()
	 */
	public function testSegmentationUpdateRecencyCriteriaByObj()
	{
		// TODO Auto-generated CampaignCommanderTest->testSegmentationUpdateRecencyCriteriaByObj()
		$this->markTestIncomplete("segmentationUpdateRecencyCriteriaByObj test not implemented");

		$this->campaignCommander->segmentationUpdateRecencyCriteriaByObj(/* parameters */);

	}


	/**
	 * Tests CampaignCommander->segmentationUpdateDataMartCriteriaByObj()
	 */
	public function testSegmentationUpdateDataMartCriteriaByObj()
	{
		// TODO Auto-generated CampaignCommanderTest->testSegmentationUpdateDataMartCriteriaByObj()
		$this->markTestIncomplete("segmentationUpdateDataMartCriteriaByObj test not implemented");

		$this->campaignCommander->segmentationUpdateDataMartCriteriaByObj(/* parameters */);

	}


	/**
	 * Tests CampaignCommander->segmentationCount()
	 */
	public function testSegmentationCount()
	{
		// TODO Auto-generated CampaignCommanderTest->testSegmentationCount()
		$this->markTestIncomplete("segmentationCount test not implemented");

		$this->campaignCommander->segmentationCount(/* parameters */);

	}


	/**
	 * Tests CampaignCommander->segmentationDistinctCount()
	 */
	public function testSegmentationDistinctCount()
	{
		// TODO Auto-generated CampaignCommanderTest->testSegmentationDistinctCount()
		$this->markTestIncomplete("segmentationDistinctCount test not implemented");

		$this->campaignCommander->segmentationDistinctCount(/* parameters */);

	}


	/**
	 * Tests CampaignCommander->createCampaign()
	 */
	public function testCreateCampaign()
	{
		// TODO Auto-generated CampaignCommanderTest->testCreateCampaign()
		$this->markTestIncomplete("createCampaign test not implemented");

		$this->campaignCommander->createCampaign(/* parameters */);

	}


	/**
	 * Tests CampaignCommander->createCampaignWithAnalytics()
	 */
	public function testCreateCampaignWithAnalytics()
	{
		// TODO Auto-generated CampaignCommanderTest->testCreateCampaignWithAnalytics()
		$this->markTestIncomplete("createCampaignWithAnalytics test not implemented");

		$this->campaignCommander->createCampaignWithAnalytics(/* parameters */);

	}


	/**
	 * Tests CampaignCommander->createCampaignByObj()
	 */
	public function testCreateCampaignByObj()
	{
		// TODO Auto-generated CampaignCommanderTest->testCreateCampaignByObj()
		$this->markTestIncomplete("createCampaignByObj test not implemented");

		$this->campaignCommander->createCampaignByObj(/* parameters */);

	}


	/**
	 * Tests CampaignCommander->deleteCampaign()
	 */
	public function testDeleteCampaign()
	{
		// TODO Auto-generated CampaignCommanderTest->testDeleteCampaign()
		$this->markTestIncomplete("deleteCampaign test not implemented");

		$this->campaignCommander->deleteCampaign(/* parameters */);

	}


	/**
	 * Tests CampaignCommander->updateCampaign()
	 */
	public function testUpdateCampaign()
	{
		// TODO Auto-generated CampaignCommanderTest->testUpdateCampaign()
		$this->markTestIncomplete("updateCampaign test not implemented");

		$this->campaignCommander->updateCampaign(/* parameters */);

	}


	/**
	 * Tests CampaignCommander->updateCampaignByObj()
	 */
	public function testUpdateCampaignByObj()
	{
		// TODO Auto-generated CampaignCommanderTest->testUpdateCampaignByObj()
		$this->markTestIncomplete("updateCampaignByObj test not implemented");

		$this->campaignCommander->updateCampaignByObj(/* parameters */);

	}


	/**
	 * Tests CampaignCommander->postCampaign()
	 */
	public function testPostCampaign()
	{
		// TODO Auto-generated CampaignCommanderTest->testPostCampaign()
		$this->markTestIncomplete("postCampaign test not implemented");

		$this->campaignCommander->postCampaign(/* parameters */);

	}


	/**
	 * Tests CampaignCommander->unpostCampaign()
	 */
	public function testUnpostCampaign()
	{
		// TODO Auto-generated CampaignCommanderTest->testUnpostCampaign()
		$this->markTestIncomplete("unpostCampaign test not implemented");

		$this->campaignCommander->unpostCampaign(/* parameters */);

	}


	/**
	 * Tests CampaignCommander->getCampaign()
	 */
	public function testGetCampaign()
	{
		// TODO Auto-generated CampaignCommanderTest->testGetCampaign()
		$this->markTestIncomplete("getCampaign test not implemented");

		$this->campaignCommander->getCampaign(/* parameters */);

	}


	/**
	 * Tests CampaignCommander->getCampaignsByField()
	 */
	public function testGetCampaignsByField()
	{
		// TODO Auto-generated CampaignCommanderTest->testGetCampaignsByField()
		$this->markTestIncomplete("getCampaignsByField test not implemented");

		$this->campaignCommander->getCampaignsByField(/* parameters */);

	}


	/**
	 * Tests CampaignCommander->getCampaignsByStatus()
	 */
	public function testGetCampaignsByStatus()
	{
		// TODO Auto-generated CampaignCommanderTest->testGetCampaignsByStatus()
		$this->markTestIncomplete("getCampaignsByStatus test not implemented");

		$this->campaignCommander->getCampaignsByStatus(/* parameters */);

	}


	/**
	 * Tests CampaignCommander->getCampaignsByPeriod()
	 */
	public function testGetCampaignsByPeriod()
	{
		// TODO Auto-generated CampaignCommanderTest->testGetCampaignsByPeriod()
		$this->markTestIncomplete("getCampaignsByPeriod test not implemented");

		$this->campaignCommander->getCampaignsByPeriod(/* parameters */);

	}


	/**
	 * Tests CampaignCommander->getCampaignStatus()
	 */
	public function testGetCampaignStatus()
	{
		// TODO Auto-generated CampaignCommanderTest->testGetCampaignStatus()
		$this->markTestIncomplete("getCampaignStatus test not implemented");

		$this->campaignCommander->getCampaignStatus(/* parameters */);

	}


	/**
	 * Tests CampaignCommander->getLastCampaigns()
	 */
	public function testGetLastCampaigns()
	{
		// TODO Auto-generated CampaignCommanderTest->testGetLastCampaigns()
		$this->markTestIncomplete("getLastCampaigns test not implemented");

		$this->campaignCommander->getLastCampaigns(/* parameters */);

	}


	/**
	 * Tests CampaignCommander->testCampaignByGroup()
	 */
	public function testTestCampaignByGroup()
	{
		// TODO Auto-generated CampaignCommanderTest->testTestCampaignByGroup()
		$this->markTestIncomplete("testCampaignByGroup test not implemented");

		$this->campaignCommander->testCampaignByGroup(/* parameters */);

	}


	/**
	 * Tests CampaignCommander->testCampaignByMember()
	 */
	public function testTestCampaignByMember()
	{
		// TODO Auto-generated CampaignCommanderTest->testTestCampaignByMember()
		$this->markTestIncomplete("testCampaignByMember test not implemented");

		$this->campaignCommander->testCampaignByMember(/* parameters */);

	}


	/**
	 * Tests CampaignCommander->pauseCampaign()
	 */
	public function testPauseCampaign()
	{
		// TODO Auto-generated CampaignCommanderTest->testPauseCampaign()
		$this->markTestIncomplete("pauseCampaign test not implemented");

		$this->campaignCommander->pauseCampaign(/* parameters */);

	}


	/**
	 * Tests CampaignCommander->unpauseCampaign()
	 */
	public function testUnpauseCampaign()
	{
		// TODO Auto-generated CampaignCommanderTest->testUnpauseCampaign()
		$this->markTestIncomplete("unpauseCampaign test not implemented");

		$this->campaignCommander->unpauseCampaign(/* parameters */);

	}


	/**
	 * Tests CampaignCommander->getCampaignSnapshotReport()
	 */
	public function testGetCampaignSnapshotReport()
	{
		// TODO Auto-generated CampaignCommanderTest->testGetCampaignSnapshotReport()
		$this->markTestIncomplete("getCampaignSnapshotReport test not implemented");

		$this->campaignCommander->getCampaignSnapshotReport(/* parameters */);

	}


	/**
	 * Tests CampaignCommander->createBanner()
	 */
	public function testCreateBanner()
	{
		// TODO Auto-generated CampaignCommanderTest->testCreateBanner()
		$this->markTestIncomplete("createBanner test not implemented");

		$this->campaignCommander->createBanner(/* parameters */);

	}


	/**
	 * Tests CampaignCommander->createBannerByObj()
	 */
	public function testCreateBannerByObj()
	{
		// TODO Auto-generated CampaignCommanderTest->testCreateBannerByObj()
		$this->markTestIncomplete("createBannerByObj test not implemented");

		$this->campaignCommander->createBannerByObj(/* parameters */);

	}


	/**
	 * Tests CampaignCommander->deleteBanner()
	 */
	public function testDeleteBanner()
	{
		// TODO Auto-generated CampaignCommanderTest->testDeleteBanner()
		$this->markTestIncomplete("deleteBanner test not implemented");

		$this->campaignCommander->deleteBanner(/* parameters */);

	}


	/**
	 * Tests CampaignCommander->updateBanner()
	 */
	public function testUpdateBanner()
	{
		// TODO Auto-generated CampaignCommanderTest->testUpdateBanner()
		$this->markTestIncomplete("updateBanner test not implemented");

		$this->campaignCommander->updateBanner(/* parameters */);

	}


	/**
	 * Tests CampaignCommander->updateBannerByObj()
	 */
	public function testUpdateBannerByObj()
	{
		// TODO Auto-generated CampaignCommanderTest->testUpdateBannerByObj()
		$this->markTestIncomplete("updateBannerByObj test not implemented");

		$this->campaignCommander->updateBannerByObj(/* parameters */);

	}


	/**
	 * Tests CampaignCommander->cloneBanner()
	 */
	public function testCloneBanner()
	{
		// TODO Auto-generated CampaignCommanderTest->testCloneBanner()
		$this->markTestIncomplete("cloneBanner test not implemented");

		$this->campaignCommander->cloneBanner(/* parameters */);

	}


	/**
	 * Tests CampaignCommander->getBannerPreview()
	 */
	public function testGetBannerPreview()
	{
		// TODO Auto-generated CampaignCommanderTest->testGetBannerPreview()
		$this->markTestIncomplete("getBannerPreview test not implemented");

		$this->campaignCommander->getBannerPreview(/* parameters */);

	}


	/**
	 * Tests CampaignCommander->getBanner()
	 */
	public function testGetBanner()
	{
		// TODO Auto-generated CampaignCommanderTest->testGetBanner()
		$this->markTestIncomplete("getBanner test not implemented");

		$this->campaignCommander->getBanner(/* parameters */);

	}


	/**
	 * Tests CampaignCommander->getBannersByField()
	 */
	public function testGetBannersByField()
	{
		// TODO Auto-generated CampaignCommanderTest->testGetBannersByField()
		$this->markTestIncomplete("getBannersByField test not implemented");

		$this->campaignCommander->getBannersByField(/* parameters */);

	}


	/**
	 * Tests CampaignCommander->getBannersByPeriod()
	 */
	public function testGetBannersByPeriod()
	{
		// TODO Auto-generated CampaignCommanderTest->testGetBannersByPeriod()
		$this->markTestIncomplete("getBannersByPeriod test not implemented");

		$this->campaignCommander->getBannersByPeriod(/* parameters */);

	}


	/**
	 * Tests CampaignCommander->getLastBanners()
	 */
	public function testGetLastBanners()
	{
		// TODO Auto-generated CampaignCommanderTest->testGetLastBanners()
		$this->markTestIncomplete("getLastBanners test not implemented");

		$this->campaignCommander->getLastBanners(/* parameters */);

	}


	/**
	 * Tests CampaignCommander->trackAllBannerLinks()
	 */
	public function testTrackAllBannerLinks()
	{
		// TODO Auto-generated CampaignCommanderTest->testTrackAllBannerLinks()
		$this->markTestIncomplete("trackAllBannerLinks test not implemented");

		$this->campaignCommander->trackAllBannerLinks(/* parameters */);

	}


	/**
	 * Tests CampaignCommander->untrackAllBannerLinks()
	 */
	public function testUntrackAllBannerLinks()
	{
		// TODO Auto-generated CampaignCommanderTest->testUntrackAllBannerLinks()
		$this->markTestIncomplete("untrackAllBannerLinks test not implemented");

		$this->campaignCommander->untrackAllBannerLinks(/* parameters */);

	}


	/**
	 * Tests CampaignCommander->trackBannerLinkByPosition()
	 */
	public function testTrackBannerLinkByPosition()
	{
		// TODO Auto-generated CampaignCommanderTest->testTrackBannerLinkByPosition()
		$this->markTestIncomplete("trackBannerLinkByPosition test not implemented");

		$this->campaignCommander->trackBannerLinkByPosition(/* parameters */);

	}


	/**
	 * Tests CampaignCommander->untrackBannerLinkByOrder()
	 */
	public function testUntrackBannerLinkByOrder()
	{
		// TODO Auto-generated CampaignCommanderTest->testUntrackBannerLinkByOrder()
		$this->markTestIncomplete("untrackBannerLinkByOrder test not implemented");

		$this->campaignCommander->untrackBannerLinkByOrder(/* parameters */);

	}


	/**
	 * Tests CampaignCommander->getAllBannerTrackedLinks()
	 */
	public function testGetAllBannerTrackedLinks()
	{
		// TODO Auto-generated CampaignCommanderTest->testGetAllBannerTrackedLinks()
		$this->markTestIncomplete("getAllBannerTrackedLinks test not implemented");

		$this->campaignCommander->getAllBannerTrackedLinks(/* parameters */);

	}


	/**
	 * Tests CampaignCommander->getAllUnusedBannerTrackedLinks()
	 */
	public function testGetAllUnusedBannerTrackedLinks()
	{
		// TODO Auto-generated CampaignCommanderTest->testGetAllUnusedBannerTrackedLinks()
		$this->markTestIncomplete("getAllUnusedBannerTrackedLinks test not implemented");

		$this->campaignCommander->getAllUnusedBannerTrackedLinks(/* parameters */);

	}


	/**
	 * Tests CampaignCommander->getAllBannerTrackableLinks()
	 */
	public function testGetAllBannerTrackableLinks()
	{
		// TODO Auto-generated CampaignCommanderTest->testGetAllBannerTrackableLinks()
		$this->markTestIncomplete("getAllBannerTrackableLinks test not implemented");

		$this->campaignCommander->getAllBannerTrackableLinks(/* parameters */);

	}


	/**
	 * Tests CampaignCommander->createStandardBannerLink()
	 */
	public function testCreateStandardBannerLink()
	{
		// TODO Auto-generated CampaignCommanderTest->testCreateStandardBannerLink()
		$this->markTestIncomplete("createStandardBannerLink test not implemented");

		$this->campaignCommander->createStandardBannerLink(/* parameters */);

	}


	/**
	 * Tests CampaignCommander->createAndAddStandardBannerLink()
	 */
	public function testCreateAndAddStandardBannerLink()
	{
		// TODO Auto-generated CampaignCommanderTest->testCreateAndAddStandardBannerLink()
		$this->markTestIncomplete("createAndAddStandardBannerLink test not implemented");

		$this->campaignCommander->createAndAddStandardBannerLink(/* parameters */);

	}


	/**
	 * Tests CampaignCommander->createUnsubscribeBannerLink()
	 */
	public function testCreateUnsubscribeBannerLink()
	{
		// TODO Auto-generated CampaignCommanderTest->testCreateUnsubscribeBannerLink()
		$this->markTestIncomplete("createUnsubscribeBannerLink test not implemented");

		$this->campaignCommander->createUnsubscribeBannerLink(/* parameters */);

	}


	/**
	 * Tests CampaignCommander->createAndAddUnsubscribeBannerLink()
	 */
	public function testCreateAndAddUnsubscribeBannerLink()
	{
		// TODO Auto-generated CampaignCommanderTest->testCreateAndAddUnsubscribeBannerLink()
		$this->markTestIncomplete("createAndAddUnsubscribeBannerLink test not implemented");

		$this->campaignCommander->createAndAddUnsubscribeBannerLink(/* parameters */);

	}


	/**
	 * Tests CampaignCommander->createPersonalisedBannerLink()
	 */
	public function testCreatePersonalisedBannerLink()
	{
		// TODO Auto-generated CampaignCommanderTest->testCreatePersonalisedBannerLink()
		$this->markTestIncomplete("createPersonalisedBannerLink test not implemented");

		$this->campaignCommander->createPersonalisedBannerLink(/* parameters */);

	}


	/**
	 * Tests CampaignCommander->createAndAddPersonalisedBannerLink()
	 */
	public function testCreateAndAddPersonalisedBannerLink()
	{
		// TODO Auto-generated CampaignCommanderTest->testCreateAndAddPersonalisedBannerLink()
		$this->markTestIncomplete("createAndAddPersonalisedBannerLink test not implemented");

		$this->campaignCommander->createAndAddPersonalisedBannerLink(/* parameters */);

	}


	/**
	 * Tests CampaignCommander->createUpdateBannerLink()
	 */
	public function testCreateUpdateBannerLink()
	{
		// TODO Auto-generated CampaignCommanderTest->testCreateUpdateBannerLink()
		$this->markTestIncomplete("createUpdateBannerLink test not implemented");

		$this->campaignCommander->createUpdateBannerLink(/* parameters */);

	}


	/**
	 * Tests CampaignCommander->createAndAddUpdateBannerLink()
	 */
	public function testCreateAndAddUpdateBannerLink()
	{
		// TODO Auto-generated CampaignCommanderTest->testCreateAndAddUpdateBannerLink()
		$this->markTestIncomplete("createAndAddUpdateBannerLink test not implemented");

		$this->campaignCommander->createAndAddUpdateBannerLink(/* parameters */);

	}


	/**
	 * Tests CampaignCommander->createActionBannerLink()
	 */
	public function testCreateActionBannerLink()
	{
		// TODO Auto-generated CampaignCommanderTest->testCreateActionBannerLink()
		$this->markTestIncomplete("createActionBannerLink test not implemented");

		$this->campaignCommander->createActionBannerLink(/* parameters */);

	}


	/**
	 * Tests CampaignCommander->createAndAddActionBannerLink()
	 */
	public function testCreateAndAddActionBannerLink()
	{
		// TODO Auto-generated CampaignCommanderTest->testCreateAndAddActionBannerLink()
		$this->markTestIncomplete("createAndAddActionBannerLink test not implemented");

		$this->campaignCommander->createAndAddActionBannerLink(/* parameters */);

	}


	/**
	 * Tests CampaignCommander->createMirrorBannerLink()
	 */
	public function testCreateMirrorBannerLink()
	{
		// TODO Auto-generated CampaignCommanderTest->testCreateMirrorBannerLink()
		$this->markTestIncomplete("createMirrorBannerLink test not implemented");

		$this->campaignCommander->createMirrorBannerLink(/* parameters */);

	}


	/**
	 * Tests CampaignCommander->createAndAddMirrorBannerLink()
	 */
	public function testCreateAndAddMirrorBannerLink()
	{
		// TODO Auto-generated CampaignCommanderTest->testCreateAndAddMirrorBannerLink()
		$this->markTestIncomplete("createAndAddMirrorBannerLink test not implemented");

		$this->campaignCommander->createAndAddMirrorBannerLink(/* parameters */);

	}


	/**
	 * Tests CampaignCommander->updateBannerLinkByField()
	 */
	public function testUpdateBannerLinkByField()
	{
		// TODO Auto-generated CampaignCommanderTest->testUpdateBannerLinkByField()
		$this->markTestIncomplete("updateBannerLinkByField test not implemented");

		$this->campaignCommander->updateBannerLinkByField(/* parameters */);

	}


	/**
	 * Tests CampaignCommander->getBannerLinkByOrder()
	 */
	public function testGetBannerLinkByOrder()
	{
		// TODO Auto-generated CampaignCommanderTest->testGetBannerLinkByOrder()
		$this->markTestIncomplete("getBannerLinkByOrder test not implemented");

		$this->campaignCommander->getBannerLinkByOrder(/* parameters */);

	}


	/**
	 * Tests CampaignCommander->createTestGroup()
	 */
	public function testCreateTestGroup()
	{
		// TODO Auto-generated CampaignCommanderTest->testCreateTestGroup()
		$this->markTestIncomplete("createTestGroup test not implemented");

		$this->campaignCommander->createTestGroup(/* parameters */);

	}


	/**
	 * Tests CampaignCommander->createTestGroupByObj()
	 */
	public function testCreateTestGroupByObj()
	{
		// TODO Auto-generated CampaignCommanderTest->testCreateTestGroupByObj()
		$this->markTestIncomplete("createTestGroupByObj test not implemented");

		$this->campaignCommander->createTestGroupByObj(/* parameters */);

	}


	/**
	 * Tests CampaignCommander->addTestMember()
	 */
	public function testAddTestMember()
	{
		// TODO Auto-generated CampaignCommanderTest->testAddTestMember()
		$this->markTestIncomplete("addTestMember test not implemented");

		$this->campaignCommander->addTestMember(/* parameters */);

	}


	/**
	 * Tests CampaignCommander->removeTestMember()
	 */
	public function testRemoveTestMember()
	{
		// TODO Auto-generated CampaignCommanderTest->testRemoveTestMember()
		$this->markTestIncomplete("removeTestMember test not implemented");

		$this->campaignCommander->removeTestMember(/* parameters */);

	}


	/**
	 * Tests CampaignCommander->deleteTestGroup()
	 */
	public function testDeleteTestGroup()
	{
		// TODO Auto-generated CampaignCommanderTest->testDeleteTestGroup()
		$this->markTestIncomplete("deleteTestGroup test not implemented");

		$this->campaignCommander->deleteTestGroup(/* parameters */);

	}


	/**
	 * Tests CampaignCommander->updateTestGroupByObj()
	 */
	public function testUpdateTestGroupByObj()
	{
		// TODO Auto-generated CampaignCommanderTest->testUpdateTestGroupByObj()
		$this->markTestIncomplete("updateTestGroupByObj test not implemented");

		$this->campaignCommander->updateTestGroupByObj(/* parameters */);

	}


	/**
	 * Tests CampaignCommander->getTestGroup()
	 */
	public function testGetTestGroup()
	{
		// TODO Auto-generated CampaignCommanderTest->testGetTestGroup()
		$this->markTestIncomplete("getTestGroup test not implemented");

		$this->campaignCommander->getTestGroup(/* parameters */);

	}


	/**
	 * Tests CampaignCommander->getClientTestGroups()
	 */
	public function testGetClientTestGroups()
	{
		// TODO Auto-generated CampaignCommanderTest->testGetClientTestGroups()
		$this->markTestIncomplete("getClientTestGroups test not implemented");

		$this->campaignCommander->getClientTestGroups(/* parameters */);

	}

}

