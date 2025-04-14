<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixtures extends Fixture
{
    public function __construct(private UserPasswordHasherInterface $passwordEncoder) {} 

    public function load(ObjectManager $manager): void
    {
        $user = new User();
        $user->setEmail("admin@aol.fr");
        $user->setRoles(['ROLE_ADMIN']);
        $user->setFirstName("admin");
        $user->setLastName("ADMIN");
        $user->setPassword($this->passwordEncoder->hashPassword($user, "admin"));
        $user->setIsVerified(true);
        $user->setCreatedAt(new \DatetimeImmutable());
        $this->addReference('user_01', $user);   

        $manager->persist($user);

        $user = new User();
        $user->setEmail("err22@aol.com");
        $user->setRoles(['ROLE_USER']);
        $user->setFirstName("Erwan");
        $user->setLastName("BILART");
        $user->setPassword($this->passwordEncoder->hashPassword($user, "x4_ikPo-the2"));
        $user->setIsVerified(true);
        $user->setCreatedAt(new \DatetimeImmutable());
        $this->addReference('user_02', $user);   

        $manager->persist($user);

        $user = new User();
        $user->setEmail("jojo@aol.com");
        $user->setRoles(['ROLE_USER']);
        $user->setFirstName("Joseph");
        $user->setLastName("BUDENA");
        $user->setPassword($this->passwordEncoder->hashPassword($user, "p9_iSroo_h18"));
        $user->setIsVerified(true);
        $user->setCreatedAt(new \DatetimeImmutable());
        $this->addReference('user_03', $user);

        $manager->persist($user);

        $user = new User();
        $user->setEmail("thebigman@yahoo.fr");
        $user->setRoles(['ROLE_USER']);
        $user->setFirstName("Alfred");
        $user->setLastName("SCHWARTZ");
        $user->setPassword($this->passwordEncoder->hashPassword($user, "vS_UUP5-45eu"));
        $user->setIsVerified(true);
        $user->setCreatedAt(new \DatetimeImmutable());
        $this->addReference('user_04', $user);

        $manager->persist($user);

        $user = new User();
        $user->setEmail("bille@arc.uk");
        $user->setRoles(['ROLE_USER']);
        $user->setFirstName("Jack");
        $user->setLastName("SPARROW");
        $user->setPassword($this->passwordEncoder->hashPassword($user, "789ik_o-64g2"));
        $user->setIsVerified(true);
        $user->setCreatedAt(new \DatetimeImmutable()); 
        $this->addReference('user_05', $user);

        $manager->persist($user);

        $user = new User();
        $user->setEmail("marc@wanado.fr");
        $user->setRoles(['ROLE_USER']);
        $user->setFirstName("Marc");
        $user->setLastName("DUPONT");
        $user->setPassword($this->passwordEncoder->hashPassword($user, "7j_inPm-tTa3"));
        $user->setIsVerified(true);
        $user->setCreatedAt(new \DatetimeImmutable());
        $this->addReference('user_06', $user);

        $manager->persist($user);

        $manager->flush();
    }
}
