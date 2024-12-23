<?php

namespace App\DataFixtures;

use App\Entity\Album;
use App\Entity\Artiste;
use App\Entity\Piece;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use EsperoSoft\Faker\Faker;
use Faker\Factory;
use phpDocumentor\Reflection\Types\This;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $fakerEspero = new Faker();
        $faker = Factory::create("fr_FR");

        $ArtistArr = $this->loadFile('artiste.csv');

        $genres = ["men", "women"];
        foreach ($ArtistArr as $Artist) {
            $artist = new Artiste();
            $artist->setId(intval($Artist[0]))
                ->setName($Artist[1])
                ->setContent("<p>" . $fakerEspero->text(15) . "</p>")
                ->setSite("lien de site")
                ->setImageUrl('https://randomuser.me/api/portraits/' . $faker->randomElement($genres) . "/" . mt_rand(1, 99) . ".jpg")
                ->setType(intval($Artist[2]));

            $manager->persist($artist);
            $this->addReference("artiste" . $artist->getId(), $artist);
        }

        $albumArr = $this->loadFile('album.csv');

        foreach ($albumArr as $Album) {
            $album = new Album();
            $album->setId(intval($Album[0]))
                ->setName($Album[1])
                ->setCreatedAt(intval($Album[2]))
                ->setImageUrl($faker->imageUrl())
                ->setArtist($this->getReference("artiste" . $Album[4], Artiste::class));

            $manager->persist($album);
            $this->addReference("album" . $album->getId(), $album);
        }

        $pieceArr = $this->loadFile('morceau.csv');

        foreach ($pieceArr as $Piece) {
            $piece = new Piece();
            $piece->setId(intval($Piece[0]))
                ->settitle($Piece[2])
                ->setAlbum($this->getReference("album" . $Piece[1], Album::class))
                ->setDuration(date("i:s", $Piece[3]));
            $manager->persist($piece);
            $this->addReference("piece" . $piece->getId(), $piece);
        }

        $manager->flush();
    }

    public function loadFile(string $file): array
    {
        $fileCsv = fopen(__DIR__ . "/" . $file, "r");
        $dataArr = [];

        while (($data = fgetcsv($fileCsv)) !== false) {
            // Vérifiez que la ligne contient des données valides
            if (is_array($data) && count($data) > 2) {
                $dataArr[] = $data;
            }
        }
        fclose($fileCsv);

        return $dataArr;
    }
}
