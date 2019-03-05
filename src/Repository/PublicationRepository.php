<?php
/**
 * Created by PhpStorm.
 * User: harmedia
 * Date: 05/03/2019
 * Time: 20:00
 */

namespace App\Repository;

namespace App\Repository;
use App\Entity\Publication;
use App\Entity\Publication\Repository\Exception;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\ORM\Query;


class PublicationRepository extends ServiceEntityRepository implements Publication\Repository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Publication::class);
    }

    /**
     * @param $id
     * @return Publication
     * @throws Exception\PublicationNotFound
     */
    public function findById($id)
    {
        /** @var Publication $publication */
        $publication = $this->find($id);
        if (null == $publication) {
            throw new Exception\PublicationNotFound;
        }
        return $publication;
    }

    /**
     * @return array of Publication
     * @throws Exception\PublicationNotFound
     */
    public function getList()
    {
        $publications = $this->findAll();
        if (empty(array_filter($publications))) {
            throw new Exception\PublicationNotFound;
        }
        return $publications;
    }

    /**
     * @param Publication $Publication
     * @return void
     * @throws Exception\UnableToSave
     */
    public function save(Publication $Publication)
    {
        try {
            $this->_em->persist($Publication);
            $this->_em->flush();
        } catch (\Exception | \Throwable $e) {
            throw new Exception\UnableToSave('', 0, $e);
        }
    }

    /**
     * @param Publication $Publication
     * @return void
     * @throws Exception\UnableToDelete
     */
    public function delete(Publication $Publication)
    {
        try {
            $this->_em->remove($Publication);
            $this->_em->flush();
        } catch (\Exception | \Throwable $e) {
            throw new Exception\UnableToDelete('', 0, $e);
        }
    }
}

