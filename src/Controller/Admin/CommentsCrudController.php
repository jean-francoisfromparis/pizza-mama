<?php

namespace App\Controller\Admin;

use App\Entity\Reply;
use App\Form\ReplyType;
use App\Entity\Comments;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use Vich\UploaderBundle\Form\Type\VichImageType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Assets;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Filters;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ArrayField;
use EasyCorp\Bundle\EasyAdminBundle\Field\EmailField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\MoneyField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\CollectionField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class CommentsCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Comments::class;
    }

    /**
     * ConfigureCrud
     *
     * @param  mixed $crud
     */
    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('Actif')
            ->setPageTitle('index', '%entity_label_singular%')
            ->setDateFormat('Y-m-d')
            ->setSearchFields(['pseuco', 'email', 'createdAt'])
            ->setDefaultSort(['createdAt' => 'DESC'])
            ->setPaginatorPageSize(5);
    }

    /**
     * ConfigureFields
     *
     * @param  mixed $pageName
     */
    public function configureFields(string $pageName): iterable
    {
        $id = IdField::new('id');
        $content = TextField::new('content', 'Commentaires')->hideOnDetail();
        $email = EmailField::new('email', 'Email')->hideOnDetail();
        $pseudo = TextField::new('pseudo', 'pseudo')->hideOnDetail();
        $compliance = BooleanField::new('compliance', 'Conformité RGPD')->hideOnDetail();
        $created = DateTimeField::new('createdAt', 'Date d\'inscription')->setColumns(
            '2'
        );


        if (Crud::PAGE_INDEX === $pageName) {
            return [$id, $content, $email, $pseudo, $compliance, $created];
        } elseif (Crud::PAGE_EDIT === $pageName) { //just to be sure to override the EDIT actions on Comments::class
            return [$id, $content, $email, $pseudo, $compliance, $created];
        } else {
            return ['...'];
        };
    }

    /**
     * ConfigureFilters
     *
     * @param  mixed $filters
     */
    public function configureFilters(Filters $filters): Filters
    {
        return $filters
            ->add('active')
            // ->add('price')
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
            // ->remove(Crud::PAGE_INDEX, Action::EDIT)
            ->setPermission(Action::DELETE, 'ROLE_ADMIN') //TODOs add a super admin for all delete actions in dashboard

        ;
    }
}
