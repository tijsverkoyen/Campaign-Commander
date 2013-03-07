<?php

// require
require_once 'config.php';
require_once '../campaign_commander.php';

// create instance
$ccm = new CampaignCommander(LOGIN, PASSWORD, KEY);

//$response = $ccm->createEmailMessage('TEST (remove me)', '', 'subject', 'from', 'email@mhg.ccmdemail.net', 'to', '[EMV TEXTPART]body', 'utf-8', 'replyTo', 'replyTo@mail.be');
//$response = $ccm->createEmailMessageByObj(array(
//	'body' => '[EMV TEXTPART]body',
//	'isBounceback' => 0,
//	'description' => 'blaat',
//	'encoding' => 'utf-8',
//	'from' => 'from',
//	'fromEmail' => 'email@mhg.ccmdemail.net',
//	'id' => 0,
//	'name' => 'TEST (remove me)',
//	'replyTo' => 'replyTo',
//	'replyToEmail' => 'replyTo@mail.be',
//	'subject' => 'subject',
//	'to' => 'to',
//	'hotmailUnsubFlg' => 0
//));
//$response = $ccm->createSmsMessage('REMOVE ME', '', 'from', '[EMV SMSPART]body');
//$response = $ccm->createSmsMessageByObj(array(
//	'id' => 0,
//	'name' => 'REMOVE ME',
//	'body' => '[EMV SMSPART]body',
//	'type' => 'SMS',
//	'hotmailUnsubFlg' => false,
//	'isBounceback' => false
//));
//$response = $ccm->deleteMessage('1105239351');
//$response = $ccm->updateMessage('1105008095', 'name', 'REMOVE ME');
//$response = $ccm->updateMessageByObj(array(
//	'body' => '[EMV TEXTPART]body',
//	'isBounceback' => 0,
//	'description' => '',
//	'encoding' => 'utf-8',
//	'from' => 'from',
//	'fromEmail' => 'email@mhg.ccmdemail.net',
//	'id' => '1105009685',
//	'name' => 'REMOVE ME',
//	'replyTo' => 'replyTo',
//	'replyToEmail' => 'replyTo@mail.be',
//	'subject' => 'subject',
//	'to' => 'to',
//	'hotmailUnsubFlg' => 0
//));
//$response = $ccm->cloneMessage('1105008095', 'REMOVE ME TO');
//$response = $ccm->getMessage('1104992528');
//$response = $ccm->getLastEmailMessages(10);
//$response = $ccm->getLastSmsMessages(10);
//$response = $ccm->getEmailMessagesByField('from', 'Capitole Gent', 10);
//$response = $ccm->getSmsMessagesByField('name', 'REMOVE', 10);
//$response = $ccm->getMessagesByPeriod(mktime(00, 00, 00, 01, 01, 2010), mktime(23, 59, 59, 12, 31, 2010));
//$response = $ccm->getEmailMessagePreview('1104992528');
//$response = $ccm->getSmsMessagePreview('1105009621');
// @todo test me $response = $ccm->trackAllLinks($id);
// @todo test me $response = $ccm->untrackAllLinks($id);
// @todo test me $response = $ccm->trackLinkByPosition($id, $position, $part = 'HTML');
//$response = $ccm->getAllTrackedLinks('1104992528');
//$response = $ccm->getAllUnusedTrackedLinks('1104992528');
//$response = $ccm->getAllTrackableLinks('1104992528');
// @todo test me $response = $ccm->testEmailMessageByGroup($id, $groupId, $campaignName, $subject, $part = 'MULTIPART');
// @todo test me $response = $ccm->testEmailMessageByMember($id, $memberId, $campaignName, $subject, $part = 'MULTIPART');
// @todo test me $response = $ccm->testSmsMessage($id, $memberId, $campaignName);
//$response = $ccm->getDefaultSender();
//$response = $ccm->getValidatedAltSenders();
//$response = $ccm->getNotValidatedSenders();

// @todo test me $response = $ccm->createStandardUrl($messageId, $name, $url);
// @todo test me $response = $ccm->createAndAddStandardUrl($messageId, $name, $url);
// @todo test me $response = $ccm->createUnsubscribeUrl($messageId, $name, $pageOk = null, $messageOk = null, $pageError = null, $messageError = null);
// @todo test me $response = $ccm->createAndAddUnsubscribeUrl($messageId, $name, $pageOk = null, $messageOk = null, $pageError = null, $messageError = null);
// @todo test me $response = $ccm->createPersonalisedUrl($messageId, $name, $url);
// @todo test me $response = $ccm->createAndAddPersonalisedUrl($messageId, $name, $url);
// @todo test me $response = $ccm->createUpdateUrl($messageId, $name, $parameters, $pageOk, $messageOk, $pageError, $messageError);
// @todo test me $response = $ccm->createAndAddUpdateUrl($messageId, $name, $parameters, $pageOk, $messageOk, $pageError, $messageError);
// @todo test me $response = $ccm->createActionUrl($messageId, $name, $action, $pageOk = null, $messageOk = null, $pageError = null, $messageError = null);
// @todo test me $response = $ccm->createdAndAddActionUrl($messageId, $name, $action, $pageOk = null, $messageOk = null, $pageError = null, $messageError = null);
// @todo test me $response = $ccm->createMirrorUrl($messageId, $name);
// @todo test me $response = $ccm->createAndAddMirrorUrl($messageId, $name);
// @todo test me $response = $ccm->addShareLink($messageId, $linkType, $buttonUrl = null, $language = null);
// @todo test me $response = $ccm->updateUrlByField($messageId, $order, $field, $value);
// @todo test me $response = $ccm->deleteUrl($messageId, $order);
// @todo test me $response = $ccm->getUrlByOrder('1104992528', 1);

