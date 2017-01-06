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

namespace MU\ImageModule\Form\Type\Finder\Base;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Zikula\Common\Translator\TranslatorInterface;
use Zikula\Common\Translator\TranslatorTrait;
use MU\ImageModule\Helper\FeatureActivationHelper;

/**
 * Avatar finder form type base class.
 */
abstract class AbstractAvatarFinderType extends AbstractType
{
    use TranslatorTrait;

    /**
     * @var FeatureActivationHelper
     */
    protected $featureActivationHelper;

    /**
     * AvatarFinderType constructor.
     *
     * @param TranslatorInterface $translator Translator service instance
     * @param FeatureActivationHelper $featureActivationHelper FeatureActivationHelper service instance
     */
    public function __construct(TranslatorInterface $translator, FeatureActivationHelper $featureActivationHelper)
    {
        $this->setTranslator($translator);
        $this->featureActivationHelper = $featureActivationHelper;
    }

    /**
     * Sets the translator.
     *
     * @param TranslatorInterface $translator Translator service instance
     */
    public function setTranslator(/*TranslatorInterface */$translator)
    {
        $this->translator = $translator;
    }

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->setMethod('GET')
            ->add('objectType', 'Symfony\Component\Form\Extension\Core\Type\HiddenType', [
                'data' => $options['objectType']
            ])
            ->add('editor', 'Symfony\Component\Form\Extension\Core\Type\HiddenType', [
                'data' => $options['editorName']
            ])
        ;

        if ($this->featureActivationHelper->isEnabled(FeatureActivationHelper::CATEGORIES, $options['objectType'])) {
            $this->addCategoriesField($builder, $options);
        }
        $this->addPasteAsField($builder, $options);
        $this->addSortingFields($builder, $options);
        $this->addAmountField($builder, $options);
        $this->addSearchField($builder, $options);

        $builder
            ->add('update', 'Symfony\Component\Form\Extension\Core\Type\SubmitType', [
                'label' => $this->__('Change selection'),
                'icon' => 'fa-check',
                'attr' => [
                    'class' => 'btn btn-success'
                ]
            ])
            ->add('cancel', 'Symfony\Component\Form\Extension\Core\Type\SubmitType', [
                'label' => $this->__('Cancel'),
                'icon' => 'fa-times',
                'attr' => [
                    'class' => 'btn btn-default',
                    'formnovalidate' => 'formnovalidate'
                ]
            ])
        ;
    }

    /**
     * Adds a categories field.
     *
     * @param FormBuilderInterface $builder The form builder
     * @param array                $options The options
     */
    public function addCategoriesField(FormBuilderInterface $builder, array $options)
    {
        $builder->add('categories', 'Zikula\CategoriesModule\Form\Type\CategoriesType', [
            'label' => $this->__('Category') . ':',
            'empty_data' => [],
            'attr' => [
                'class' => 'category-selector',
                'title' => $this->__('This is an optional filter.')
            ],
            'help' => $this->__('This is an optional filter.'),
            'required' => false,
            'multiple' => false,
            'module' => 'MUImageModule',
            'entity' => ucfirst($options['objectType']) . 'Entity',
            'entityCategoryClass' => 'MU\ImageModule\Entity\\' . ucfirst($options['objectType']) . 'CategoryEntity'
        ]);
    }

    /**
     * Adds a "paste as" field.
     *
     * @param FormBuilderInterface $builder The form builder
     * @param array                $options The options
     */
    public function addPasteAsField(FormBuilderInterface $builder, array $options)
    {
        $builder->add('pasteas', 'Symfony\Component\Form\Extension\Core\Type\ChoiceType', [
            'label' => $this->__('Paste as') . ':',
            'empty_data' => 1,
            'choices' => [
                $this->__('Link to the avatar') => 1,
                $this->__('ID of avatar') => 2
            ],
            'choices_as_values' => true,
            'multiple' => false,
            'expanded' => false
        ]);
    }

    /**
     * Adds sorting fields.
     *
     * @param FormBuilderInterface $builder The form builder
     * @param array                $options The options
     */
    public function addSortingFields(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('sort', 'Symfony\Component\Form\Extension\Core\Type\ChoiceType', [
                'label' => $this->__('Sort by') . ':',
                'empty_data' => '',
                'choices' => [
                    $this->__('Workflow state') => 'workflowState',
                    $this->__('Title') => 'title',
                    $this->__('Description') => 'description',
                    $this->__('Avatar upload') => 'avatarUpload',
                    $this->__('Supported modules') => 'supportedModules',
                    $this->__('Creation date') => 'createdDate',
                    $this->__('Creator') => 'createdBy',
                    $this->__('Update date') => 'updatedDate'
                ],
                'choices_as_values' => true,
                'multiple' => false,
                'expanded' => false
            ])
            ->add('sortdir', 'Symfony\Component\Form\Extension\Core\Type\ChoiceType', [
                'label' => $this->__('Sort direction') . ':',
                'empty_data' => 'asc',
                'choices' => [
                    $this->__('Ascending') => 'asc',
                    $this->__('Descending') => 'desc'
                ],
                'choices_as_values' => true,
                'multiple' => false,
                'expanded' => false
            ])
        ;
    }

    /**
     * Adds a page size field.
     *
     * @param FormBuilderInterface $builder The form builder
     * @param array                $options The options
     */
    public function addAmountField(FormBuilderInterface $builder, array $options)
    {
        $builder->add('num', 'Symfony\Component\Form\Extension\Core\Type\ChoiceType', [
            'label' => $this->__('Page size') . ':',
            'empty_data' => 20,
            'attr' => [
                'class' => 'text-right'
            ],
            'choices' => [
                5 => 5,
                10 => 10,
                15 => 15,
                20 => 20,
                30 => 30,
                50 => 50,
                100 => 100
            ],
            'choices_as_values' => true,
            'multiple' => false,
            'expanded' => false
        ]);
    }

    /**
     * Adds a search field.
     *
     * @param FormBuilderInterface $builder The form builder
     * @param array                $options The options
     */
    public function addSearchField(FormBuilderInterface $builder, array $options)
    {
        $builder->add('q', 'Symfony\Component\Form\Extension\Core\Type\SearchType', [
            'label' => $this->__('Search for') . ':',
            'required' => false,
            'max_length' => 255
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'muimagemodule_avatarfinder';
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver
            ->setDefaults([
                'objectType' => 'album',
                'editorName' => 'ckeditor'
            ])
            ->setRequired(['objectType', 'editorName'])
            ->setAllowedTypes([
                'objectType' => 'string',
                'editorName' => 'string'
            ])
            ->setAllowedValues([
                'editorName' => ['tinymce', 'ckeditor']
            ])
        ;
    }
}
