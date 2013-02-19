<?php
/**
 * This file is part of Level42PictureBundle.
 *
 * (c) 2013 Level42 / Florent PERINEL
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Level42\PictureBundle\Twig;

use \Twig_Extension;
use \Twig_ExtensionInterface;
use \Twig_Filter_Method;
use \DateTime;

use JMS\DiExtraBundle\Annotation\Service;
use JMS\DiExtraBundle\Annotation\Tag;

use Level42\PictureBundle\Entity\Image;

/**
 * Twig extension class
 * 
 * @Service("level42.picture.twig.extension")
 * @Tag("twig.extension")
 */
class ImageExtension extends Twig_Extension
{
    /**
     * Returns a list of filters to add to the existing list.
     *
     * @return array An array of filters
     */
    public function getFilters()
    {
        return array(
                'resize' => new Twig_Filter_Method($this, 'resizeImageFilter')
                );
    }

    /**
     * Retourne une image redimensionnée à la taille demandée
     * 
     * @param string  $file   Chemin du fichier à redimensionner
     * @param integer $height Hauteur désirée
     * @param integer $width  Largeur visitée
     * 
     * @return string Chemin du fichier redimensionné
     */
    public function resizeImageFilter($file, $height, $width)
    {
        $fileInfo = pathinfo($file);
        
        $resizeFileName = $fileInfo['filename'].'-'.$height.'-'.$width;
        $resizeFileNameExt = $resizeFileName . '.' . $fileInfo['extension'];
        
        if(file_exists($resizeFileNameExt) === false)
        {
            $image = new Image($file);
            $image->setDimensions($height, $width);
            $image->setDir($fileInfo['dirname']);
            $image->setName($resizeFileName);
            $image->save();
        }
        
        return $fileInfo['dirname'] . '/' . $resizeFileNameExt;
    }
    
    /**
     * Retourne le nom du filtre
     * 
     * @return string Nom du filtre
     */
    public function getName()
    {
        return 'level42_picture_extension';
    }
    
}
