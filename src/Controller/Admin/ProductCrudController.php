<?php

namespace App\Controller\Admin;

use App\Entity\Product;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use Vich\UploaderBundle\Form\Type\VichImageType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Filters;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\MoneyField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

/**
 * ProductCrudController
 */
class ProductCrudController extends AbstractCrudController
{
    /**
     * GetEntityFqcn
     *
     * @return string
     */
    public static function getEntityFqcn(): string
    {
        return Product::class;
    }

    /**
     * ConfigureCrud
     *
     * @param  mixed $crud
     */
    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('Produits')
            ->setPageTitle('index', '%entity_label_singular%')
            ->setDateFormat('Y-m-d')
            ->setSearchFields(['name', 'price', 'status', 'category.name'])
            ->setPaginatorPageSize(10)
            ->setDefaultSort(
                [
                'createdAt' => 'DESC'
                ],
                [
                'roles' => 'DESC'
                ]
            );
    }

    // public function configureActions(Actions $actions): Actions
    // {

    // }

    /**
     * ConfigureFields
     *
     * @param  mixed $pageName
     */
    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->onlyOnIndex(),
            TextField::new('name', 'Nom')->addCssClass('col-3 fs-3'),
            TextEditorField::new('description', 'Description'),
            MoneyField::new(
                'price',
                'Prix HT'
            )
                ->setCurrency(
                    'EUR'
                )
                ->addCssClass('fs-3'),
            ImageField::new('photo')
                ->setBasePath('/images/products/')
                ->onlyOnIndex(),
            TextareaField::new('photoFile', 'photo')
                ->setFormType(VichImageType::class)
                ->onlyOnForms()
                ->setFormTypeOption('allow_delete', false),
            BooleanField::new('status', 'Status'),
            AssociationField::new(
                'category',
                'Catégorie'
            )
                ->setFormType(
                    EntityType::class
                ),
        ];
    }

    /**
     * ConfigureFilters
     *
     * @param  mixed $filters
     */
    public function configureFilters(Filters $filters): Filters
    {
        return $filters
            ->add('category')
        ;
    }

    /**
     * configureActions
     *
     * @param  mixed $actions
     * @return Actions
     */
    public function configureActions(Actions $actions): Actions
    {
        return $actions
        ->setPermission(Action::NEW, 'ROLE_ADMIN')
        ->setPermission(Action::EDIT, 'ROLE_ADMIN')
        ->setPermission(Action::DELETE, 'ROLE_ADMIN') //TODOs add a super admin for all delete actions in dashboard
    ;
    }
}
