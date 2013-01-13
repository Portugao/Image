<?php
/**
 * MUImage.
 *
 * @copyright Michael Ueberschaer
 * @license http://www.gnu.org/licenses/lgpl.html GNU Lesser General Public License
 * @package MUImage
 * @author Michael Ueberschaer <kontakt@webdesign-in-bremen.com>.
 * @link http://www.webdesign-in-bremen.com
 * @link http://zikula.org
 */

class MUImage_Api_Base_Import extends Zikula_AbstractApi
{
	public function handleImport($args) {
		
		if ($module == 'mediashare') {
			$this->insertOneAlbum($args);
		}

	}

	/**
	 *
	 * Set albums into the DB
	 * @param string $module   the module to handle
	 */
	private function setAlbums($module) {  // TODO can be deleted?

		// get the albums
		$albums = $this->getAlbums($module);
		// get query for insert
		$query = $this->buildQueryForAlbumInput($module);
		// for each album we handle the insert
		foreach ($albums as $result) {

			$data = $this->buildDatasForAlbum($module, $result);

		}
	}
	/**
	 *
	 * @param array $args
	 *
	 */
	public function insertOneAlbum($args) {

		$module = $args['module'];
		$folder = $args['folder'];
		$id = $args['album'];
		
		$albumrepository = MUImage_Util_Model::getAlbumRepository();

		$results = $this->getOneAlbum($module, $id);

		foreach ($results as $result) {
			$album[] = $result;
		}

		if (is_array($album)) {
			$data = $this->buildArrayForAlbum($module, $album[0]);
		}
		else {
			LogUtil::registerError('Could not build data array');
		}

		if (is_array($data)) {
			$serviceManager = ServiceUtil::getManager();
			$entityManager = $serviceManager->getService('doctrine.entitymanager');

			$newalbum = new MUImage_Entity_Album();
			$newalbum->setId($data[0]['id']);
			if ($data[0]['parent_id'] > 0) {
				$parentalbums = $this->getParentAlbum($module, $data[0]['parent_id']);
				foreach ($parentalbums as $parentalbum) {
					$mainAlbum[] = $parentalbum;
					$mainAlbumTitle = $mainAlbum[0]['ms_title'];
					$where = 'tbl.title = \'' . DataUtil::formatForStore($mainAlbumTitle) . '\'';
					$newparentAlbum = $albumrepository->selectWhere($where);
					$newparentAlbumObject = $albumrepository->selectById($newparentAlbum[0]['id']);					
				}
			}
			
			$newalbum->setParent($newparentAlbumObject);
			$newalbum->setTitle($data[0]['title']);
			$newalbum->setDescription($data[0]['description']);
			$newalbum->setCreatedUserId($data[0]['createdUserId']);
			$newalbum->setUpdatedUserId($data[0]['updatedUserId']);
			//$newalbum->setCreatedDate($data[0]['createdDate']);
			//$newalbum->setUpdatedDate($data[0]['updatedDate']);

			$entityManager->persist($newalbum);
			$entityManager->flush();//) { TODO here was if statement
			
			
			$where2 = 'tbl.title = \'' . DataUtil::formatForStore($data[0]['title']) . '\'';
			$thisalbum = $albumrepository->selectWhere($where2);
			$thisalbumobject = $albumrepository->selectById($thisalbum[0]['id']);			
					
				$resultpictures = $this->getPictures($module, $data[0]['id']);

				if (!empty($resultpictures)) {
					foreach ($resultpictures as $resultpicture) {
						$pictures[] = $resultpicture;
					}

					if (is_array($pictures)) {
						foreach ($pictures as $picture) {
							$data2 = $this->buildArrayForPicture($module, $picture);
							// we check if the item is a picture really
							if ($picture['ms_mediahandler'] != 'imagegd') {
								continue;
							}
							// if we have a guilty array for create a picture we do
							if (is_array($data2)) {
								$newpicture = new MUImage_Entity_Picture();
								$newpicture->setId($data2[0]['id']);
								$newpicture->setAlbum($thisalbumobject);
								$newpicture->setTitle($data2[0]['title']);
								$newpicture->setDescription($data2[0]['description']);
								
								// we get the original picture and its path
								$origpictures = $this->getFile($module, $picture['ms_originalid']);

								foreach ($origpictures as $origpicture) {
									$filepath[] = $origpicture;
								}
								// unset
								unset($origpictures);

								// we get the filename
								$file = explode('/', $filepath[0]['mss_fileref']);

								$newpicture->setImageUpload($file[1]);
								
								$clearpath = explode('.', $filepath[0]['mss_fileref']);
								$uploadHandler = new MUImage_UploadHandler();
								$meta = $uploadHandler->readMetaDataForFile($file[1], $folder . '/' . $filepath[0]['mss_fileref']);
								
								$newpicture->setImageUploadMeta($meta);
								copy($folder . '/' . $filepath[0]['mss_fileref'], 'userdata/MUImage/pictures/imageupload/' . $file[1]);
								$newpicture->setCreatedUserId($data2[0]['createdUserId']);
								$newpicture->setUpdatedUserId($data2[0]['updatedUserId']);
								//$newpicture->setCreatedDate($data2[0]['createdDate']);
								//$newpicture->setUpdatedDate($data2[0]['updatedDate']);
								unset($data2);
								unset($filepath);
								$entityManager->persist($newpicture);
								$entityManager->flush();
								
							}
							else {
								LogUtil::registerError('Invalid data pool for this picture');
							}
						}
					}
					else {
						LogUtil::registerError('No valid pictures');
					}
				}
				else {
					// nothing to do
				}
					
				return true;
			/*}
			else {
				return false;
			}*/
		}
		else {
			// nothing to do
		}

		return true;

	}

