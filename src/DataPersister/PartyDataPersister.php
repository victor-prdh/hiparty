<?php

namespace App\DataPersister;

use App\Entity\Party;
use Doctrine\ORM\EntityManagerInterface;
use ApiPlatform\Core\DataPersister\ContextAwareDataPersisterInterface;
use Symfony\Component\Security\Core\Security;

/**
 *
 */
class PartyDataPersister implements ContextAwareDataPersisterInterface
{
    private $_entityManager;
    private $security;
    public function __construct(
        EntityManagerInterface $entityManager,
        Security $security
    ) {
        $this->_entityManager = $entityManager;
        $this->security = $security;
    }

    /**
     * {@inheritdoc}
     */
    public function supports($data, array $context = []): bool
    {
        return $data instanceof Party;
    }

    /**
     * @param Party $data
     */
    public function persist($data, array $context = [])
    {
        if ($data->getNumeroLieux() && $data->getRue() && $data->getVille() && $data->getCodePostal()) {
            $adresse = $data->getNumeroLieux() . " " . $data->getRue() . " " . $data->getVille() . " " . $data->getCodePostal();
            $data->setLieux($adresse);
            $apiGeocode = "https://api.opencagedata.com/geocode/v1/json?key=beb470cd8c3c4ac286f4b03f5084c696&q=". urlencode($adresse) ."&pretty=1&no_annotations=1";
            $rawGeocode = file_get_contents($apiGeocode);
            $geoData = json_decode($rawGeocode, true);
            $lat = $geoData["results"][0]["geometry"]["lat"];
            $lng = $geoData["results"][0]["geometry"]["lng"];
            
            $data->setLongitude($lng);
            $data->setLatitude($lat);
            $data->setOrganisateur($this->security->getUser());
        }

        if ($data->getPhoto()) {
            $b64Photo = $data->getPhoto();
            
            $ROOT = \dirname(__DIR__);

            $img = explode( ',', $b64Photo );
            $extension = explode('/', mime_content_type($b64Photo))[1];
            $image = base64_decode($img[1]);
            $imgName = rand() .'.'. $extension;
            
            file_put_contents($ROOT.'/../public/uploads/'. $imgName , $image);

            //imagejpeg($image, $ROOT.'../public/uploads/' . $new_image_name, 75);

            $data->setPhoto('/uploads/'.$imgName);
            

        }

        $this->_entityManager->persist($data);
        $this->_entityManager->flush();
    }

    /**
     * {@inheritdoc}
     */
    public function remove($data, array $context = [])
    {
        $this->_entityManager->remove($data);
        $this->_entityManager->flush();
    }
}