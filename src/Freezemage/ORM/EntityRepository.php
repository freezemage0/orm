<?php


namespace Freezemage\Core\ORM;


use Freezemage\Type\Collection;
use Freezemage\Core\ORM\Field\Field;


abstract class EntityRepository implements EntityRepositoryInterface
{
    /** @var EntityManager $entityManager */
    protected $entityManager;
    protected $fields;

    /**
     * EntityRepository constructor.
     *
     * @param EntityManager $entityManager
     */
    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function persist(EntityInterface $entity): void
    {
        if ($entity->getId() === null) {
            $query = $this->entityManager->getBuilderFactory()->getInsert();
        } else {
            $query = $this->entityManager->getBuilderFactory()->getUpdate();
            $query->whereEqual($this->entityManager->getPrimaryField()->getName(), $entity->getId());
        }

        $data = $entity->toArray();
        $query->setData($data);

        $this->entityManager->execute($query);
    }

    public function findBy(array $filter = array(), array $order = array(), ?int $limit = null, ?int $offset = null): Collection
    {
        $select = $this->entityManager->getBuilderFactory()->getSelect();

        if ($limit !== null) {
            $select->setLimit($limit);
        }
        if ($offset !== null) {
            $select->setOffset($offset);
        }
        $select->setOrder(...$order);
        $select->setWhere($filter);

        $data = $this->entityManager->execute($select);

        $items = new Collection();

        while ($item = $data->fetch()) {
            $items->append($item);
        }

        return $items;
    }

    public function remove($id): void
    {
        $delete = $this->entityManager->getBuilderFactory()->getDelete();
        $delete->whereEqual($this->entityManager->getPrimaryField()->getName(), $id);
        $this->entityManager->execute($delete);
    }

    public function count(): int
    {
        $select = $this->entityManager->getBuilderFactory()->getSelect();
        $select->setSelect(array('COUNT(*) AS `CNT`'));

        $count = $this->entityManager->execute($select)->fetch();
        return $count['CNT'];
    }
}