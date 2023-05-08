<?php

namespace App\Controller\Admin;

use App\Entity\Admin;
use EasyCorp\Bundle\EasyAdminBundle\Config\Filters;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;


class AdminCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Admin::class;
    }

    
    // public function configureFields(string $pageName): iterable
    // {
    //     // return [
    //     //     IdField::new('id'),
    //     //     TextField::new('title'),
    //     //     TextEditorField::new('description'),

    //     // ];
    //     yield  IdField::new('id')
    //       ->onlyOnIndex();
             
    //     yield  EmailField::new('email');
    //     yield  TextField::new('username');
    //     // yield  BooleanField::new('enabled')
    //     //       ->renderAsSwitch(false);

    //     yield  DateField::new('createdAt');


        

    // }

    public function configureFilters(Filters $filters): Filters
    {
        return parent::configureFilters($filters)
           ->add('email');
    }


    
}