	/**
	 *
	 * @param string $module
	 * @param int $id
	 */
	private function insertAlbums($module, $id) {

	}

	/**
	 *
	 * Get the album with the relevant id
	 * @param string $module    the module to work with
	 * @param int    $id     id of the album
	 * @return an array of one album
	 */
	private function getOneAlbum($module, $id) {

		$table = $this->getTableForAlbum($module);

		$moduletable = $this->getPraefix(). $table;

		$connect = $this->getDBConnection();

		// ask the DB for entries in the module table
		// handle the access to the module album table
		// build sql
		$query = "SELECT * FROM $moduletable WHERE ms_id = $id";

		// prepare the sql query
		$sql = $connect->query($query);


		//$connect = null;

		return $sql;
	}
	
	/**
	 *
	 * Get the parent album with the relevant id
	 * @param string $module    the module to work with
	 * @param int    $id     id of the album
	 * @return an array of parent album
	 */
	private function getParentAlbum($module, $id) {
	
		$table = $this->getTableForAlbum($module);
	
		$moduletable = $this->getPraefix(). $table;
	
		$connect = $this->getDBConnection();
	
		// ask the DB for entries in the module table
		// handle the access to the module album table
		// build sql
		$query = "SELECT * FROM $moduletable WHERE ms_id = $id";
	
		// prepare the sql query
		$sql = $connect->query($query);
	
	
		//$connect = null;
	
		return $sql;
	}

	/**
	 *
	 * Get albums of module
	 * @param string $module    the module to work with
	 * @param int    $orig  the id of the original picture
	 * @return an array of one album
	 */
	private function getFile($module, $orig) {

		$sgl = null;
		$connect = null;
		$table = $this->getTableForFile($module);

		$moduletable = $this->getPraefix(). $table;

		$connect = $this->getDBConnection();

		// ask the DB for entries in the module table
		// handle the access to the module album table
		// build sql
		$query = "SELECT * FROM $moduletable WHERE mss_id = $orig";

		// prepare the sql query
		$sql = $connect->query($query);


		//$connect = null;

		return $sql;
	}

