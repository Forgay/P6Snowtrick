<?php
    /**
     * Created by PhpStorm.
     * User: Guillaume
     * Date: 21/08/2018
     * Time: 14:49
     */

namespace App\DataFixtures;

    use App\Entity\Category;
    use App\Entity\Image;
    use App\Entity\Trick;
    use Doctrine\Bundle\FixturesBundle\Fixture;
    use Doctrine\Common\Persistence\ObjectManager;

class Fixtures extends Fixture
{

    /**
     * Load data fixtures with the passed EntityManager
     *
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        // Category
        $grabs = new Category();
        $grabs->setName('Grabs');
        $manager->persist($grabs);

        $rotation = new Category();
        $rotation->setName('Rotation');
        $manager->persist($rotation);

        $rotation1 = new Category();
        $rotation1->setName('Rotations désaxées');
        $manager->persist($rotation1);

        $flip = new Category();
        $flip->setName('Flips');
        $manager->persist($flip);

        $slide = new Category();
        $slide->setName('Slides');
        $manager->persist($slide);

        $old = new Category();
        $old->setName('Old school');
        $manager->persist($old);

        // Trick

        $trick1 = new Trick();
        $trick1->setName('180°');
        $trick1->setDescription('Un saut avec la moitié d\'un tour complet, aussi surnommé le "un huit".');
        $trick1->setCategory($rotation);
        $manager->persist($trick1);

        $trick2 = new Trick();
        $trick2->setName('360°');
        $trick2->setDescription('Un saut avec une rotation d\'un tour complet, aussi surnommé le "trois six".');
        $trick2->setCategory($rotation);
        $manager->persist($trick2);

        $trick3 = new Trick();
        $trick3->setName('540°');
        $trick3->setDescription('Un saut avec une rotation d\'un tour complet plus un demi, aussi surnommé le "cinq quatre".');
        $trick3->setCategory($rotation1);
        $manager->persist($trick3);

        $trick4 = new Trick();
        $trick4->setName('720°');
        $trick4->setDescription('Un saut avec une double rotation, aussi surnommé le "sept vingt".');
        $trick4->setCategory($rotation1);
        $manager->persist($trick4);

        $trick5 = new Trick();
        $trick5->setName('BackFlip');
        $trick5->setDescription('Rotation en arrière. Il est possible de faire plusieurs flips à la suite.');
        $trick5->setCategory($flip);
        $manager->persist($trick5);

        $trick6 = new Trick();
        $trick6->setName('FrontFlip');
        $trick6->setDescription('Rotation en arriere. Il est possible de faire plusieurs flips à la suite.');
        $trick6->setCategory($flip);
        $manager->persist($trick6);

        $trick7 = new Trick();
        $trick7->setName('BackFlip');
        $trick7->setDescription('Rotation en avant. Il est possible de faire plusieurs flips à la suite.');
        $trick7->setCategory($flip);
        $manager->persist($trick7);

        $trick8 = new Trick();
        $trick8->setName('Indy');
        $trick8->setDescription('Saisie de la carre frontside de la planche, entre les deux pieds, avec la main arrière.');
        $trick8->setCategory($flip);
        $manager->persist($trick8);

        $trick9 = new Trick();
        $trick9->setName('Japan Air');
        $trick9->setDescription('Saisie de l\'avant de la planche, avec la main avant, du coté de la carre frontside.');
        $trick9->setCategory($old);
        $manager->persist($trick9);

        // Image

        $media1 = new Image();
        $media1->setName('180');
        $media1->setExtension('jpg');
        $media1->setTrick($trick1);
        $manager->persist($media1);

        $media2 = new Image();
        $media2->setName('360');
        $media2->setExtension('jpg');
        $media2->setTrick($trick2);
        $manager->persist($media2);

        $media3 = new Image();
        $media3->setName('540');
        $media3->setExtension('jpg');
        $media3->setTrick($trick3);
        $manager->persist($media3);

        $media4 = new Image();
        $media4->setName('720');
        $media4->setExtension('jpg');
        $media4->setTrick($trick4);
        $manager->persist($media4);

        $media5 = new Image();
        $media5->setName('backflip');
        $media5->setExtension('jpg');
        $media5->setTrick($trick5);
        $manager->persist($media5);

        $media6 = new Image();
        $media6->setName('frontflip');
        $media6->setExtension('jpg');
        $media6->setTrick($trick6);
        $manager->persist($media6);

        $media7 = new Image();
        $media7->setName('indy');
        $media7->setExtension('jpg');
        $media7->setTrick($trick7);
        $manager->persist($media7);

        $media8 = new Image();
        $media8->setName('japanair');
        $media8->setExtension('jpg');
        $media8->setTrick($trick8);
        $manager->persist($media8);

        $manager->flush();
    }
}

