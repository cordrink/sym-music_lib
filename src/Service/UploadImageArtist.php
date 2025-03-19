<?php

namespace App\Service;

use Symfony\Component\HttpFoundation\File\UploadedFile;

class UploadImageArtist implements UploadFileInterface
{
    private string  $destination;

    public function __construct(string $destination){
        $this->destination = $destination;
    }

    /**
     * @param UploadedFile $imageObj
     * @param string $imageName
     * @return string|null retourne le nouveau nom de l'image ou null
     */
    public function upload(UploadedFile $imageObj, string $imageName): ?string
    {
        if ($imageName !== "user.png") {
            // On supprime l'ancien fichier
            \unlink($this->destination . $imageName);
        }
        // On cree le nom du nouveau fichier
        $newFileName = md5(\uniqid('', true)) . "." . $imageObj->guessExtension();
        // On place le fichier charge dans le dossier public
        $imageObj->move($this->destination, $newFileName);
        return $newFileName;

    }
}