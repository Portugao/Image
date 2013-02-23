<?php
/**
 * Tagged object meta class.
 */
class MUImage_TaggedObjectMeta_MUImage extends Tag_AbstractTaggedObjectMeta
{
	/**
	 * Construct.
	 *
	 * @param int $objectId Object ID.
	 * @param int $areaId A blockinfo structure.
	 * @param string $module Module.
	 * @param string $urlString Url.
	 * @param Zikula_ModUrl $urlObject Url object.
	 */
	function __construct($objectId, $areaId, $module, $urlString = null, Zikula_ModUrl $urlObject = null)
	{
		parent::__construct($objectId, $areaId, $module, $urlString, $urlObject);
		
		/*if ($urlObject == 'album') {*/
			$album = ModUtil::apiFunc('MUImage', 'selection', 'getEntity', array('ot' => 'album', 'id' => $this->getObjectId()));
			// the Api checks for perms and there is nothing else to check
			if ($album) {
				$userid = $album->getCreatedUserId();
				$date = $album->getCreatedDate();
				$title = $album->getTitle();
				$this->setObjectAuthor(UserUtil::getVar('uname', $userid));
				$this->setObjectDate($date);
				$this->setObjectTitle($title);
			}
		/*}

		if ($urlObject == 'picture') {
			$where = 'tbl.id = \'' . DataUtil::formatForStore($this->getObjectId()) . '\'';
			$picture = ModUtil::apiFunc('MUImage', 'selection', 'getEntities', array('ot' => 'picture', 'where' => $where));
			// the Api checks for perms and there is nothing else to check
			if ($picture) {
				$this->setObjectAuthor(UserUtil::getVar('uname', $picture[0]['createdUserId']));
				$this->setObjectDate($picture[0]['createdUserId']);
				$this->setObjectTitle($picture[0]['title']);
			}
			LogUtil::registerStatus($picture[0]['title']);
		}*/
	}

	/**
	 * Set object title.
	 *
	 * @param string $title Object title.
	 */
	public function setObjectTitle($title)
	{
		$this->title = $title;
	}

	/**
	 * Set object date.
	 *
	 * @param string $date Date.
	 */
	public function setObjectDate($date)
	{
		$this->date = DateUtil::formatDatetime($date, 'datetimebrief');
	}

	/**
	 * Set object author.
	 *
	 * @param string $author Object author.
	 */
	public function setObjectAuthor($author)
	{
		$this->author = $author;
	}
}