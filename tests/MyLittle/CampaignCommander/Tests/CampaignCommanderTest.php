<?php

namespace MyLittle\CampaignCommander\Tests;

/**
 * CampaignCommander test case.
 */
class CampaignCommanderTest extends \PHPUnit_Framework_TestCase
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
     * Tests CampaignCommander->getTimeOut()
     */
    public function testGetTimeOut()
    {
        $this->campaignCommander->setTimeOut(5);
        $this->assertEquals(5, $this->campaignCommander->getTimeOut());
    }

    /**
     * Tests CampaignCommander->getUserAgent()
     */
    public function testGetUserAgent()
    {
        $this->campaignCommander->setUserAgent('testing/1.0.0');
        $this->assertEquals('PHP Campaign Commander/' . CampaignCommander::VERSION . ' testing/1.0.0', $this->campaignCommander->getUserAgent());
    }

    /**
     * Tests CampaignCommander->createEmailMessage()
     */
    public function testCreateEmailMessage()
    {
        // create the message
        $var = $this->campaignCommander->createEmailMessage('TEST (remove me)', '', 'subject', 'from', 'email@mhg.ccmdemail.net', 'to', '[EMV TEXTPART]body', 'utf-8', 'replyTo', 'replyTo@mail.be');

        $this->assertType('string', $var);

        // delete message
        $this->campaignCommander->deleteMessage($var);
    }

    /**
     * Tests CampaignCommander->createEmailMessageByObj()
     */
    public function testCreateEmailMessageByObj()
    {
        // create the message
        $var = $this->campaignCommander->createEmailMessageByObj(array(
            'body' => '[EMV TEXTPART]body',
            'isBounceback' => 0,
            'description' => 'blaat',
            'encoding' => 'utf-8',
            'from' => 'from',
            'fromEmail' => 'email@mhg.ccmdemail.net',
            'id' => 0,
            'name' => 'TEST (remove me)',
            'replyTo' => 'replyTo',
            'replyToEmail' => 'replyTo@mail.be',
            'subject' => 'subject',
            'to' => 'to',
            'hotmailUnsubFlg' => 0
        ));

        $this->assertType('string', $var);

        // delete message
        $this->campaignCommander->deleteMessage($var);
    }

    /**
     * Tests CampaignCommander->createSmsMessage()
     */
    public function testCreateSmsMessage()
    {
        // create the message
        $var = $this->campaignCommander->createSmsMessage('REMOVE ME', '', 'from', '[EMV SMSPART]body');
        $this->assertType('string', $var);

        // delete message
        $this->campaignCommander->deleteMessage($var);
    }

    /**
     * Tests CampaignCommander->createSmsMessageByObj()
     */
    public function testCreateSmsMessageByObj()
    {
        // create the message
        $var = $this->campaignCommander->createSmsMessageByObj(array(
            'id' => 0,
            'name' => 'REMOVE ME',
            'body' => '[EMV SMSPART]body',
            'type' => 'SMS',
            'hotmailUnsubFlg' => false,
            'isBounceback' => false
        ));
        $this->assertType('string', $var);

        // delete message
        $this->campaignCommander->deleteMessage($var);
    }

    /**
     * Tests CampaignCommander->deleteMessage()
     */
    public function testDeleteMessage()
    {
        // create the message
        $var = $this->campaignCommander->createEmailMessage('TEST (remove me)', '', 'subject', 'from', 'email@mhg.ccmdemail.net', 'to', '[EMV TEXTPART]body', 'utf-8', 'replyTo', 'replyTo@mail.be');

        // delete message
        $this->assertTrue($this->campaignCommander->deleteMessage($var));
    }

    /**
     * Tests CampaignCommander->updateMessage()
     */
    public function testUpdateMessage()
    {
        // create the message
        $var = $this->campaignCommander->createEmailMessage('TEST (remove me)', '', 'subject', 'from', 'email@mhg.ccmdemail.net', 'to', '[EMV TEXTPART]body', 'utf-8', 'replyTo', 'replyTo@mail.be');

        $this->assertTrue($this->campaignCommander->updateMessage($var, 'name', 'REMOVE ME'));

        // delete message
        $this->campaignCommander->deleteMessage($var);
    }

    /**
     * Tests CampaignCommander->updateMessageByObj()
     */
    public function testUpdateMessageByObj()
    {
        // create the message
        $var = $this->campaignCommander->createEmailMessage('TEST (remove me)', '', 'subject', 'from', 'email@mhg.ccmdemail.net', 'to', '[EMV TEXTPART]body', 'utf-8', 'replyTo', 'replyTo@mail.be');

        $this->assertTrue($this->campaignCommander->updateMessageByObj(array(
            'body' => '[EMV TEXTPART]body',
            'isBounceback' => 0,
            'description' => '',
            'encoding' => 'utf-8',
            'from' => 'from',
            'fromEmail' => 'email@mhg.ccmdemail.net',
            'id' => $var,
            'name' => 'REMOVE ME',
            'replyTo' => 'replyTo',
            'replyToEmail' => 'replyTo@mail.be',
            'subject' => 'subject',
            'to' => 'to',
            'hotmailUnsubFlg' => 0
        )));

        // delete message
        $this->campaignCommander->deleteMessage($var);
    }

    /**
     * Tests CampaignCommander->cloneMessage()
     */
    public function testCloneMessage()
    {
        // create the message
        $var = $this->campaignCommander->createEmailMessage('TEST (remove me)', '', 'subject', 'from', 'email@mhg.ccmdemail.net', 'to', '[EMV TEXTPART]body', 'utf-8', 'replyTo', 'replyTo@mail.be');
        $var2 = $this->campaignCommander->cloneMessage($var, 'CLONE');

        $this->assertType('string', $var2);

        // delete message
        $this->campaignCommander->deleteMessage($var);
        $this->campaignCommander->deleteMessage($var2);
    }

    /**
     * Tests CampaignCommander->getMessage()
     */
    public function testGetMessage()
    {
        $this->assertObjectHasAttribute('body', $this->campaignCommander->getMessage('1104992528'));
    }

    /**
     * Tests CampaignCommander->getLastEmailMessages()
     */
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
        $this->assertType('array', $this->campaignCommander->getSmsMessagesByField('name', 'remove', 10));
    }

    /**
     * Tests CampaignCommander->getMessagesByPeriod()
     */
    public function testGetMessagesByPeriod()
    {
        $this->assertType('array', $this->campaignCommander->getMessagesByPeriod(1262300400, 1325372399));
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
        // create the message
        $var = $this->campaignCommander->createSmsMessage('REMOVE ME', '', 'from', '[EMV SMSPART]body');

        $this->assertEquals('body', $this->campaignCommander->getSmsMessagePreview($var));

        // delete message
        $this->campaignCommander->deleteMessage($var);
    }

