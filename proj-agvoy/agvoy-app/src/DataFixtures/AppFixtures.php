<?php

namespace App\DataFixtures;

use App\Entity\Owner;
use App\Entity\Region;
use App\Entity\Room;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    // définit un nom de référence pour une instance de Region
    public const IDF_REGION_REFERENCE = 'idf-region';

    public function load(ObjectManager $manager)
    {
        //...

        $region = new Region();
        $region->setCountry("FR");
        $region->setName("Ile de France");
        $region->setPresentation("La région française capitale");
        $region->setPreviewImageUrl("https://zupimages.net/up/21/40/mocp.png");
        $manager->persist($region);

        $manager->flush();
        // Une fois l'instance de Region sauvée en base de données,
        // elle dispose d'un identifiant généré par Doctrine, et peut
        // donc être sauvegardée comme future référence.
        $this->addReference(self::IDF_REGION_REFERENCE, $region);

        $owner = new Owner();
        $owner->setFamilyName("Douc");
        $owner->setFirstname("Randal");
        $owner->setAddress("5 Rue du puits de la Laguarde");
        $owner->setCountry("France");
        $manager->persist($owner);
        $manager->flush();

        $room = new Room();
        $room->setSummary("Analyse complexe");
        $room->setDescription("très joli espace dans C");
        $room->setCapacity(10);
        $room->setAddress("Ensemble des complexes");
        $room->setSuperficy(30);
        $room->setPrice(20);
        $room->setPreviewImageUrl('https://zupimages.net/up/21/40/8y6a.png');
        $room->setAdImageUrl('https://zupimages.net/up/21/40/pme9.png');
        //$room->addRegion($region);
        // On peut plutôt faire une référence explicite à la référence
        // enregistrée précédamment, ce qui permet d'éviter de se
        // tromper d'instance de Region :
        $room->setOwner($owner);
        $room->addRegion($this->getReference(self::IDF_REGION_REFERENCE));
        $manager->persist($room);

        $manager->flush();

        $region2 = new Region();
        $region2->setCountry("FR");
        $region2->setName("Evry");
        $region2->setPreviewImageUrl("https://zupimages.net/up/21/40/rjmx.png");
        $region2->setPresentation("Foyer de TSP");
        $manager->persist($region2);

        $manager->flush();

        $owner2 = new Owner();
        $owner2->setFamilyName("Le Corff");
        $owner2->setFirstname("Sylvain");
        $owner2->setAddress("13 Rue du Levant");
        $owner2->setCountry("France");
        $manager->persist($owner2);
        $manager->flush();

        $room2 = new Room();
        $room2->setSummary("Machine Learning");
        $room2->setDescription("Espace statistiques stylé");
        $room2->setCapacity(30);
        $room2->setAddress("????");
        $room2->setSuperficy(10);
        $room2->setPrice(10);
        $room2->setPreviewImageUrl('https://zupimages.net/up/21/40/woov.png');
        $room2->setAdImageUrl('https://zupimages.net/up/21/40/qk5l.png');
        //$room->addRegion($region);
        // On peut plutôt faire une référence explicite à la référence
        // enregistrée précédamment, ce qui permet d'éviter de se
        // tromper d'instance de Region :
        $room2->setOwner($owner2);
        $room2->addRegion($region2);
        $manager->persist($room2);

        $manager->flush();

        $owner3 = new Owner();
        $owner3->setFamilyName("Petetin");
        $owner3->setFirstname("Yoann");
        $owner3->setAddress("43 Rue Saint jacques");
        $owner3->setCountry("France");
        $manager->persist($owner3);
        $manager->flush();

        $room3 = new Room();
        $room3->setSummary("Statistiques");
        $room3->setDescription("Espace statistiques vraiment sympa");
        $room3->setCapacity(30);
        $room3->setAddress("Espace T");
        $room3->setSuperficy(10);
        $room3->setPrice(10);
        //$room->addRegion($region);
        // On peut plutôt faire une référence explicite à la référence
        // enregistrée précédamment, ce qui permet d'éviter de se
        // tromper d'instance de Region :
        $room3->setOwner($owner3);
        $room3->addRegion($region);
        $room3->addRegion($region2);
        $room3->setPreviewImageUrl('https://zupimages.net/up/21/40/kyte.png');
        $room3->setAdImageUrl('https://zupimages.net/up/21/40/as0u.png');
        $manager->persist($room3);

        $manager->flush();

        //...
    }

}
