<?php

namespace App\Service;

use Symfony\Component\HttpFoundation\File\UploadedFile;

interface UploadFileInterface {
    /**
     * @param UploadedFile $imageObj
     * @param string $imageName
     * @return string|null retourne le nouveau nom de l'image ou null
     */
    public function upload(UploadedFile $imageObj, string $imageName): ?string;
}