//  /**
//   * Tests CampaignCommander->trackAllLinks()
//   */
//  public function testTrackAllLinks()
//  {
//      // TODO Auto-generated CampaignCommanderTest->testTrackAllLinks()
//      $this->markTestIncomplete("trackAllLinks test not implemented");
//      $this->campaignCommander->trackAllLinks(/* parameters */);
//  }

//  /**
//   * Tests CampaignCommander->untrackAllLinks()
//   */
//  public function testUntrackAllLinks()
//  {
//      // TODO Auto-generated CampaignCommanderTest->testUntrackAllLinks()
//      $this->markTestIncomplete("untrackAllLinks test not implemented");
//      $this->campaignCommander->untrackAllLinks(/* parameters */);
//  }

//  /**
//   * Tests CampaignCommander->trackLinkByPosition()
//   */
//  public function testTrackLinkByPosition()
//  {
//      // TODO Auto-generated CampaignCommanderTest->testTrackLinkByPosition()
//      $this->markTestIncomplete("trackLinkByPosition test not implemented");
//      $this->campaignCommander->trackLinkByPosition(/* parameters */);
//  }

    /**
     * Tests CampaignCommander->getAllTrackedLinks()
     */
    public function testGetAllTrackedLinks()
    {
        $this->assertType('array', $this->campaignCommander->getAllTrackedLinks('1104992528'));
    }

    /**
     * Tests CampaignCommander->getAllUnusedTrackedLinks()
     */
    public function testGetAllUnusedTrackedLinks()
    {
        $this->assertEquals(array(), $this->campaignCommander->getAllUnusedTrackedLinks('1104992528'));
    }

    /**
     * Tests CampaignCommander->getAllTrackableLinks()
     */
    public function testGetAllTrackableLinks()
    {
        $this->assertType('array', $this->campaignCommander->getAllTrackableLinks('1104992528'));
    }

//  /**
//   * Tests CampaignCommander->testEmailMessageByGroup()
//   */
//  public function testTestEmailMessageByGroup()
//  {
//      // TODO Auto-generated CampaignCommanderTest->testTestEmailMessageByGroup()
//      $this->markTestIncomplete("testEmailMessageByGroup test not implemented");
//      $this->campaignCommander->testEmailMessageByGroup(/* parameters */);
//  }

//  /**
//   * Tests CampaignCommander->testEmailMessageByMember()
//   */
//  public function testTestEmailMessageByMember()
//  {
//      // TODO Auto-generated CampaignCommanderTest->testTestEmailMessageByMember()
//      $this->markTestIncomplete("testEmailMessageByMember test not implemented");
//      $this->campaignCommander->testEmailMessageByMember(/* parameters */);
//  }

//  /**
//   * Tests CampaignCommander->testSmsMessage()
//   */
//  public function testTestSmsMessage()
//  {
//      // TODO Auto-generated CampaignCommanderTest->testTestSmsMessage()
//      $this->markTestIncomplete("testSmsMessage test not implemented");
//      $this->campaignCommander->testSmsMessage(/* parameters */);
//  }

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
        $this->assertEquals(array(), $this->campaignCommander->getNotValidatedSenders());
    }

//  /**
//   * Tests CampaignCommander->createStandardUrl()
//   */
//  public function testCreateStandardUrl()
//  {
//      // TODO Auto-generated CampaignCommanderTest->testCreateStandardUrl()
//      $this->markTestIncomplete("createStandardUrl test not implemented");
//      $this->campaignCommander->createStandardUrl(/* parameters */);
//  }

//  /**
//   * Tests CampaignCommander->createAndAddStandardUrl()
//   */
//  public function testCreateAndAddStandardUrl()
//  {
//      // TODO Auto-generated CampaignCommanderTest->testCreateAndAddStandardUrl()
//      $this->markTestIncomplete("createAndAddStandardUrl test not implemented");
//      $this->campaignCommander->createAndAddStandardUrl(/* parameters */);
//  }

//  /**
//   * Tests CampaignCommander->createUnsubscribeUrl()
//   */
//  public function testCreateUnsubscribeUrl()
//  {
//      // TODO Auto-generated CampaignCommanderTest->testCreateUnsubscribeUrl()
//      $this->markTestIncomplete("createUnsubscribeUrl test not implemented");
//      $this->campaignCommander->createUnsubscribeUrl(/* parameters */);
//  }

//  /**
//   * Tests CampaignCommander->createAndAddUnsubscribeUrl()
//   */
//  public function testCreateAndAddUnsubscribeUrl()
//  {
//      // TODO Auto-generated CampaignCommanderTest->testCreateAndAddUnsubscribeUrl()
//      $this->markTestIncomplete("createAndAddUnsubscribeUrl test not implemented");
//      $this->campaignCommander->createAndAddUnsubscribeUrl(/* parameters */);
//  }

//  /**
//   * Tests CampaignCommander->createPersonalisedUrl()
//   */
//  public function testCreatePersonalisedUrl()
//  {
//      // TODO Auto-generated CampaignCommanderTest->testCreatePersonalisedUrl()
//      $this->markTestIncomplete("createPersonalisedUrl test not implemented");
//      $this->campaignCommander->createPersonalisedUrl(/* parameters */);
//  }

//  /**
//   * Tests CampaignCommander->createAndAddPersonalisedUrl()
//   */
//  public function testCreateAndAddPersonalisedUrl()
//  {
//      // TODO Auto-generated CampaignCommanderTest->testCreateAndAddPersonalisedUrl()
//      $this->markTestIncomplete("createAndAddPersonalisedUrl test not implemented");
//      $this->campaignCommander->createAndAddPersonalisedUrl(/* parameters */);
//  }

//  /**
//   * Tests CampaignCommander->createUpdateUrl()
//   */
//  public function testCreateUpdateUrl()
//  {
//      // TODO Auto-generated CampaignCommanderTest->testCreateUpdateUrl()
//      $this->markTestIncomplete("createUpdateUrl test not implemented");
//      $this->campaignCommander->createUpdateUrl(/* parameters */);
//  }

//  /**
//   * Tests CampaignCommander->createAndAddUpdateUrl()
//   */
//  public function testCreateAndAddUpdateUrl()
//  {
//      // TODO Auto-generated CampaignCommanderTest->testCreateAndAddUpdateUrl()
//      $this->markTestIncomplete("createAndAddUpdateUrl test not implemented");
//      $this->campaignCommander->createAndAddUpdateUrl(/* parameters */);
//  }

