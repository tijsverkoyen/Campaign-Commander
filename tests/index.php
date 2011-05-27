<?php

// require
require_once 'config.php';
require_once '../campaign_commander.php';

// create instance
$ccm = new CampaignCommander(LOGIN, PASSWORD, KEY);

// @todo test me $response = $ccm->createEmailMessage($name, $description, $subject, $from, $fromEmail, $to, $body, $encoding, $replyTo, $replyToEmail, $bounceback = false, $unsubscribe = false, $unsublinkpage = null);
// @todo test me $response = $ccm->createEmailMessageByObj(array $message);
// @todo test me $response = $ccm->createSmsMessage($name, $desc, $from, $body);
// @todo test me $response = $ccm->createSmsMessageByObj(array $message);
// @todo test me $response = $ccm->deleteMessage($id);
// @todo test me $response = $ccm->updateMessage($id, $field, $value);
// @todo test me $response = $ccm->updateMessageByObj(array $message);
// @todo test me $response = $ccm->cloneMessage($id, $newName);
//$response = $ccm->getMessage('1104992528');
//$response = $ccm->getLastEmailMessages(10);
//$response = $ccm->getLastSmsMessages(10);
//$response = $ccm->getEmailMessagesByField('from', 'Capitole Gent', 10);
// @todo test me $response = $ccm->getSmsMessagesByField($field, $value, $limit);
//$response = $ccm->getMessagesByPeriod(mktime(00, 00, 00, 01, 01, 2010), mktime(23, 59, 59, 12, 31, 2010));
//$response = $ccm->getEmailMessagePreview('1104992528');
// @todo test me $response = $ccm->getSmsMessagePreview($messageId);
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

// @todo test me $response = $ccm->segmentationCreateSegment($name, $sampleType, $description = null, $sampleRate = null);
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

// @todo test me $response = $ccm->createCampaign($name, $sendDate, $messageId, $mailingListId, $description = null, $notifProgress = false, $postClickTracking = false, $emaildedupfig = false);
// @todo test me $response = $ccm->createCampaignWithAnalytics($name, $sendDate, $messageId, $mailingListId, $description = null, $notifProgress = false, $postClickTracking = false, $emaildedupfig = false);
// @todo test me $response = $ccm->createCampaignByObj(array $campaign);
// @todo test me $response = $ccm->deleteCampaign($id);
// @todo test me $response = $ccm->updateCampaign($id, $field, $value);
// @todo test me $response = $ccm->updateCampaignByObj(array $campaign);
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

// @todo test me $response = $ccm->createBanner($name, $contentType, $description = null, $content = null);
// @todo test me $response = $ccm->createBannerByObj(array $banner);
// @todo test me $response = $ccm->deleteBanner($id);
// @todo test me $response = $ccm->updateBanner($id, $field, $value = null);
// @todo test me $response = $ccm->updateBannerByObj(array $banner);
// @todo test me $response = $ccm->cloneBanner($id, $name);
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

// @todo test me $response = $ccm->createTestGroup($name);
// @todo test me $response = $ccm->createTestGroupByObj(array $testGroup);
// @todo test me $response = $ccm->addTestMember($memberId, $groupId);
// @todo test me $response = $ccm->removeTestMember($memberId, $groupId);
// @todo test me $response = $ccm->deleteTestGroup($groupId);
// @todo test me $response = $ccm->updateTestGroupByObj(array $testGroup);
//$response = $ccm->getTestGroup('1000137610');
$response = $ccm->getClientTestGroups();

// output (Spoon::dump())
ob_start();
var_dump($response);
$output = ob_get_clean();

// cleanup the output
$output = preg_replace('/\]\=\>\n(\s+)/m', '] => ', $output);

// print
echo '<pre>' . htmlspecialchars($output, ENT_QUOTES, 'UTF-8') . '</pre>';

?>