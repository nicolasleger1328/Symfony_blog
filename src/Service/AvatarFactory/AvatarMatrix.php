<?php

//$coumeurs peut etre sur tableau associatif pour asser des elements

namespace App\Service\AvatarFactory;




class AvatarMatrix{

    private int     $taille;
    private array   $matrix;
    private int     $couleurs;
    public const    DEFAULT_SIZE = 5;
    
    public function __construct(int $taille=self::DEFAULT_SIZE, int $couleurs=self::DEFAULT_SIZE)
    {   
        $this->taille= $taille;
        $this->matrix = [];
        $this->couleurs = $couleurs;
        $colorTab = Couleurs::randColor($couleurs);
        for($i=0; $i<$this->taille; $i++)
        {
            $ligne = [];
            for($j=0; $j<$this->taille/2; $j++)
            {
                $ligne[]= $colorTab[array_rand($colorTab)];
            }
            if($this->taille%2==0)
            {
                
                $this->matrix[]= array_merge($ligne, array_reverse($ligne)); 
            }else{
                
                $this->matrix[]= array_merge($ligne, array_reverse(array_splice($ligne,0 , ($this->taille-1)/2)));
            }
        }
    }

    /**
     * @return array
     */
    public function getMatrix(): array
    {
        return $this->matrix;
    }

    /**
     * @return int
     */
    public function getTaille(): int
    {
        return $this->taille;
    }
}
