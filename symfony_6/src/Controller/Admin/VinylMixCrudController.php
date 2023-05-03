<?php

namespace App\Controller\Admin;

use App\Entity\VinylMix;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\Field;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
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
        yield Field::new('description')
            ->hideOnIndex();
  
        yield IntegerField::new('votes','Total Votes')
            ->setTemplatePath('admin/field/votes.html.twig');
            // ->setTextAlign('right');
        yield Field::new('createdAt')
           ->hideOnForm();
         
   
    }
    
}
