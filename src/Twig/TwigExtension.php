<?php

namespace App\Twig;

use Twig\TwigFilter;
use Twig\TwigFunction;
use App\Entity\Product;
use Twig\Extension\AbstractExtension;
use Doctrine\Persistence\ManagerRegistry;

class TwigExtension extends AbstractExtension
{
    public function getFilters(): array
    {
        return [
            // If your filter generates SAFE HTML, you should add a third
            // parameter: ['is_safe' => ['html']]
            // Reference: https://twig.symfony.com/doc/2.x/advanced.html#automatic-escaping
            new TwigFilter('filter_name', [$this, 'doSomething']),
        ];
    }

    public function getFunctions(): array
    {
        return [
            new TwigFunction('findOneById', [$this, 'findOneById']),
        ];
    }

    protected $doctrine;
    // Retrieve doctrine from the constructor
    public function __construct(ManagerRegistry $doctrine)
    {
        $this->doctrine = $doctrine;
    }

    /**
     * FindOneById
     *
     * @param  mixed $id
     * @return void
     */
    public function findOneById($id)
    {
        $em = $this->doctrine->getManager();
        $myRepo = $em->getRepository(Product::class);

        return $myRepo->findOneById($id);
    }

    public function doSomething($value)
    {
        // ...
    }
}
