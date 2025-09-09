<?php

declare(strict_types=1);

namespace App\Model;

use PDO;

/** @template Model of AbstractModel */
abstract readonly class AbstractRepository
{
    public function __construct(
        private PDO $pdo,
        private string $table,
        private string $modelClass,
    ) {
    }

    /** @return Model|null */
    public function findBy(string $column, string $value): ?AbstractModel
    {
        $query = $this->pdo->prepare("SELECT * FROM $this->table WHERE $column = :value");
        $query->execute(['value' => $value]);
        $modelArray = $query->fetch();

        if (!$modelArray) {
            return null;
        }

        return $this->modelClass::createFromDbArray($modelArray);
    }

    /** @return Model[] */
    public function findAll(): array
    {
        $query = $this->pdo->prepare("SELECT * FROM $this->table");
        $query->execute();
        $modelsArray = $query->fetchAll();

        if (!$modelsArray) {
            return [];
        }

        return array_map(
            fn (array $modelArray) => $this->modelClass::createFromDbArray($modelArray),
            $modelsArray,
        );
    }

    public function delete(int $id): void
    {
        $query = $this->pdo->prepare("DELETE FROM $this->table WHERE id = :id");
        $query->execute(['id' => $id]);
    }

    public function insert(array $params): void
    {
        $columnNamesQueryPart = '(' . implode(', ', array_keys($params)) . ')';
        $placeholders = rtrim(str_repeat('?,', count($params)), ',');

        $query = $this->pdo->prepare(
            "INSERT INTO $this->table $columnNamesQueryPart VALUES ($placeholders)"
        );

        $query->execute(array_values($params));
    }

    public function update(array $params): void
    {
        $setQueryPart = [];
        foreach ($params as $key => $value) {
            if ($key === 'id') {
                continue;
            }
            $setQueryPart[] = "$key = :$key";
        }

        $query = $this->pdo->prepare(
            "UPDATE $this->table SET " . implode(', ', $setQueryPart) . " WHERE id = :id",
        );

        $query->execute($params);
    }
}
