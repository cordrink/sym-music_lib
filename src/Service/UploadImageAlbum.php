<?php

namespace App\Service;

use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class UploadImageAlbum implements UploadFileInterface
{
    private ParameterBagInterface $parameterBag;

    public function __construct(ParameterBagInterface $parameterBag){
        $this->parameterBag = $parameterBag;
    }

    /**
     * @param UploadedFile $imageObj
     * @param string $imageName
     * @return string|null retourne le nouveau nom de l'image ou null
     */
    public function upload(UploadedFile $imageObj, string $imageName): ?string
    {
        //dd($imageName);
        if ($imageName !== "pochette_vierge.jpg") {
            // On supprime l'ancien fichier
            \unlink($this->parameterBag->get("imagesAlbumsDestination") . $imageName);
        }
        // On cree le nom du nouveau fichier
        $newFileName = md5(\uniqid('', true)) . "." . $imageObj->guessExtension();
        // On place le fichier charge dans le dossier public
        $imageObj->move($this->parameterBag->get("imagesAlbumsDestination"), $newFileName);
        return $newFileName;

    }
}