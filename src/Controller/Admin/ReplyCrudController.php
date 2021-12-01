<?php

namespace App\Controller\Admin;

use App\Entity\Reply;
use App\Entity\Comments;
use App\Repository\CommentsRepository;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class ReplyCrudController extends AbstractCrudController
{
    private $adminUrlGenerator;

    public function __construct(AdminUrlGenerator $adminUrlGenerator)
    {
        $this->adminUrlGenerator = $adminUrlGenerator;
    }

    public static function getEntityFqcn(): string
    {
        return Reply::class;
    }

    public function configureFields(string $pageName): iterable
    {

            $id = IdField::new('id');
            $parent = IdField::new('parentId');
            $content = TextField::new('content', 'Réponse');
            $email = AssociationField::new('email');
            $created = DateTimeField::new('createdAt', 'Date d\'inscription')->setColumns(
                '2'
            );

            if (Crud::PAGE_INDEX === $pageName) {
                return [$id, $parent, $content, $email, $created];
            } elseif (Crud::PAGE_EDIT === $pageName) { //just to be sure to override the EDIT actions on Comments::class
                return [$id, $parent, $content, $email, $created];
            } else {
                return ['...'];
            };
    }

    public function someMethod()
    {
        $url = $this->adminUrlGenerator->setRoute('reply_crud_controller',[
            // 'id' => $this->getParent(),
        ] )->generateUrl();

    }
}
