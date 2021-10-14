<?php

namespace App\DataFixtures;

use App\Entity\Owner;
use App\Entity\Region;
use App\Entity\Room;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

use App\Entity\User;

class AppFixtures extends Fixture
{
    private UserPasswordEncoderInterface $passwordEncoder;
    public const IDF_REGION_REFERENCE = 'idf-region';

    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }

    public function load(ObjectManager $manager)
    {
        $this->LoadUsers($manager);
    }

    private function loadUsers(ObjectManager $manager)
    {

        $owners = array();

        foreach ($this->getUserData() as [$email,$plainPassword,$role, $familyname, $firstname, $country]) {
            $user = new User();
            $encodedPassword = $this->passwordEncoder->encodePassword($user, $plainPassword);
            $user->setEmail($email);
            $user->setFamilyName($familyname);
            $user->setFirstName($firstname);
            $user->setCountry($country);
            $user->setPassword($encodedPassword);

            $roles = array();
            $roles[] = $role;
            $user->setRoles($roles);

            if($user->isVendor())
            {
                $owner = new Owner();
                $owner->setUser($user);
                array_push($owners, $owner);
                $manager->persist($owner);
            }

            $manager->persist($user);
        }
        $manager->flush();

        $region = new Region();
        $region->setCountry("FR");
        $region->setName("Ile de France");
        $region->setPresentation("La région française capitale");
        $manager->persist($region);

        $manager->flush();
        // Une fois l'instance de Region sauvée en base de données,
        // elle dispose d'un identifiant généré par Doctrine, et peut
        // donc être sauvegardée comme future référence.
        $this->addReference(self::IDF_REGION_REFERENCE, $region);

        $room = new Room();
        $room->setSummary("Analyse complexe");
        $room->setDescription("très joli espace dans C");
        $room->setCapacity(10);
        $room->setAddress("Ensemble des complexes");
        $room->setSuperficy(30);
        $room->setPrice(20);
        $room->setOwner($owners[0]);
        $room->addRegion($this->getReference(self::IDF_REGION_REFERENCE));
        $manager->persist($room);

        $manager->flush();

        $region2 = new Region();
        $region2->setCountry("FR");
        $region2->setName("Evry");
        //$region2->setPreviewImageUrl("https://zupimages.net/up/21/40/rjmx.png");
        $region2->setPresentation("Foyer de TSP");
        $manager->persist($region2);

        $manager->flush();

        $room2 = new Room();
        $room2->setSummary("Machine Learning");
        $room2->setDescription("Espace statistiques stylé");
        $room2->setCapacity(30);
        $room2->setAddress("????");
        $room2->setSuperficy(10);
        $room2->setPrice(10);
        $room2->setOwner($owners[1]);
        $room2->addRegion($region2);
        $manager->persist($room2);

        $manager->flush();

        $room3 = new Room();
        $room3->setSummary("Statistiques");
        $room3->setDescription("Espace statistiques vraiment sympa");
        $room3->setCapacity(30);
        $room3->setAddress("Espace T");
        $room3->setSuperficy(10);
        $room3->setPrice(10);
        $room3->setOwner($owners[2]);
        $room3->addRegion($region);
        $room3->addRegion($region2);
        //$room3->setPreviewImageUrl('https://zupimages.net/up/21/40/kyte.png');
        //$room3->setAdImageUrl('https://zupimages.net/up/21/40/as0u.png');
        $manager->persist($room3);

        $manager->flush();
    }

    private function getUserData()
    {
        yield ['chris@localhost','chris','ROLE_USER', 'heria', 'chris', 'US'];
        yield ['yoann@localhost','yoann','ROLE_OWNER', 'petetin', 'yoann', 'FR'];
        yield ['sylvain@localhost','sylvain','ROLE_OWNER', 'le corff', 'sylvain', 'FR'];
        yield ['jeremy@localhost','jeremy','ROLE_OWNER', 'polish', 'jeremy', 'PO'];
        yield ['anna@localhost','anna','ROLE_ADMIN', 'baratin', 'anna', 'UK'];

    }
}