<?
define("NO_AGENT_CHECK", true);
define("NO_KEEP_STATISTIC", true);
define("NOT_CHECK_PERMISSIONS", true);
global $USER;
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");
//title: Получить все вложения из задачи

$USER->Authorize(682);

try {
    Bitrix\Main\Loader::includeModule("tasks");
    Bitrix\Main\Loader::includeModule("disk");
} catch (\Bitrix\Main\SystemException $e) {
    die($e);
}

// Положим, наша заявка
$taskID = $_GET["ID"];

// Берем инстанс таска по его ИД с правами Администратора
// (второй аргумент - ид пользователя от имени которого производятся манипуляции)
$insTask = new \Bitrix\Tasks\Item\Task(intval($taskID), 0);
$arrTask = $insTask->getData();
$arrAttachmentIDs = $arrTask['UF_TASK_WEBDAV_FILES']->toArray(); // это не обязательно но я перестраховщик

// Теперь попробуем собрать массив, каждый член которого будет иметь имя файла и его содержимое в Base64
// Это так, для примера
$arTaskAttachments = [];

if (!empty($arrAttachmentIDs)) {
    foreach ($arrAttachmentIDs as $attachmentID) {
        $diskDriver = \Bitrix\Disk\Driver::getInstance();
        $objAttachment = $diskDriver->getUserFieldManager()->getAttachedObjectById(intval($attachmentID));
        // Так мы получили объект типа Вложение (Attachment). До самого файла нужно еще добраться.
        $objFile = $objAttachment->getObject();
        // И вот только теперь у нас - файл. Получим его имя и ИД.
        $fileID[] = "n".$objFile->getId();


	}
if ($fileID)
{
print_r($_GET);

$taskId =  $_GET["CID"];
$diskFileId = $fileID;
$handler = new Bitrix\Tasks\Control\Task(418);
try
{

	$task = $handler->update($taskId, [
		'UF_TASK_WEBDAV_FILES' => $fileID,
	]);
$n++;


}

catch (Exception $exception)
{
echo  $exception;
$USER->logout();
}

}

}
$USER->logout();

