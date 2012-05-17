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
	public function handleImport() {

	}

	/**
	 *
	 * Set albums into the DB
	 * @param string $module   the module to handle
	 */
	private function setAlbums($module) {

		// get the albums
		$albums = $this->getAlbums($module);
		// get query for insert
		$query = $this->buildQueryForAlbumInput($module);
		// for each album we handle the insert
		foreach ($albums as $result) {

			$data = $this->buildDatasForAlbum($module, $result);

		}
	}

	private function insertAlbums($module, $data, $query) {

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
		$query = "SELECT * FROM $moduletable";

		// prepare the sql query
		$sql = $connect->query($query);

		$connect = null;

		return $sql;
	}

	/**
	 *
	 * Get albums of module
	 * @param string $module    the module to work with
	 *
	 * @return an array of albums
	 */
	private function getPictures($module) {

		$table = $this->getTableForPicture($module);
		$moduletable = $this->getPraefix(). $table;

		$connect = $this->getDBConnection();

		// ask the DB for entries in the module table
		// handle the access to the module album table
		// build sql
		$query = "SELECT * FROM $moduletable";

		// prepare the sql query
		$sql = $connect->query($query);

		$connect = null;

		return $sql;
	}

	private function getAlbumNames($args) {

		$sql = $this->getAlbums($args['module']);

		$albums = array();

		if ($module == 'mediashare') {
			foreach ($sgl as $result) {
					
				$albums[] = array('name' => $result['ms_title'], 'value' => $result['ms_id']);
			}
		}

		return $albums;

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
			$table = 'mediashare_albums';
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