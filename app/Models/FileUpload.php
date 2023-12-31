<?php

namespace App\Models;

use App\Interfaces\IModel;
use JsonSerializable;

class FileUpload implements IModel, JsonSerializable
{
    private array $imagePaths;

    public function __construct()
    {
        $this->imagePaths = array();
    }

    public function uploadImages($model, $modelData, $fileInputName)
    {
        $modelData = (array) $modelData;

        $uploadFolder = "uploads/{$model->table}/{$modelData['id']}/";

        if (!file_exists($uploadFolder)) {
            mkdir($uploadFolder, 0777, true);
        }

        foreach ($_FILES[$fileInputName]['tmp_name'] as $key => $tmp_name) {
            $fileExtension = pathinfo($_FILES[$fileInputName]['name'][$key], PATHINFO_EXTENSION);
            $uniqueFileName = "{$modelData['id']}_" . uniqid() . '_' . date('U') . '.' . $fileExtension;
            $filePath = $uploadFolder . $uniqueFileName;

            if (!move_uploaded_file($tmp_name, $filePath)) {
                return false;
            }

            $this->imagePaths[] = $filePath;
        }

        if (!empty($this->imagePaths)) {
            $modelData[$fileInputName] = json_encode($this->imagePaths);

            if (!empty($modelData['id'])) {
                return $model->update($modelData['id'], $modelData, ['id' => $modelData['id']]);
            }

            return false;
        }

        return false;
    }

    public function jsonSerialize(): mixed
    {
        return [
            'files' => $this->imagePaths,
        ];
    }
}