	/**
	 *
	 * Get albums of module
	 * @param string $module    the module to work with
	 *
	 * @return an array of albums
	 */
	private function getAlbums($module) {

		$table = $this->getTableForAlbum($module);

		$moduletable = $this->getPraefix(). $table;

		$connect = $this->getDBConnection();

		// ask the DB for entries in the module table
		// handle the access to the module album table
		// build sql
		$query = "SELECT ms_id, ms_title FROM $table ORDER by ms_parentalbumId";

		// prepare the sql query
		$sql = $connect->query($query);


		//$connect = null;

		return $sql;
	}

	/**
	 *
	 * Get pictures of album for the relevant module
	 * @param string $module    the module to work with
	 * @param int    $albumid   the id of the album
	 * @return an array of pictures
	 */
	public function getPictures($module, $albumid) {

		$sql2 = null;
		$table = $this->getTableForPicture($module);
		$moduletable = $this->getPraefix(). $table;

		$connect = $this->getDBConnection();

		// ask the DB for entries in the picture table
		// handle the access to the module picture table
		// build sql
		LogUtil::registerError($albumid);
		$query2 = "SELECT * FROM $table WHERE ms_parentalbumid = $albumid";

		// prepare the sql query
		$sql2 = $connect->query($query2);

		//$connect = null;

		return $sql2;
	}
	
	

	/**
	 * 
	 * @param array $args
	 * @return multitype:Ambigous <an, PDOStatement>
	 */
	public function getAlbumNames($args) {

		$module = $args['importmodule'];

		$sql = $this->getAlbums($module);

		$albums = array();

		if ($module == 'mediashare') {
			foreach ($sql as $result) {
					
				$albums[] = $result;
			}
		}

		return $albums;

	}

	/**
	 *
	 * Build data array for creating album
	 * @param string $module
	 * @param array $result
	 * @return array of values
	 */
	private function buildArrayForAlbum($module , $result) {

		if ($module == 'mediashare') {
			$result['ms_title'] = utf8_encode($result['ms_title']);
			$result['ms_description'] = utf8_encode($result['ms_description']);
			$datas[] = array('id' => $result['ms_id'],
					'parent_id' => $result['ms_parentAlbumId'],
					'title' => $result['ms_title'],
					'description' => $result['ms_description'],
					'createdUserId' => $result['ms_ownerid'],
					'updatedUserId' => $result['ms_ownerid'],
					'createdDate' => $result['ms_createddate'],
					'updatedDate' => $result['ms_modifieddate']);
		}
		return $datas;
	}

	/**
	 *
	 * Build data array for putting into the picture table
	 * @param string $module
	 * @param array $result
	 * @return array of columns
	 */
	private function buildArrayForPicture($module , $result) {

		if ($module == 'mediashare') {
			$result['ms_title'] = utf8_encode($result['ms_title']);
			$result['ms_description'] = utf8_encode($result['ms_description']);
			$datas[] = array('id' => $result['ms_id'],
					'album_id' => $result['ms_parentalbumId'],
					'title' => $result['ms_title'],
					'description' => $result['ms_description'],
					'imageUploadData' => $result['ms_description'],
					'imgageUpload' => $result['ms_description'],
					'createdUserId' => $result['ms_ownerid'],
					'updatedUserId' => $result['ms_ownerid'],
					'createdDate' => $result['ms_createddate'],
					'updatedDate' => $result['ms_modifieddate']);
		}
		return $datas;
	}

	/**
	 *
	 * Build data array for putting into the album table
	 * @param string $module
	 *
	 * @return array of columns
	 */
	private function buildDatasForAlbum($module , $result) {

		if ($module == 'mediashare') {
			$datas[] = array(':id' => $result['ms_id'],
					':parent_id' => $result['ms_parentAlbumId'],
					':title' => $result['ms_title'],
					':description' => $result['ms_description'],
					':createdUserId' => $result['ms_ownerid'],
					':updatedUserId' => $result['ms_ownerid'],
					':createdDate' => $result['ms_createddate'],
					':updatedDate' => $result['ms_modifieddate']);
		}
		return $datas;
	}

