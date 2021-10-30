<?php

namespace App\Controller\Admin;

use App\Entity\Product;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use Vich\UploaderBundle\Form\Type\VichImageType;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\MoneyField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class ProductCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Product::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('Produits')
            ->setPageTitle('index', '%entity_label_singular%')
            ->setDateFormat('Y-m-d')
            ->setSearchFields(['name', 'price', 'status', 'category'])
            ->setDefaultSort(['createdAt' => 'DESC'], ['roles' => 'DESC']);
    }

    // public function configureActions(Actions $actions): Actions
    // {

    // }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->onlyOnIndex(),
            TextField::new('name', 'Nom'),
            TextEditorField::new('description', 'Description'),
            MoneyField::new('price', 'Prix HT')->setCurrency('EUR'),
            ImageField::new('photo')
                ->setBasePath('/images/products/')
                ->onlyOnIndex(),
            TextareaField::new('photoFile', 'photo')
                ->setFormType(VichImageType::class)
                ->onlyOnForms()
                ->setFormTypeOption('allow_delete', false),
            BooleanField::new('status', 'Status'),
            AssociationField::new('category', 'Catégorie')->setFormType(
                EntityType::class
            ),
        ];
    }
}