//  /**
//   * Tests CampaignCommander->createActionUrl()
//   */
//  public function testCreateActionUrl()
//  {
//      // TODO Auto-generated CampaignCommanderTest->testCreateActionUrl()
//      $this->markTestIncomplete("createActionUrl test not implemented");
//      $this->campaignCommander->createActionUrl(/* parameters */);
//  }

//  /**
//   * Tests CampaignCommander->createdAndAddActionUrl()
//   */
//  public function testCreatedAndAddActionUrl()
//  {
//      // TODO Auto-generated CampaignCommanderTest->testCreatedAndAddActionUrl()
//      $this->markTestIncomplete("createdAndAddActionUrl test not implemented");
//      $this->campaignCommander->createdAndAddActionUrl(/* parameters */);
//  }

//  /**
//   * Tests CampaignCommander->createMirrorUrl()
//   */
//  public function testCreateMirrorUrl()
//  {
//      // TODO Auto-generated CampaignCommanderTest->testCreateMirrorUrl()
//      $this->markTestIncomplete("createMirrorUrl test not implemented");
//      $this->campaignCommander->createMirrorUrl(/* parameters */);
//  }

//  /**
//   * Tests CampaignCommander->createAndAddMirrorUrl()
//   */
//  public function testCreateAndAddMirrorUrl()
//  {
//      // TODO Auto-generated CampaignCommanderTest->testCreateAndAddMirrorUrl()
//      $this->markTestIncomplete("createAndAddMirrorUrl test not implemented");
//      $this->campaignCommander->createAndAddMirrorUrl(/* parameters */);
//  }

//  /**
//   * Tests CampaignCommander->addShareLink()
//   */
//  public function testAddShareLink()
//  {
//      // TODO Auto-generated CampaignCommanderTest->testAddShareLink()
//      $this->markTestIncomplete("addShareLink test not implemented");
//      $this->campaignCommander->addShareLink(/* parameters */);
//  }

//  /**
//   * Tests CampaignCommander->updateUrlByField()
//   */
//  public function testUpdateUrlByField()
//  {
//      // TODO Auto-generated CampaignCommanderTest->testUpdateUrlByField()
//      $this->markTestIncomplete("updateUrlByField test not implemented");
//      $this->campaignCommander->updateUrlByField(/* parameters */);
//  }

//  /**
//   * Tests CampaignCommander->deleteUrl()
//   */
//  public function testDeleteUrl()
//  {
//      // TODO Auto-generated CampaignCommanderTest->testDeleteUrl()
//      $this->markTestIncomplete("deleteUrl test not implemented");
//      $this->campaignCommander->deleteUrl(/* parameters */);
//  }

//  /**
//   * Tests CampaignCommander->getUrlByOrder()
//   */
//  public function testGetUrlByOrder()
//  {
//      // TODO Auto-generated CampaignCommanderTest->testGetUrlByOrder()
//      $this->markTestIncomplete("getUrlByOrder test not implemented");
//      $this->campaignCommander->getUrlByOrder(/* parameters */);
//  }

    public function testSegmentationCreateSegment()
    {
        // create the segment
        $var = $this->campaignCommander->segmentationCreateSegment('REMOVE ME', 'ALL');

        $this->assertType('string', $var);

        // delete message
        $this->campaignCommander->segmentationDeleteSegment($var);
    }

//  /**
//   * Tests CampaignCommander->segmentationDeleteSegment()
//   */
//  public function testSegmentationDeleteSegment()
//  {
//      // TODO Auto-generated CampaignCommanderTest->testSegmentationDeleteSegment()
//      $this->markTestIncomplete("segmentationDeleteSegment test not implemented");
//      $this->campaignCommander->segmentationDeleteSegment(/* parameters */);
//  }

//  /**
//   * Tests CampaignCommander->segmentationAddStringDemographicCriteriaByObj()
//   */
//  public function testSegmentationAddStringDemographicCriteriaByObj()
//  {
//      // TODO Auto-generated CampaignCommanderTest->testSegmentationAddStringDemographicCriteriaByObj()
//      $this->markTestIncomplete("segmentationAddStringDemographicCriteriaByObj test not implemented");
//      $this->campaignCommander->segmentationAddStringDemographicCriteriaByObj(/* parameters */);
//  }

//  /**
//   * Tests CampaignCommander->segmentationAddNumericDemographicCriteriaByObj()
//   */
//  public function testSegmentationAddNumericDemographicCriteriaByObj()
//  {
//      // TODO Auto-generated CampaignCommanderTest->testSegmentationAddNumericDemographicCriteriaByObj()
//      $this->markTestIncomplete("segmentationAddNumericDemographicCriteriaByObj test not implemented");
//      $this->campaignCommander->segmentationAddNumericDemographicCriteriaByObj(/* parameters */);
//  }

//  /**
//   * Tests CampaignCommander->segmentationAddDateDemographicCriteriaByObj()
//   */
//  public function testSegmentationAddDateDemographicCriteriaByObj()
//  {
//      // TODO Auto-generated CampaignCommanderTest->testSegmentationAddDateDemographicCriteriaByObj()
//      $this->markTestIncomplete("segmentationAddDateDemographicCriteriaByObj test not implemented");
//      $this->campaignCommander->segmentationAddDateDemographicCriteriaByObj(/* parameters */);
//  }

//  /**
//   * Tests CampaignCommander->segmentationAddCampaignActionCriteriaByObj()
//   */
//  public function testSegmentationAddCampaignActionCriteriaByObj()
//  {
//      // TODO Auto-generated CampaignCommanderTest->testSegmentationAddCampaignActionCriteriaByObj()
//      $this->markTestIncomplete("segmentationAddCampaignActionCriteriaByObj test not implemented");
//      $this->campaignCommander->segmentationAddCampaignActionCriteriaByObj(/* parameters */);
//  }

//  /**
//   * Tests CampaignCommander->segmentationAddCampaignTrackableLinkCriteriaByObj()
//   */
//  public function testSegmentationAddCampaignTrackableLinkCriteriaByObj()
//  {
//      // TODO Auto-generated CampaignCommanderTest->testSegmentationAddCampaignTrackableLinkCriteriaByObj()
//      $this->markTestIncomplete("segmentationAddCampaignTrackableLinkCriteriaByObj test not implemented");
//      $this->campaignCommander->segmentationAddCampaignTrackableLinkCriteriaByObj(/* parameters */);
//  }

//  /**
//   * Tests CampaignCommander->segmentationAddSerieActionCriteriaByObj()
//   */
//  public function testSegmentationAddSerieActionCriteriaByObj()
//  {
//      // TODO Auto-generated CampaignCommanderTest->testSegmentationAddSerieActionCriteriaByObj()
//      $this->markTestIncomplete("segmentationAddSerieActionCriteriaByObj test not implemented");
//      $this->campaignCommander->segmentationAddSerieActionCriteriaByObj(/* parameters */);
//  }