	/**
	 *
	 * Build data array for putting into the picture table
	 * @param string $module
	 *
	 * @return array of columns
	 */
	private function buildDatasForPicture($module , $result) {

		if ($module == 'mediashare') {
			$datas[] = array(':id' => $result['ms_id'],
					':parent_id' => $result['ms_parentAlbumId'],
					':title' => $result['ms_title'],
					':description' => $result['ms_description'],
					':createdUserId' => $result['ms_ownerid'],
					':updatedUserId' => $result['ms_ownerid'],
					':createdDate' => $result['ms_createddate'],
					':updatedDate' => $result['ms_modifieddate']);
		}
		return $datas;
	}

	/**
	 *
	 * Build the query for create albums
	 * @param string $module
	 */
	private function buildQueryForAlbumInput($module) {

		if ($module == 'mediashare') {
			$query = "INSERT INTO muimage_album (id, parent_id, title, description, createdUserId, updatedUserId, createdDate, updatedDate) VALUES (:id, :parent_id, :title, :description, :createdUserId, :updatedUserId, :createdDate, :updatedDate)";
		}

		return $query;
	}

	/**
	 *
	 * Build the query for create albums
	 * @param string $module
	 */
	private function buildQueryForPictureInput($module) {

		if ($module == 'mediashare') {
			$query = "INSERT INTO muimage_picture (id, album_id, title, description, createdUserId, updatedUserId, createdDate, updatedDate) VALUES (:id, :parent_id, :title, :description, :createdUserId, :updatedUserId, :createdDate, :updatedDate)";
		}

		return $query;
	}


	/**
	 *
	 * Get relevant table for albums
	 * @param string $module
	 * @return string as table
	 */
	private function getTableForAlbum($module) {

		if ($module == 'mediashare') {
			$table = 'mediashare_albums';
		}

		return $table;

	}

	/**
	 *
	 * Get relevant table for pictures
	 * @param string $module
	 * @return string as table
	 */
	private function getTableForPicture($module) {

		if ($module == 'mediashare') {
			$table = 'mediashare_media';
		}

		return $table;

	}

	/**
	 *
	 * Get relevant table for files
	 * @param string $module
	 * @return string as table
	 */
	private function getTableForFile($module) {

		if ($module == 'mediashare') {
			$table = 'mediashare_mediastore';
		}

		return $table;

	}

	/**
	 *
	 * Get supported modules
	 */

	public function getModules() {

		$modules = array('mediashare');

		return $modules;
	}

	/**
	 *
	 * Get praefix
	 */
	private function getPraefix() {

		//get prefix
		$prefix = $this->serviceManager['prefix'];

		return $prefix;

	}

	/**
	 * Get a connection to DB
	 *
	 * @return a connection
	 */
	private function getDBConnection() {
		//get host, db, user and pw
		$databases = ServiceUtil::getManager()->getArgument('databases');
		$connName = Doctrine_Manager::getInstance()->getCurrentConnection()->getName();
		$host = $databases[$connName]['host'];
		$dbname = $databases[$connName]['dbname'];
		$dbuser = $databases[$connName]['user'];
		$dbpassword = $databases[$connName]['password'];

		try {
			$connect = new PDO("mysql:host=$host;dbname=$dbname", $dbuser, $dbpassword);
		}

		catch (PDOException $e) {
			$this->__('Connection to database failed');
		}

		return $connect;
	}


	/**
	 *
	 * Getting the allowed file extensions
	 */

	private function getAllowedExtension() {

		$extensions = array ('png', 'jpg', 'jpeg', 'gif');

		return $extensions;
	}
}