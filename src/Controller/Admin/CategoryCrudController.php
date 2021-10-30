<?php

namespace App\Controller\Admin;

use App\Entity\Category;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class CategoryCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Category::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
return $crud
->setEntityLabelInSingular('Catégorie')
->setPageTitle('index', '%entity_label_singular%')
->setDateFormat('Y-m-d')
->setSearchFields(['name','status','product'])
->setDefaultSort(['createdAt' => 'DESC'],['roles' => 'DESC']);
}

    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('name','Titre'),
            TextEditorField::new('description','Description'),
            AssociationField::new('products','Produits')
                ->setFormType(
                    EntityType::class
                )
                ->onlyOnDetail(),
        ];
    }
}