//  /**
//   * Tests CampaignCommander->segmentationAddSerieTrackableLinkCriteriaByObj()
//   */
//  public function testSegmentationAddSerieTrackableLinkCriteriaByObj()
//  {
//      // TODO Auto-generated CampaignCommanderTest->testSegmentationAddSerieTrackableLinkCriteriaByObj()
//      $this->markTestIncomplete("segmentationAddSerieTrackableLinkCriteriaByObj test not implemented");
//      $this->campaignCommander->segmentationAddSerieTrackableLinkCriteriaByObj(/* parameters */);
//  }

//  /**
//   * Tests CampaignCommander->segmentationAddSocialNetworkCriteriaByObj()
//   */
//  public function testSegmentationAddSocialNetworkCriteriaByObj()
//  {
//      // TODO Auto-generated CampaignCommanderTest->testSegmentationAddSocialNetworkCriteriaByObj()
//      $this->markTestIncomplete("segmentationAddSocialNetworkCriteriaByObj test not implemented");
//      $this->campaignCommander->segmentationAddSocialNetworkCriteriaByObj(/* parameters */);
//  }

//  /**
//   * Tests CampaignCommander->segmentationAddRecencyCriteriaByObj()
//   */
//  public function testSegmentationAddRecencyCriteriaByObj()
//  {
//      // TODO Auto-generated CampaignCommanderTest->testSegmentationAddRecencyCriteriaByObj()
//      $this->markTestIncomplete("segmentationAddRecencyCriteriaByObj test not implemented");
//      $this->campaignCommander->segmentationAddRecencyCriteriaByObj(/* parameters */);
//  }

//  /**
//   * Tests CampaignCommander->segmentationAddDataMartCriteriaByObj()
//   */
//  public function testSegmentationAddDataMartCriteriaByObj()
//  {
//      // TODO Auto-generated CampaignCommanderTest->testSegmentationAddDataMartCriteriaByObj()
//      $this->markTestIncomplete("segmentationAddDataMartCriteriaByObj test not implemented");
//      $this->campaignCommander->segmentationAddDataMartCriteriaByObj(/* parameters */);
//  }

    /**
     * Tests CampaignCommander->segmentationGetSegmentById()
     */
    public function testSegmentationGetSegmentById()
    {
        $this->assertObjectHasAttribute('id', $this->campaignCommander->segmentationGetSegmentById('1104998848'));
    }

    /**
     * Tests CampaignCommander->segmentationGetSegmentList()
     */
    public function testSegmentationGetSegmentList()
    {
        $this->assertType('array', $this->campaignCommander->segmentationGetSegmentList(1, 10));
    }

    /**
     * Tests CampaignCommander->segmentationGetSegmentCriterias()
     */
    public function testSegmentationGetSegmentCriterias()
    {
        $this->assertType('array', $this->campaignCommander->segmentationGetSegmentCriterias('1104998848'));
    }

    /**
     * Tests CampaignCommander->segmentationGetPersoFragList()
     */
    public function testSegmentationGetPersoFragList()
    {
        $this->assertEquals(array(), $this->campaignCommander->segmentationGetPersoFragList(1, 10));
    }

//  /**
//   * Tests CampaignCommander->segmentationDeleteCriteria()
//   */
//  public function testSegmentationDeleteCriteria()
//  {
//      // TODO Auto-generated CampaignCommanderTest->testSegmentationDeleteCriteria()
//      $this->markTestIncomplete("segmentationDeleteCriteria test not implemented");
//      $this->campaignCommander->segmentationDeleteCriteria(/* parameters */);
//  }

//  /**
//   * Tests CampaignCommander->segmentationUpdateSegment()
//   */
//  public function testSegmentationUpdateSegment()
//  {
//      // TODO Auto-generated CampaignCommanderTest->testSegmentationUpdateSegment()
//      $this->markTestIncomplete("segmentationUpdateSegment test not implemented");
//      $this->campaignCommander->segmentationUpdateSegment(/* parameters */);
//  }

//  /**
//   * Tests CampaignCommander->segmentationUpdateStringDemographicCriteriaByObj()
//   */
//  public function testSegmentationUpdateStringDemographicCriteriaByObj()
//  {
//      // TODO Auto-generated CampaignCommanderTest->testSegmentationUpdateStringDemographicCriteriaByObj()
//      $this->markTestIncomplete("segmentationUpdateStringDemographicCriteriaByObj test not implemented");
//      $this->campaignCommander->segmentationUpdateStringDemographicCriteriaByObj(/* parameters */);
//  }

//  /**
//   * Tests CampaignCommander->segmentationUpdateNumericDemographicCriteriaByObj()
//   */
//  public function testSegmentationUpdateNumericDemographicCriteriaByObj()
//  {
//      // TODO Auto-generated CampaignCommanderTest->testSegmentationUpdateNumericDemographicCriteriaByObj()
//      $this->markTestIncomplete("segmentationUpdateNumericDemographicCriteriaByObj test not implemented");
//      $this->campaignCommander->segmentationUpdateNumericDemographicCriteriaByObj(/* parameters */);
//  }

//  /**
//   * Tests CampaignCommander->segmentationUpdateDateDemographicCriteriaByObj()
//   */
//  public function testSegmentationUpdateDateDemographicCriteriaByObj()
//  {
//      // TODO Auto-generated CampaignCommanderTest->testSegmentationUpdateDateDemographicCriteriaByObj()
//      $this->markTestIncomplete("segmentationUpdateDateDemographicCriteriaByObj test not implemented");
//      $this->campaignCommander->segmentationUpdateDateDemographicCriteriaByObj(/* parameters */);
//  }

//  /**
//   * Tests CampaignCommander->segmentationUpdateCampaignActionCriteriaByObj()
//   */
//  public function testSegmentationUpdateCampaignActionCriteriaByObj()
//  {
//      // TODO Auto-generated CampaignCommanderTest->testSegmentationUpdateCampaignActionCriteriaByObj()
//      $this->markTestIncomplete("segmentationUpdateCampaignActionCriteriaByObj test not implemented");
//      $this->campaignCommander->segmentationUpdateCampaignActionCriteriaByObj(/* parameters */);
//  }

