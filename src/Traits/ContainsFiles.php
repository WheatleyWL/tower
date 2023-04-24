<?php

namespace zedsh\tower\Traits;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use zedsh\tower\Models\File;

trait ContainsFiles
{
    /**
     * @return string[]
     */
    abstract function getFileFields(): array;

    /**
     * @param string $fieldName
     * @return MorphToMany
     */
    protected function relationToFileField(string $fieldName): MorphToMany
    {
        /** @var $this Model */
        return $this->morphToMany(File::class, 'attachable')
            ->wherePivot('attachable_field', $fieldName);
    }

    /**
     * @param array $requestFields
     */
    public function syncFileFields(array $requestFields): void
    {
        foreach($this->getFileFields() as $fieldName) {
            if(!isset($requestFields[$fieldName])) {
                continue;
            }

            $fileIds = $requestFields[$fieldName];
            if(!is_array($fileIds)) {
                $fileIds = [$fileIds];
            }
            $fileIds = array_filter($fileIds);

            $relation = $this->relationToFileField($fieldName);
            $relation->syncWithPivotValues($fileIds, ['attachable_field' => $fieldName]);
        }
    }
}
