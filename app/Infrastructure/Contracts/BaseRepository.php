<?php

/**
 * @author Bona Brian Siagian <bonabriansiagian@gmail.com>
 */

namespace App\Infrastructure\Contracts;

interface BaseRepository
{
    /**
     * Get all data
     *
     * @param array $columns
     */
    public function all(array $columns = ['*']);

    /**
     * Find data by id
     *
     * @param $id
     * @param array $columns
     */
    public function find($id, array $columns = ['*']);

    /**
     * Find one data by field and value
     *
     * @param $field
     * @param $value
     * @param array $columns
     */
    public function findOneByField($field, $value, array $columns = ['*']);

    /**
     * Find data by field and value
     *
     * @param $field
     * @param $value
     * @param array $columns
     */
    public function findByField($field, $value, array $columns = ['*']);

    /**
     * Find one data where conditions
     *
     * @param array $where
     * @param array $columns
     */
    public function findOneWhere(array $where, array $columns = ['*']);

    /**
     * Find data where conditions
     *
     * @param array $where
     * @param array $columns
     */
    public function findWhere(array $where, array $columns = ['*']);

    /**
     * Save a new entity in repository
     *
     * @param array $data
     */
    public function create(array $data);

    /**
     * Update entity in repository by id
     *
     * @param $id
     * @param array $data
     */
    public function update($id, array $data);

    /**
     * Delete entity in repository by id
     *
     * @param $id
     */
    public function delete($id);

    /**
     * Query scope
     *
     * @param \Closure $scope
     *
     * @return self
     */
    public function scopeQuery(\Closure $scope);

    /**
     * Reset query scope
     *
     * @return self
     */
    public function resetScope();
}