//  /**
//   * Tests CampaignCommander->segmentationUpdateCampaignTrackableLinkCriteriaByObj()
//   */
//  public function testSegmentationUpdateCampaignTrackableLinkCriteriaByObj()
//  {
//      // TODO Auto-generated CampaignCommanderTest->testSegmentationUpdateCampaignTrackableLinkCriteriaByObj()
//      $this->markTestIncomplete("segmentationUpdateCampaignTrackableLinkCriteriaByObj test not implemented");
//      $this->campaignCommander->segmentationUpdateCampaignTrackableLinkCriteriaByObj(/* parameters */);
//  }

//  /**
//   * Tests CampaignCommander->segmentationUpdateSerieActionCriteriaByObj()
//   */
//  public function testSegmentationUpdateSerieActionCriteriaByObj()
//  {
//      // TODO Auto-generated CampaignCommanderTest->testSegmentationUpdateSerieActionCriteriaByObj()
//      $this->markTestIncomplete("segmentationUpdateSerieActionCriteriaByObj test not implemented");
//      $this->campaignCommander->segmentationUpdateSerieActionCriteriaByObj(/* parameters */);
//  }

//  /**
//   * Tests CampaignCommander->segmentationUpdateSerieTrackableLinkCriteriaByObj()
//   */
//  public function testSegmentationUpdateSerieTrackableLinkCriteriaByObj()
//  {
//      // TODO Auto-generated CampaignCommanderTest->testSegmentationUpdateSerieTrackableLinkCriteriaByObj()
//      $this->markTestIncomplete("segmentationUpdateSerieTrackableLinkCriteriaByObj test not implemented");
//      $this->campaignCommander->segmentationUpdateSerieTrackableLinkCriteriaByObj(/* parameters */);
//  }

//  /**
//   * Tests CampaignCommander->segmentationUpdateSocialNetworkCriteriaByObj()
//   */
//  public function testSegmentationUpdateSocialNetworkCriteriaByObj()
//  {
//      // TODO Auto-generated CampaignCommanderTest->testSegmentationUpdateSocialNetworkCriteriaByObj()
//      $this->markTestIncomplete("segmentationUpdateSocialNetworkCriteriaByObj test not implemented");
//      $this->campaignCommander->segmentationUpdateSocialNetworkCriteriaByObj(/* parameters */);
//  }

//  /**
//   * Tests CampaignCommander->segmentationUpdateRecencyCriteriaByObj()
//   */
//  public function testSegmentationUpdateRecencyCriteriaByObj()
//  {
//      // TODO Auto-generated CampaignCommanderTest->testSegmentationUpdateRecencyCriteriaByObj()
//      $this->markTestIncomplete("segmentationUpdateRecencyCriteriaByObj test not implemented");
//      $this->campaignCommander->segmentationUpdateRecencyCriteriaByObj(/* parameters */);
//  }

//  /**
//   * Tests CampaignCommander->segmentationUpdateDataMartCriteriaByObj()
//   */
//  public function testSegmentationUpdateDataMartCriteriaByObj()
//  {
//      // TODO Auto-generated CampaignCommanderTest->testSegmentationUpdateDataMartCriteriaByObj()
//      $this->markTestIncomplete("segmentationUpdateDataMartCriteriaByObj test not implemented");
//      $this->campaignCommander->segmentationUpdateDataMartCriteriaByObj(/* parameters */);
//  }

    /**
     * Tests CampaignCommander->segmentationCount()
     */
    public function testSegmentationCount()
    {
        $this->assertType('integer', $this->campaignCommander->segmentationCount('1104998848'));
    }

    /**
     * Tests CampaignCommander->segmentationDistinctCount()
     */
    public function testSegmentationDistinctCount()
    {
        $this->assertType('integer', $this->campaignCommander->segmentationDistinctCount('1104998848'));
    }

    /**
     * Tests CampaignCommander->createCampaign()
     */
    public function testCreateCampaign()
    {
        $messageId = $this->campaignCommander->createEmailMessage('TEST (remove me)', '', 'subject', 'from', 'email@mhg.ccmdemail.net', 'to', '[EMV TEXTPART]body', 'utf-8', 'replyTo', 'replyTo@mail.be');
        $var = $this->campaignCommander->createCampaign('REMOVE ME', time(), $messageId, '1105024728');

        $this->assertType('string', $var);

        // cleanup
        $this->campaignCommander->deleteCampaign($var);
        $this->campaignCommander->deleteMessage($messageId);
    }

    /**
     * Tests CampaignCommander->createCampaignWithAnalytics()
     */
    public function testCreateCampaignWithAnalytics()
    {
        $messageId = $this->campaignCommander->createEmailMessage('TEST (remove me)', '', 'subject', 'from', 'email@mhg.ccmdemail.net', 'to', '[EMV TEXTPART]body', 'utf-8', 'replyTo', 'replyTo@mail.be');
        $var = $this->campaignCommander->createCampaignWithAnalytics('REMOVE ME', time(), $messageId, '1105024728');

        $this->assertType('string', $var);

        // cleanup
        $this->campaignCommander->deleteCampaign($var);
        $this->campaignCommander->deleteMessage($messageId);
    }

    /**
     * Tests CampaignCommander->createCampaignByObj()
     */
    public function testCreateCampaignByObj()
    {
        $messageId = $this->campaignCommander->createEmailMessage('TEST (remove me)', '', 'subject', 'from', 'email@mhg.ccmdemail.net', 'to', '[EMV TEXTPART]body', 'utf-8', 'replyTo', 'replyTo@mail.be');
        $var = $this->campaignCommander->createCampaignByObj(array(
            'id' => 0,
            'name' => 'REMOVE ME',
            'analytics' => true,
            'deliverySpeed' => false,
            'emaildedupflg' => true,
            'mailinglistId' => '1105024728',
            'notification' => false,
            'postClickTracking' => true,
            'messageId' => $messageId
        ));

        $this->assertType('string', $var);

        // cleanup
        $this->campaignCommander->deleteCampaign($var);
        $this->campaignCommander->deleteMessage($messageId);
    }

    /**
     * Tests CampaignCommander->deleteCampaign()
     */
    public function testDeleteCampaign()
    {
        $messageId = $this->campaignCommander->createEmailMessage('TEST (remove me)', '', 'subject', 'from', 'email@mhg.ccmdemail.net', 'to', '[EMV TEXTPART]body', 'utf-8', 'replyTo', 'replyTo@mail.be');
        $var = $this->campaignCommander->createCampaign('REMOVE ME', time(), $messageId, '1105024728');

        $this->assertTrue($this->campaignCommander->deleteCampaign($var));

        // cleanup
        $this->campaignCommander->deleteMessage($messageId);
    }

    /**
     * Tests CampaignCommander->updateCampaign()
     */
    public function testUpdateCampaign()
    {
        $messageId = $this->campaignCommander->createEmailMessage('TEST (remove me)', '', 'subject', 'from', 'email@mhg.ccmdemail.net', 'to', '[EMV TEXTPART]body', 'utf-8', 'replyTo', 'replyTo@mail.be');
        $var = $this->campaignCommander->createCampaign('REMOVE ME', time(), $messageId, '1105024728');

        $this->assertTrue($this->campaignCommander->updateCampaign($var, 'name', 'TEST 2 (remove me)'));

        // cleanup
        $this->campaignCommander->deleteMessage($messageId);
        $this->campaignCommander->deleteCampaign($var);
    }

    /**
     * Tests CampaignCommander->updateCampaignByObj()
     */
    public function testUpdateCampaignByObj()
    {
        $messageId = $this->campaignCommander->createEmailMessage('TEST (remove me)', '', 'subject', 'from', 'email@mhg.ccmdemail.net', 'to', '[EMV TEXTPART]body', 'utf-8', 'replyTo', 'replyTo@mail.be');
        $var = $this->campaignCommander->createCampaign('REMOVE ME', time(), $messageId, '1105024728');

        $this->assertTrue($this->campaignCommander->updateCampaignByObj(array(
            'id' => $var,
            'name' => 'TADA',
            'analytics' => true,
            'deliverySpeed' => null,
            'emaildedupflg' => true,
            'mailinglistId' => '1105024728',
            'notification' => false,
            'postClickTracking' => true
        )));

        // cleanup
        $this->campaignCommander->deleteMessage($messageId);
        $this->campaignCommander->deleteCampaign($var);
    }

