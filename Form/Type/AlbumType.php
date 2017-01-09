<?php
/**
 * Image.
 *
 * @copyright Michael Ueberschaer (MU)
 * @license http://www.gnu.org/licenses/lgpl.html GNU Lesser General Public License
 * @author Michael Ueberschaer <kontakt@webdesign-in-bremen.com>.
 * @link http://www.webdesign-in-bremen.com
 * @link http://zikula.org
 * @version Generated by ModuleStudio (http://modulestudio.de).
 */

namespace MU\ImageModule\Form\Type;

use MU\ImageModule\Form\Type\Base\AbstractAlbumType;

use Symfony\Component\Form\FormBuilderInterface;

/**
 * Album editing form type implementation class.
 */
class AlbumType extends AbstractAlbumType
{
    /**
      * Adds fields for outgoing relationships.
      *
      * @param FormBuilderInterface $builder The form builder
      * @param array                $options The options
      */
     public function addOutgoingRelationshipFields(FormBuilderInterface $builder, array $options)
     {
 		return;
     }
}
