<?php

namespace App\Services;

use App\Enums\GeneralEnums;
use App\Models\File;
use Illuminate\Database\Eloquent\Model;

class FileService
{
    /**
     * Add New File
     * Save File to Database with Relation to Model
     *
     * @param Model $record The model instance to which the file is related
     * @param string $fileName The name of the file
     * @param string $folder The folder of the file
     * @param string $label The label of the file
     * @param string $fileType The type of the file
     * @param string $relationName The name of the relation method in the model
     * @param string|null $notes Additional notes for the file (optional)
     * @param int|null $order The order of the file (optional)
     * @param string $fileSize The size of the file (optional)
     * @return void
     */
    public function addFile(Model $record, string $fileName, string $folder, string $label, string $fileType, string $relationName, string $notes = null, int $order = null, string $fileSize = '0'): void
    {
        $file = new File();
        $file->file_name = $fileName;
        $file->folder = $folder;
        $file->label = $label;
        $file->file_type = isset(GeneralEnums::FileTypes[$fileType]) ? $fileType : null;
        $file->file_size = $fileSize;

        if ($notes) {
            $file->notes = $notes;
        }

        if ($order) {
            $file->order = $order;
        }

        $record->$relationName()->save($file);
    }

    /**
     * Delete File
     * Delete File from Database
     *
     * @param string $fileName The name of the file
     * @param string $folder The folder of the file
     * @param string $label The label of the file
     * @param int $modelId The ID of the model to which the file is related
     * @return void
     */
    public function deleteFile(string $fileName, string $folder, string $label, int $modelId): void
    {
        $fileName = explode('/', $fileName);

        deleteFile(end($fileName), $folder);

        File::where('fileable_id', $modelId)
            ->whereFileName(end($fileName))
            ->whereLabel($label)
            ->whereFolder($folder)
            ->delete();
    }
}