//  /**
//   * Tests CampaignCommander->postCampaign()
//   */
//  public function testPostCampaign()
//  {
//      // TODO Auto-generated CampaignCommanderTest->testPostCampaign()
//      $this->markTestIncomplete("postCampaign test not implemented");
//      $this->campaignCommander->postCampaign(/* parameters */);
//  }

//  /**
//   * Tests CampaignCommander->unpostCampaign()
//   */
//  public function testUnpostCampaign()
//  {
//      // TODO Auto-generated CampaignCommanderTest->testUnpostCampaign()
//      $this->markTestIncomplete("unpostCampaign test not implemented");
//      $this->campaignCommander->unpostCampaign(/* parameters */);
//  }

    /**
     * Tests CampaignCommander->getCampaign()
     */
    public function testGetCampaign()
    {
        $this->assertObjectHasAttribute('id', $this->campaignCommander->getCampaign('1106582188'));
    }

    /**
     * Tests CampaignCommander->getCampaignsByField()
     */
    public function testGetCampaignsByField()
    {
        $this->assertType('array', $this->campaignCommander->getCampaignsByField('name', 'DC', 10));
    }

    /**
     * Tests CampaignCommander->getCampaignsByStatus()
     */
    public function testGetCampaignsByStatus()
    {
        $this->assertType('array', $this->campaignCommander->getCampaignsByStatus('COMPLETED'));
    }

    /**
     * Tests CampaignCommander->getCampaignsByPeriod()
     */
    public function testGetCampaignsByPeriod()
    {
        $this->assertType('array', $this->campaignCommander->getCampaignsByPeriod(1262300400, 1325372399));
    }

    /**
     * Tests CampaignCommander->getCampaignStatus()
     */
    public function testGetCampaignStatus()
    {
        $this->assertEquals('Tracking', $this->campaignCommander->getCampaignStatus('1106582188'));
    }

    /**
     * Tests CampaignCommander->getLastCampaigns()
     */
    public function testGetLastCampaigns()
    {
        $this->assertType('array', $this->campaignCommander->getLastCampaigns(10));
    }

//  /**
//   * Tests CampaignCommander->testCampaignByGroup()
//   */
//  public function testTestCampaignByGroup()
//  {
//      // TODO Auto-generated CampaignCommanderTest->testTestCampaignByGroup()
//      $this->markTestIncomplete("testCampaignByGroup test not implemented");
//      $this->campaignCommander->testCampaignByGroup(/* parameters */);
//  }

//  /**
//   * Tests CampaignCommander->testCampaignByMember()
//   */
//  public function testTestCampaignByMember()
//  {
//      // TODO Auto-generated CampaignCommanderTest->testTestCampaignByMember()
//      $this->markTestIncomplete("testCampaignByMember test not implemented");
//      $this->campaignCommander->testCampaignByMember(/* parameters */);
//  }

//  /**
//   * Tests CampaignCommander->pauseCampaign()
//   */
//  public function testPauseCampaign()
//  {
//      // TODO Auto-generated CampaignCommanderTest->testPauseCampaign()
//      $this->markTestIncomplete("pauseCampaign test not implemented");
//      $this->campaignCommander->pauseCampaign(/* parameters */);
//  }

//  /**
//   * Tests CampaignCommander->unpauseCampaign()
//   */
//  public function testUnpauseCampaign()
//  {
//      // TODO Auto-generated CampaignCommanderTest->testUnpauseCampaign()
//      $this->markTestIncomplete("unpauseCampaign test not implemented");
//      $this->campaignCommander->unpauseCampaign(/* parameters */);
//  }

//  /**
//   * Tests CampaignCommander->getCampaignSnapshotReport()
//   */
//  public function testGetCampaignSnapshotReport()
//  {
//      // TODO Auto-generated CampaignCommanderTest->testGetCampaignSnapshotReport()
//      $this->markTestIncomplete("getCampaignSnapshotReport test not implemented");
//      $this->campaignCommander->getCampaignSnapshotReport(/* parameters */);
//  }

    /**
     * Tests CampaignCommander->createBanner()
     */
    public function testCreateBanner()
    {
        $var = $this->campaignCommander->createBanner('REMOVE ME', 'TEXT', null, 'BODY');
        $this->assertType('string', $var);

        // cleanup
        $this->campaignCommander->deleteBanner($var);
    }

    /**
     * Tests CampaignCommander->createBannerByObj()
     */
    public function testCreateBannerByObj()
    {
        $var = $this->campaignCommander->createBannerByObj(array(
            'id' => 0,
            'content' => 'BODY',
            'contentType' => 'TEXT',
            'name' => 'REMOVE ME'
        ));
        $this->assertType('string', $var);

        // cleanup
        $this->campaignCommander->deleteBanner($var);
    }

    /**
     * Tests CampaignCommander->deleteBanner()
     */
    public function testDeleteBanner()
    {
        $var = $this->campaignCommander->createBanner('REMOVE ME', 'TEXT', null, 'BODY');
        $this->assertTrue($this->campaignCommander->deleteBanner($var));
    }

    /**
     * Tests CampaignCommander->updateBanner()
     */
    public function testUpdateBanner()
    {
        $var = $this->campaignCommander->createBanner('REMOVE ME', 'TEXT', null, 'BODY');
        $this->assertTrue($this->campaignCommander->updateBanner($var, 'name', 'TEMP'));

        // cleanup
        $this->campaignCommander->deleteBanner($var);
    }

