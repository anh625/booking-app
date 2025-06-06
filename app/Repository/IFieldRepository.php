<?php


namespace App\Repository;

/**
 * Interface IFieldRepository
 *
 * Defines methods for interacting with the Field data source.
 */
interface IFieldRepository
{
    /**
     * Get a paginated list of Fields.
     *
     * @param int $perPage Number of Fields per page
     * @return mixed Paginated list of Fields
     */
    public function show(int $perPage, string $id);

    /**
     * Get a single Field by its ID.
     *
     * @param string $id Field field_id
     * @return mixed Field object or null if not found
     */
    public function getById(string $id);

    /**
     * Store a new Field in the database.
     *
     * @param array $data Field data to be saved
     * @return mixed Created Field
     */
    public function store(array $data);

    /**
     * Update an existing Field.
     *
     * @param array $data Updated Field data
     * @param string $id Field field_id
     * @return mixed Updated Field or null if not found
     */
    public function update(array $data, string $id);

    /**
     * Delete a Field by its ID.
     *
     * @param string $id Field field_id
     * @return mixed Deleted Field or null if not found
     */
    public function delete(string $id);

    /**
     * Retrieves the owner ID for a specific field.
     *
     * @param string $fieldId The field ID.
     * @return mixed The owner ID.
     */
    public function getOwnerId(string $fieldId);

    /**
     * Retrieves courts for a specific field and date.
     *
     * @param string $fieldId The field ID.
     * @param string $date The date in Y-m-d format.
     * @return array The list of courts.
     */
    public function getCourtsByFieldAndDate(string $fieldId, string $date): array;

    public function getFieldStas(): array;
}
