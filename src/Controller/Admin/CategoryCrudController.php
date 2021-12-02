<?php

namespace App\Controller\Admin;

use App\Entity\Category;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

/**
 * CategoryCrudController
 */
class CategoryCrudController extends AbstractCrudController
{
    /**
     * GetEntityFqcn
     *
     * @return string
     */
    public static function getEntityFqcn(): string
    {
        return Category::class;
    }

    /**
     * ConfigureCrud
     *
     * @param  mixed $crud
     */
    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('Catégorie')
            ->setPageTitle('index', '%entity_label_singular%')
            ->setDateFormat('Y-m-d')
            ->setSearchFields(['name', 'status', 'product'])
            ->setDefaultSort(['createdAt' => 'DESC'], ['roles' => 'DESC']);
    }

    /**
     * ConfigureFields
     *
     * @param  mixed $pageName
     */
    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('name', 'Titre'),
            TextEditorField::new('description', 'Description'),
            AssociationField::new('products', 'Produits')
                ->setFormType(EntityType::class)
                ->onlyOnDetail(),
        ];
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
