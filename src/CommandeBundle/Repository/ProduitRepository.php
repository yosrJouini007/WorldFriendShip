<?php

namespace CommandeBundle\Repository;

/**
 * ProduitRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class ProduitRepository extends \Doctrine\ORM\EntityRepository
{
    public function searchProduit($var)
    {
        $query = $this->getEntityManager()
            ->createQuery("SELECT m FROM CommandeBundle:Produit p where (p.nomProd LIKE :var)")
            ->setParameter('var','%'.$var.'%');
        return $query->getResult();
    }
}
