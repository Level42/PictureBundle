<?php
/**
 * This file is part of VersusCommonBundle.
 *
 * (c) 2013 Level42 / Florent PERINEL
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Versus\CommonBundle\Entity;

/**
 * Class use to manipulate pictures
 */
class Image 
{
    /**
     * 
     * @var unknown
     */
    private $file;
    
    /**
     * 
     * @var unknown
     */
    private $image_width;
    
    /**
     * 
     * @var unknown
     */
    private $image_height;
    
    /**
     * 
     * @var unknown
     */
    private $width;
    
    /**
     * 
     * @var unknown
     */
    private $height;
    
    /**
     * 
     * @var unknown
     */
    private $ext;
    
    /**
     * 
     * @var unknown
     */
    private $types = array('', 'gif', 'jpeg', 'png', 'swf');
    
    /**
     * 
     * @var unknown
     */
    private $quality = 80;
    
    /**
     * 
     * @var unknown
     */
    private $top = 0;
    
    /**
     * 
     * @var unknown
     */
    private $left = 0;
    
    /**
     * 
     * @var unknown
     */
    private $crop = false;
    
    /**
     * 
     * @var unknown
     */
    private $type;

    /**
     * Constructor
     * 
     * @param string $name Picture name
     */
    function __construct($name)
    {
        $this->file = $name;
        $info = getimagesize($name);
        $this->image_width = $info[0];
        $this->image_height = $info[1];
        $this->type = $this->types[$info[2]];
        $info = pathinfo($name);
        $this->dir = $info['dirname'];
        $this->name = str_replace('.' . $info['extension'], '', $info['basename']);
        $this->ext = $info['extension'];
    }

    /**
     * Set directory
     * @param string $dir
     */
    function setDir($dir)
    {
        $this->dir = $dir;
    }

    /**
     * Get directory
     * @return string <string, mixed>
     */
    function getDir()
    {
        return $this->dir;
    }

    /**
     * Set name
     * @param string $name
     */
    function setName($name)
    {
        $this->name = $name;
    }

    /**
     * Get name
     * @return string<string, mixed>
     */
    function getName()
    {
        return $this->name;
    }

    /**
     * Set picture width
     * @param integer $width
     */
    function setWidth($width)
    {
        $this->width = $width;
    }

    /**
     * Set picture height
     * @param integer $height
     */
    function setHeight($height)
    {
        $this->height = $height;
    }

    /**
     * Set picture dimensions
     * @param integer $height
     * @param integer $width
     */
    function setDimensions($height, $width)
    {
        $this->height = $height;
        $this->width = $width;
    }
    
    /**
     * Resize picture
     * 
     * @param number $percentage
     */
    function resize($percentage = 50)
    {
        if ($this->crop) 
        {
            $this->crop = false;
            $this->width = round($this->width * ($percentage / 100));
            $this->height = round($this->height * ($percentage / 100));
            $this->image_width = round($this->width / ($percentage / 100));
            $this->image_height = round($this->height / ($percentage / 100));
        } else {
            $this->width = round($this->image_width * ($percentage / 100));
            $this->height = round($this->image_height * ($percentage / 100));
        }

    }

    /**
     * Crop a file
     * 
     * @param number $top
     * @param number $left
     */
    function crop($top = 0, $left = 0)
    {
        $this->crop = true;
        $this->top = $top;
        $this->left = $left;
    }

    /**
     * Set file quality
     * @param number $quality
     */
    function setQuality($quality = 80)
    {
        $this->quality = $quality;
    }

    /**
     * Show picture
     */
    function show()
    {
        $this->save(true);
    }

    /**
     * Save image to a file or display it
     * 
     * @param string $show True for diplay
     */
    function save($show = false)
    {
        if ($show)
        {
            @header('Content-Type: image/' . $this->type);
        }
        
        if (!$this->width && !$this->height) 
        {
            $this->width = $this->image_width;
            $this->height = $this->image_height;
        } elseif (is_numeric($this->width) && empty($this->height)) {
            $this->height = round($this->width / ($this->image_width / $this->image_height));
        
        } elseif (is_numeric($this->height) && empty($this->width)) {
            $this->width = round($this->height / ($this->image_height / $this->image_width));
        
        } else {
            if ($this->width <= $this->height) 
            {
                $height = round($this->width / ($this->image_width / $this->image_height));
                if ($height != $this->height)
                {
                    $percentage = ($this->image_height * 100) / $height;
                    $this->image_height = round($this->height * ($percentage / 100));
                }
            } else {
                $width = round($this->height / ($this->image_height / $this->image_width));
                if ($width != $this->width)
                {
                    $percentage = ($this->image_width * 100) / $width;
                    $this->image_width = round($this->width * ($percentage / 100));
                }
            }
        }

        if ($this->crop)
        {
            $this->image_width = $this->width;
            $this->image_height = $this->height;
        }

        if ($this->type == 'jpeg')
        {
            $image = imagecreatefromjpeg($this->file);
        }
        
        if ($this->type == 'png')
        {
            $image = imagecreatefrompng($this->file);
        }
        
        if ($this->type == 'gif')
        {
            $image = imagecreatefromgif($this->file);
        }
        
        $new_image = imagecreatetruecolor($this->width, $this->height);
        imagecopyresampled($new_image, $image, 0, 0, 
                $this->top, 
                $this->left,
                $this->width, 
                $this->height, 
                $this->image_width,
                $this->image_height);

        $name = $show ? null : $this->dir . DIRECTORY_SEPARATOR . $this->name . '.' . $this->ext;
        
        if ($this->type == 'jpeg')
        {
            imagejpeg($new_image, $name, $this->quality);
        }
        
        if ($this->type == 'png')
        {
            imagepng($new_image, $name);
        }
        
        if ($this->type == 'gif')
        {
            imagegif($new_image, $name);
        }
        
        imagedestroy($image);
        imagedestroy($new_image);
    }

}

?>