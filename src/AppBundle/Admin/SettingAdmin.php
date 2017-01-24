<?php

namespace AppBundle\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Route\RouteCollection;
use Symfony\Component\Form\Extension\Core\Type\TextType;

/**
 * Class SettingAdmin
 */
class SettingAdmin extends AbstractAdmin
{
    protected function configureRoutes(RouteCollection $collection)
    {
        $collection->clearExcept(['list', 'show', 'edit']);
    }

    protected function configureFormFields(FormMapper $form)
    {
        $form
            ->add('slug', TextType::class, ['attr' => ['readonly' => true]])
            ->add('value')
        ;
    }

    protected function configureListFields(ListMapper $list)
    {
        $list
            ->addIdentifier('slug')
        ;
    }

    protected function configureDatagridFilters(DatagridMapper $filter)
    {
        $filter->add('slug');
    }
}