//  /**
//   * Tests CampaignCommander->updateBannerByObj()
//   */
//  public function testUpdateBannerByObj()
//  {
//      // TODO Auto-generated CampaignCommanderTest->testUpdateBannerByObj()
//      $this->markTestIncomplete("updateBannerByObj test not implemented");
//      $this->campaignCommander->updateBannerByObj(/* parameters */);
//  }

    /**
     * Tests CampaignCommander->cloneBanner()
     */
    public function testCloneBanner()
    {
        $var = $this->campaignCommander->createBanner('REMOVE ME', 'TEXT', null, 'BODY');
        $var2 = $this->campaignCommander->cloneBanner($var, 'NEW');

        $this->assertType('string', $var2);

        // cleanup
        $this->campaignCommander->deleteBanner($var);
        $this->campaignCommander->deleteBanner($var2);
    }

    /**
     * Tests CampaignCommander->getBannerPreview()
     */
    public function testGetBannerPreview()
    {
        $this->assertType('string', $this->campaignCommander->getBannerPreview('1018382'));
    }

    /**
     * Tests CampaignCommander->getBanner()
     */
    public function testGetBanner()
    {
        $this->assertObjectHasAttribute('id', $this->campaignCommander->getBanner('1018382'));
    }

    /**
     * Tests CampaignCommander->getBannersByField()
     */
    public function testGetBannersByField()
    {
        $this->assertType('array', $this->campaignCommander->getBannersByField('name', 'KAL', 10));
    }

    /**
     * Tests CampaignCommander->getBannersByPeriod()
     */
    public function testGetBannersByPeriod()
    {
        $this->assertType('array', $this->campaignCommander->getBannersByPeriod(1262300400, 1325372399));
    }

    /**
     * Tests CampaignCommander->getLastBanners()
     */
    public function testGetLastBanners()
    {
        $this->assertType('array', $this->campaignCommander->getLastBanners(10));
    }

//  /**
//   * Tests CampaignCommander->trackAllBannerLinks()
//   */
//  public function testTrackAllBannerLinks()
//  {
//      // TODO Auto-generated CampaignCommanderTest->testTrackAllBannerLinks()
//      $this->markTestIncomplete("trackAllBannerLinks test not implemented");
//      $this->campaignCommander->trackAllBannerLinks(/* parameters */);
//  }

//  /**
//   * Tests CampaignCommander->untrackAllBannerLinks()
//   */
//  public function testUntrackAllBannerLinks()
//  {
//      // TODO Auto-generated CampaignCommanderTest->testUntrackAllBannerLinks()
//      $this->markTestIncomplete("untrackAllBannerLinks test not implemented");
//      $this->campaignCommander->untrackAllBannerLinks(/* parameters */);
//  }

//  /**
//   * Tests CampaignCommander->trackBannerLinkByPosition()
//   */
//  public function testTrackBannerLinkByPosition()
//  {
//      // TODO Auto-generated CampaignCommanderTest->testTrackBannerLinkByPosition()
//      $this->markTestIncomplete("trackBannerLinkByPosition test not implemented");
//      $this->campaignCommander->trackBannerLinkByPosition(/* parameters */);
//  }

//  /**
//   * Tests CampaignCommander->untrackBannerLinkByOrder()
//   */
//  public function testUntrackBannerLinkByOrder()
//  {
//      // TODO Auto-generated CampaignCommanderTest->testUntrackBannerLinkByOrder()
//      $this->markTestIncomplete("untrackBannerLinkByOrder test not implemented");
//      $this->campaignCommander->untrackBannerLinkByOrder(/* parameters */);
//  }

    /**
     * Tests CampaignCommander->getAllBannerTrackedLinks()
     */
    public function testGetAllBannerTrackedLinks()
    {
        $this->assertType('array', $this->campaignCommander->getAllBannerTrackedLinks('1018382'));
    }

//  /**
//   * Tests CampaignCommander->getAllUnusedBannerTrackedLinks()
//   */
//  public function testGetAllUnusedBannerTrackedLinks()
//  {
//      $this->assertType('array', $this->campaignCommander->getAllUnusedBannerTrackedLinks('1018382'));
//  }

//  /**
//   * Tests CampaignCommander->getAllBannerTrackableLinks()
//   */
//  public function testGetAllBannerTrackableLinks()
//  {
//      $this->assertType('array', $this->campaignCommander->getAllBannerTrackableLinks('1018382'));
//  }

//  /**
//   * Tests CampaignCommander->createStandardBannerLink()
//   */
//  public function testCreateStandardBannerLink()
//  {
//      // TODO Auto-generated CampaignCommanderTest->testCreateStandardBannerLink()
//      $this->markTestIncomplete("createStandardBannerLink test not implemented");
//      $this->campaignCommander->createStandardBannerLink(/* parameters */);
//  }

//  /**
//   * Tests CampaignCommander->createAndAddStandardBannerLink()
//   */
//  public function testCreateAndAddStandardBannerLink()
//  {
//      // TODO Auto-generated CampaignCommanderTest->testCreateAndAddStandardBannerLink()
//      $this->markTestIncomplete("createAndAddStandardBannerLink test not implemented");
//      $this->campaignCommander->createAndAddStandardBannerLink(/* parameters */);
//  }

//  /**
//   * Tests CampaignCommander->createUnsubscribeBannerLink()
//   */
//  public function testCreateUnsubscribeBannerLink()
//  {
//      // TODO Auto-generated CampaignCommanderTest->testCreateUnsubscribeBannerLink()
//      $this->markTestIncomplete("createUnsubscribeBannerLink test not implemented");
//      $this->campaignCommander->createUnsubscribeBannerLink(/* parameters */);
//  }

//  /**
//   * Tests CampaignCommander->createAndAddUnsubscribeBannerLink()
//   */
//  public function testCreateAndAddUnsubscribeBannerLink()
//  {
//      // TODO Auto-generated CampaignCommanderTest->testCreateAndAddUnsubscribeBannerLink()
//      $this->markTestIncomplete("createAndAddUnsubscribeBannerLink test not implemented");
//      $this->campaignCommander->createAndAddUnsubscribeBannerLink(/* parameters */);
//  }

//  /**
//   * Tests CampaignCommander->createPersonalisedBannerLink()
//   */
//  public function testCreatePersonalisedBannerLink()
//  {
//      // TODO Auto-generated CampaignCommanderTest->testCreatePersonalisedBannerLink()
//      $this->markTestIncomplete("createPersonalisedBannerLink test not implemented");
//      $this->campaignCommander->createPersonalisedBannerLink(/* parameters */);
//  }