//$response = $ccm->segmentationCreateSegment('REMOVEME', 'ALL');
// @todo test me $response = $ccm->segmentationDeleteSegment($id);
// @todo test me $response = $ccm->segmentationAddStringDemographicCriteriaByObj(array $stringDemographicCriteria);
// @todo test me $response = $ccm->segmentationAddNumericDemographicCriteriaByObj(array $numericDemographicCriteria);
// @todo test me $response = $ccm->segmentationAddDateDemographicCriteriaByObj(array $dateDemographicCriteria);
// @todo test me $response = $ccm->segmentationAddCampaignActionCriteriaByObj(array $actionCriteria);
// @todo test me $response = $ccm->segmentationAddCampaignTrackableLinkCriteriaByObj(array $trackableLinkCriteria);
// @todo test me $response = $ccm->segmentationAddSerieActionCriteriaByObj(array $actionCriteria);
// @todo test me $response = $ccm->segmentationAddSerieTrackableLinkCriteriaByObj(array $trackableLinkCriteria);
// @todo test me $response = $ccm->segmentationAddSocialNetworkCriteriaByObj(array $socialNetworkCriteria);
// @todo test me $response = $ccm->segmentationAddRecencyCriteriaByObj(array $recencyCriteria);
// @todo test me $response = $ccm->segmentationAddDataMartCriteriaByObj(array $dataMartCriteria);
//$response = $ccm->segmentationGetSegmentById('1104998848');
//$response = $ccm->segmentationGetSegmentList(1, 10);
//$response = $ccm->segmentationGetSegmentCriterias('1104998848');
//$response = $ccm->segmentationGetPersoFragList(1, 10);
// @todo test me $response = $ccm->segmentationDeleteCriteria($id, $orderCriteria);
// @todo test me $response = $ccm->segmentationUpdateSegment($id, $name, $sampleType, $sampleRate = null);
// @todo test me $response = $ccm->segmentationUpdateStringDemographicCriteriaByObj(array $stringDemographicCriteria);
// @todo test me $response = $ccm->segmentationUpdateNumericDemographicCriteriaByObj(array $numericDemographicCriteria);
// @todo test me $response = $ccm->segmentationUpdateDateDemographicCriteriaByObj(array $dateDemographicCriteria);
// @todo test me $response = $ccm->segmentationUpdateCampaignActionCriteriaByObj(array $actionCriteria);
// @todo test me $response = $ccm->segmentationUpdateCampaignTrackableLinkCriteriaByObj(array $trackableLinkCriteria);
// @todo test me $response = $ccm->segmentationUpdateSerieActionCriteriaByObj(array $actionCriteria);
// @todo test me $response = $ccm->segmentationUpdateSerieTrackableLinkCriteriaByObj(array $trackableLinkCriteria);
// @todo test me $response = $ccm->segmentationUpdateSocialNetworkCriteriaByObj(array $socialNetworkCriteria);
// @todo test me $response = $ccm->segmentationUpdateRecencyCriteriaByObj(array $recencyCriteria);
// @todo test me $response = $ccm->segmentationUpdateDataMartCriteriaByObj(array $dataMartCriteria);
//$response = $ccm->segmentationCount('1104998848');
//$response = $ccm->segmentationDistinctCount('1104998848');

//$response = $ccm->createCampaign('REMOVE ME', mktime(00, 00, 00, 06, 20, 2025), 1105236574, 1105024728);
//$response = $ccm->createCampaignWithAnalytics('REMOVE ME', time(), 1105016566, 1105024728);
//$response = $ccm->createCampaignByObj(array(
//	'id' => 0,
//	'name' => 'REMOVE ME',
//	'analytics' => true,
//	'deliverySpeed' => false,
//	'emaildedupflg' => true,
//	'mailinglistId' => '1105024728',
//	'notification' => false,
//	'postClickTracking' => true,
//	'messageId' => '1105016566'
//));
//$response = $ccm->deleteCampaign('1108005887');
//$response = $ccm->updateCampaign('1108284680', 'name', 'REMOVE ME (2)');
//$response = $ccm->updateCampaignByObj(array(
//	'id' => '1108284680',
//	'name' => 'TADA',
//	'analytics' => true,
//	'deliverySpeed' => null,
//	'emaildedupflg' => true,
//	'mailinglistId' => '1105024728',
//	'notification' => false,
//	'postClickTracking' => true
//));
// @todo test me $response = $ccm->postCampaign($id);
// @todo test me $response = $ccm->unpostCampaign($id);
//$response = $ccm->getCampaign('1106582188');
//$response = $ccm->getCampaignsByField('name', 'DC', 10);
//$response = $ccm->getCampaignsByStatus('COMPLETED');
//$response = $ccm->getCampaignsByPeriod(mktime(00, 00, 00, 01, 01, 2010), mktime(23, 59, 59, 12, 31, 2010));
//$response = $ccm->getCampaignStatus('1106582188');
//$response = $ccm->getLastCampaigns(10);
// @todo test me $response = $ccm->testCampaignByGroup($id, $groupId);
// @todo test me $response = $ccm->testCampaignByMember($id, $memberId);
// @todo test me $response = $ccm->pauseCampaign($id);
// @todo test me $response = $ccm->unpauseCampaign($id);
// @todo internal error $response = $ccm->getCampaignSnapshotReport('1106582188');

