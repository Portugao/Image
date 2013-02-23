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
 * @version Generated by ModuleStudio 0.5.4 (http://modulestudio.de) at Fri Feb 17 18:57:24 CET 2012.
 */

/**
 * The muimageCountAlbumPictures modifier displays a thumbnail image.
 *
 * @param  string    $fileName   The input file name.
 * @param  string    $filePath   The input file path (including file name).
 * @param  int       $width      Desired width.
 * @param  int       $height     Desired height.
 * @param  array     $thumbArgs  Additional arguments.
 *
 * @return string The thumbnail file path.
 */
function smarty_modifier_muimageCountAlbumPictures($albumid = '')
{
    /**
     * 
     */
	
    return MUImage_Util_View::countAlbumPictures($albumid);
}