<?php
namespace App\Entity\Publication;

use App\Entity\Publication;
use App\Entity\Publication\Repository\Exception;

interface Repository
{
    /**
     * @param $id
     * @return Publication
     * @throws Exception\PublicationNotFound
     */
    public function findById($id);

    /**
     * @return Publication
     * @throws Exception\PublicationNotFound
     */
    public function getList();

    /**
     * @param Publication $Publication
     * @return void
     * @throws Exception\UnableToSave
     */
    public function save(Publication $Publication);

    /**
     * @param Publication $Publication
     * @return void
     * @throws Exception\UnableToDelete
     */
    public function delete(Publication $Publication);
}