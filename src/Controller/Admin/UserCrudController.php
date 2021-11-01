<?php

namespace App\Controller\Admin;

use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ArrayField;
use EasyCorp\Bundle\EasyAdminBundle\Field\EmailField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

/**
 * UserCrudController
 */
class UserCrudController extends AbstractCrudController
{
    /**
     * GetEntityFqcn
     *
     * @return string
     */
    public static function getEntityFqcn(): string
    {
        return User::class;
    }

    /**
     * ConfigureCrud
     *
     * @param  mixed $crud
     */
    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('Utilisateurs')
            ->setDateFormat('Y-m-d')
            ->setSearchFields(['email'])
            ->setPaginatorPageSize(10)
            ->setDefaultSort(['createdAt' => 'DESC'], ['roles' => 'DESC']);
        //TODOs mettre en place les permissions et un role[ product_manager] et [super_admin]
        //TODOs mettre en place la traduction
    }

    /**
     * ConfigureFields
     *
     * @param  mixed $pageName
     */
    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')
                ->setColumns('2')
                ->onlyOnIndex(),
            EmailField::new('email')->setColumns('2'),
            ArrayField::new('roles', 'Rôles')->setColumns('2'),
            DateTimeField::new('createdAt', 'Date d\'inscription')->setColumns(
                '2'
            ),
            DateTimeField::new('updatedAt')
                ->setColumns('col-2')
                ->hideOnIndex(),
            // DateTimeField::new('deletedAt')->setColumns('col-2')->hideOnIndex(),
        ];
        if (Crud::PAGE_EDIT === $pageName) {
            return [
                IdField::new('id')->setColumns('col-2'),
                EmailField::new('email')->setColumns('col-2'),
                ArrayField::new('roles')->setColumns('col-2'),
                DateTimeField::new('createdAt')->setColumns('2'),
            ];
        }
    }
}
