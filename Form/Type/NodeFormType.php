<?php
/**
 * This file is part of the Clastic package.
 *
 * (c) Dries De Peuter <dries@nousefreak.be>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Clastic\NodeBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * NodeType
 *
 * @author Dries De Peuter <dries@nousefreak.be>
 */
class NodeFormType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add(
                $builder->create('tabs', 'tabs', array('inherit_data' => true))
                    ->add($this->createGeneralTab($builder))
                    ->add($this->createPublicationTab($builder))
                    ->add($this->createAuthorInformationTab($builder))
                    ->add($this->createActionTab($builder))
            );
    }

    private function createGeneralTab(FormBuilderInterface $builder)
    {
        return $this
            ->createTab($builder, 'general', array(
                'label' => 'General',
                'position' => 'first',
            ))
            ->add('title', 'text', array(
                'property_path' => 'node.title',
                'label' => 'Title',
            ));
    }

    private function createPublicationTab(FormBuilderInterface $builder)
    {
        return $this
            ->createTab($builder, 'publication', array(
                'label' => 'Publication',
            ))
            ->add('available', 'checkbox', array(
                'property_path' => 'node.publication.available',
                'label' => 'Available',
                'required' => false,
            ))->add('publishedFrom', 'datepicker', array(
                'property_path' => 'node.publication.publishedFrom',
                'label' => 'From',
                'required' => false,
            ))->add('publishedTill', 'datepicker', array(
                'property_path' => 'node.publication.publishedTill',
                'label' => 'Till',
                'required' => false,
            ));
    }

    private function createAuthorInformationTab(FormBuilderInterface $builder)
    {
        return $this
            ->createTab($builder, 'author_information', array(
                'label' => 'Author information',
            ))
            ->add('author', 'entity', array(
                'class' => 'ClasticUserBundle:User',
                'property_path' => 'node.user',
                'label' => 'Author',
                'required' => true,
            ))
            ->add('created', 'datepicker', array(
                'property_path' => 'node.created',
                'label' => 'Created',
                'disabled' => true,
            ));
    }

    private function createTab(FormBuilderInterface $builder, $name, $options = array())
    {
        $options = array_replace(
            $options,
            array(
                'inherit_data' => true,
            ));

        return $builder->create($name, 'tabs_tab', $options);
    }

    private function createActionTab(FormBuilderInterface $builder)
    {
        return $builder
            ->create('actions', 'tabs_tab_actions', array(
                'mapped' => false,
                'inherit_data' => true,
            ))
            ->add('save', 'submit', array(
            'label' => 'Save',
            'attr' => array('class' => 'btn btn-success'),
        ));
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'clastic_node';
    }
}