//$response = $ccm->createBanner('REMOVE ME', 'TEXT', null, 'BODY');
//$response = $ccm->createBannerByObj(array(
//	'id' => 0,
//	'content' => 'BODY',
//	'contentType' => 'TEXT',
//	'name' => 'REMOVE ME'
//));
//$response = $ccm->deleteBanner('1022242');
//$response = $ccm->updateBanner('1020582', 'Name', 'TEMP');
// @todo Internal error $response = $ccm->updateBannerByObj(array(
//	'id' => '1022242',
//	'content' => 'MEKKER',
//	'name' => 'REMOVE ME'
//));
//$response = $ccm->cloneBanner('1022122', 'REMOVE ME (clone)');
//$response = $ccm->getBannerPreview('1018382');
//$response = $ccm->getBanner('1018382');
//$response = $ccm->getBannersByField('name', 'KAL MH Footer FR 04 2011', 10);
//$response = $ccm->getBannersByPeriod(mktime(00, 00, 00, 01, 01, 2010), mktime(23, 59, 59, 12, 31, 2011));
//$response = $ccm->getLastBanners(10);
// @todo test me $response = $ccm->trackAllBannerLinks('1018382');
// @todo test me $response = $ccm->untrackAllBannerLinks($id);
// @todo test me $response = $ccm->trackBannerLinkByPosition($id, $position);
// @todo test me $response = $ccm->untrackBannerLinkByOrder($id, $order);
//$response = $ccm->getAllBannerTrackedLinks('1018382');
//$response = $ccm->getAllUnusedBannerTrackedLinks('1018382');
//$response = $ccm->getAllBannerTrackableLinks('1018382');

// @todo test me $response = $ccm->createStandardBannerLink($id, $name, $url);
// @todo test me $response = $ccm->createAndAddStandardBannerLink($id, $name, $url);
// @todo test me $response = $ccm->createUnsubscribeBannerLink($id, $name, $pageOk = null, $messageOk = null, $pageError = null, $messageError = null);
// @todo test me $response = $ccm->createAndAddUnsubscribeBannerLink($id, $name, $pageOk = null, $messageOk = null, $pageError = null, $messageError = null);
// @todo test me $response = $ccm->createPersonalisedBannerLink($id, $name, $url);
// @todo test me $response = $ccm->createAndAddPersonalisedBannerLink($id, $name, $url);
// @todo test me $response = $ccm->createUpdateBannerLink($id, $name, $parameters, $pageOk = null, $messageOk = null, $pageError = null, $messageError = null);
// @todo test me $response = $ccm->createAndAddUpdateBannerLink($id, $name, $parameters, $pageOk = null, $messageOk = null, $pageError = null, $messageError = null);
// @todo test me $response = $ccm->createActionBannerLink($id, $name, $action, $pageOk = null, $messageOk = null, $pageError = null, $messageError = null);
// @todo test me $response = $ccm->createAndAddActionBannerLink($id, $name, $action, $pageOk = null, $messageOk = null, $pageError = null, $messageError = null);
// @todo test me $response = $ccm->createMirrorBannerLink($id, $name);
// @todo test me $response = $ccm->createAndAddMirrorBannerLink($id, $name);
// @todo test me $response = $ccm->updateBannerLinkByField($id, $order, $field, $value = null);
// @todo test me $response = $ccm->getBannerLinkByOrder($id, $order);

//$response = $ccm->createTestGroup('TEST');
// @todo Internal error $response = $ccm->createTestGroupByObj(array(
//	'id' => 0,
//	'name' => 'TEST'
//));
//$response = $ccm->addTestMember('1048473894275', '1000207911');
//$response = $ccm->removeTestMember('1048473894275', '1000207911');
//$response = $ccm->deleteTestGroup('1000208161');
//$response = $ccm->updateTestGroupByObj(array(
//	'id' => '1000208161',
//	'name' => 'REMOVE ME'
//));
//$response = $ccm->getTestGroup('1000207911');
//$response = $ccm->getClientTestGroups();

// output (Spoon::dump())
ob_start();
var_dump($response);
$output = ob_get_clean();

// cleanup the output
$output = preg_replace('/\]\=\>\n(\s+)/m', '] => ', $output);

// print
echo '<pre>' . htmlspecialchars($output, ENT_QUOTES, 'UTF-8') . '</pre>';
