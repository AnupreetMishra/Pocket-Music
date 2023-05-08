<?php

namespace App\Controller\Admin;

use App\Entity\VinylMix;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Filters;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\Field;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class VinylMixCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return VinylMix::class;
    }

    
    public function configureFields(string $pageName): iterable
    {
        // return [
        //     IdField::new('id'),
        //     TextField::new('title'),
        //     TextEditorField::new('description'),
        // ];

        yield IdField::new('id')
             ->onlyOnIndex();
        yield TextField::new('title');
        yield TextEditorField::new('description')
            ->hideOnIndex()
            ->setFormTypeOptions([
                'row_attr' => [
                    'data-controller' => 'snarkdown',
                ],
                'attr' => [
                    'data-snarkdown-target' => 'input',
                    'data-action' => 'snarkdown#render'
                ],
                ])
                ->setHelp('Preview:');
  
        yield IntegerField::new('votes','Total Votes')
            ->setTemplatePath('admin/field/votes.html.twig');
            // ->setTextAlign('right');
        yield Field::new('createdAt')
           ->hideOnForm();
        
        // $exportAction = Action::new('export')
        //    ->linkToCrudAction('export')
        //    ->addCssClass('btn btn-success')
        //    ->setIcon('fa fa-download');


   
    }


    public function configureFilters(Filters $filters): Filters
    {
        return parent::configureFilters($filters)
           ->add('id')
           ->add('title')
           ->add('createdAt')
           ->add('votes');
    }
    
}