//  /**
//   * Tests CampaignCommander->createAndAddPersonalisedBannerLink()
//   */
//  public function testCreateAndAddPersonalisedBannerLink()
//  {
//      // TODO Auto-generated CampaignCommanderTest->testCreateAndAddPersonalisedBannerLink()
//      $this->markTestIncomplete("createAndAddPersonalisedBannerLink test not implemented");
//      $this->campaignCommander->createAndAddPersonalisedBannerLink(/* parameters */);
//  }

//  /**
//   * Tests CampaignCommander->createUpdateBannerLink()
//   */
//  public function testCreateUpdateBannerLink()
//  {
//      // TODO Auto-generated CampaignCommanderTest->testCreateUpdateBannerLink()
//      $this->markTestIncomplete("createUpdateBannerLink test not implemented");
//      $this->campaignCommander->createUpdateBannerLink(/* parameters */);
//  }

//  /**
//   * Tests CampaignCommander->createAndAddUpdateBannerLink()
//   */
//  public function testCreateAndAddUpdateBannerLink()
//  {
//      // TODO Auto-generated CampaignCommanderTest->testCreateAndAddUpdateBannerLink()
//      $this->markTestIncomplete("createAndAddUpdateBannerLink test not implemented");
//      $this->campaignCommander->createAndAddUpdateBannerLink(/* parameters */);
//  }

//  /**
//   * Tests CampaignCommander->createActionBannerLink()
//   */
//  public function testCreateActionBannerLink()
//  {
//      // TODO Auto-generated CampaignCommanderTest->testCreateActionBannerLink()
//      $this->markTestIncomplete("createActionBannerLink test not implemented");
//      $this->campaignCommander->createActionBannerLink(/* parameters */);
//  }

//  /**
//   * Tests CampaignCommander->createAndAddActionBannerLink()
//   */
//  public function testCreateAndAddActionBannerLink()
//  {
//      // TODO Auto-generated CampaignCommanderTest->testCreateAndAddActionBannerLink()
//      $this->markTestIncomplete("createAndAddActionBannerLink test not implemented");
//      $this->campaignCommander->createAndAddActionBannerLink(/* parameters */);
//  }

//  /**
//   * Tests CampaignCommander->createMirrorBannerLink()
//   */
//  public function testCreateMirrorBannerLink()
//  {
//      // TODO Auto-generated CampaignCommanderTest->testCreateMirrorBannerLink()
//      $this->markTestIncomplete("createMirrorBannerLink test not implemented");
//      $this->campaignCommander->createMirrorBannerLink(/* parameters */);
//  }

//  /**
//   * Tests CampaignCommander->createAndAddMirrorBannerLink()
//   */
//  public function testCreateAndAddMirrorBannerLink()
//  {
//      // TODO Auto-generated CampaignCommanderTest->testCreateAndAddMirrorBannerLink()
//      $this->markTestIncomplete("createAndAddMirrorBannerLink test not implemented");
//      $this->campaignCommander->createAndAddMirrorBannerLink(/* parameters */);
//  }

//  /**
//   * Tests CampaignCommander->updateBannerLinkByField()
//   */
//  public function testUpdateBannerLinkByField()
//  {
//      // TODO Auto-generated CampaignCommanderTest->testUpdateBannerLinkByField()
//      $this->markTestIncomplete("updateBannerLinkByField test not implemented");
//      $this->campaignCommander->updateBannerLinkByField(/* parameters */);
//  }

//  /**
//   * Tests CampaignCommander->getBannerLinkByOrder()
//   */
//  public function testGetBannerLinkByOrder()
//  {
//      // TODO Auto-generated CampaignCommanderTest->testGetBannerLinkByOrder()
//      $this->markTestIncomplete("getBannerLinkByOrder test not implemented");
//      $this->campaignCommander->getBannerLinkByOrder(/* parameters */);
//  }

    /**
     * Tests CampaignCommander->createTestGroup()
     */
    public function testCreateTestGroup()
    {
        $var = $this->campaignCommander->createTestGroup('REMOVE ME');
        $this->assertType('string', $var);

        // cleanup
        $this->campaignCommander->deleteTestGroup($var);
    }

//  /**
//   * Tests CampaignCommander->createTestGroupByObj()
//   */
//  public function testCreateTestGroupByObj()
//  {
//      // TODO Auto-generated CampaignCommanderTest->testCreateTestGroupByObj()
//      $this->markTestIncomplete("createTestGroupByObj test not implemented");
//      $this->campaignCommander->createTestGroupByObj(/* parameters */);
//  }

    /**
     * Tests CampaignCommander->addTestMember()
     */
    public function testAddTestMember()
    {
        $var = $this->campaignCommander->createTestGroup('REMOVE ME');
        $this->assertTrue($this->campaignCommander->addTestMember('1048473894275', $var));

        // cleanup
        $this->campaignCommander->removeTestMember('1048473894275', $var);
        $this->campaignCommander->deleteTestGroup($var);
    }

    /**
     * Tests CampaignCommander->removeTestMember()
     */
    public function testRemoveTestMember()
    {
        $var = $this->campaignCommander->createTestGroup('REMOVE ME');
        $this->campaignCommander->addTestMember('1048473894275', $var);
        $this->assertTrue($this->campaignCommander->removeTestMember('1048473894275', $var));

        // cleanup
        $this->campaignCommander->deleteTestGroup($var);
    }

    /**
     * Tests CampaignCommander->deleteTestGroup()
     */
    public function testDeleteTestGroup()
    {
        $var = $this->campaignCommander->createTestGroup('REMOVE ME');
        $this->assertTrue($this->campaignCommander->deleteTestGroup($var));
    }

    /**
     * Tests CampaignCommander->updateTestGroupByObj()
     */
    public function testUpdateTestGroupByObj()
    {
        $var = $this->campaignCommander->createTestGroup('REMOVE ME');

        $this->assertTrue($this->campaignCommander->updateTestGroupByObj(array(
            'id' => $var,
            'name' => 'REMOVE ME'
        )));

        // cleanup
        $this->campaignCommander->deleteTestGroup($var);
    }

    /**
     * Tests CampaignCommander->getTestGroup()
     */
    public function testGetTestGroup()
    {
        $this->assertObjectHasAttribute('id', $this->campaignCommander->getTestGroup('1000137610'));
    }

    /**
     * Tests CampaignCommander->getClientTestGroups()
     */
    public function testGetClientTestGroups()
    {
        $this->assertType('array', $this->campaignCommander->getClientTestGroups());
    }
}
