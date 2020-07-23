<?php


class Avatar{

    private $image;

    
    public function __construct($string, $block = 15, $size = 400){
     
    // block = nombre de block par colonne est par ligne de notre image

    $toGenerate = ceil($block / 2); // ceil = arrondi supérieur

    $hach = md5($string); // permet de récupérer un hach sous form hexadécimal
    $hachSize = $block * $toGenerate; // Nombre de block à générer
    $hach = str_pad($hach, $hachSize, $hach);
    /* Générer des caractères suplémentaires si besoin 
           param1 = variable dans laquel ont veux rajouter des caractères
           param2 = nombre que l'on veut en rajouter
           param3 = variable ou sera pris le nombre de param2 pour complété param1
    */
    $hash_split = str_split($hach);
    $color = substr($hach, 0, 6); // permet de récupérer les 6 premiers caractere de mon hach
    $blockSize = $size / $block; // récupère la taille d'un carré


    $image = imagecreate($size, $size); // Crée une nouvelle image à palette, les deux parametres (taille image)
    $bg = imagecolorallocate($image, 255, 255, 255); // Couleur des carrés sans couleurs, Alloue une couleur pour une image en RGB
    $color = imagecolorallocate($image, hexdec(substr($color, 0, 2)), hexdec(substr($color, 2, 2)), hexdec(substr($color, 4, 2)));
    // Couleur des carrés colorés en reprenant les caractères par deux de mon hach.

    /* Parcourir chaque carré de l'avatar qui est une grille en x et y avec deux 
       boucles for impriquées, une pour parcourir x et l'autre y */

    for($x = 0; $x < $block; $x++){
        for($y = 0; $y < $block; $y++){

            if($x < $toGenerate){ 
                $pixel = hexdec($hash_split[($x * $block) + $y]) % 2 == 0; //hexdec permet de decoder les caractères, ici on récuperère le caractère 0
                //var_dump($pixel); // Valeur booléen aléatoire
            }else{
                $pixel = hexdec($hash_split[(($block - $x) * $block) + $y]) % 2 == 0;
                // / Condition pour symétrie verticale en fesant un retour en arrière sur x pour avoir 1 ou 0 afin d'obtenir une symétrie verticale
            }
           

           $pixelColor = $bg;

           if($pixel){ // Si pixel = true
              
            $pixelColor = $color;
           }

           imagefilledrectangle($image, $x * $blockSize, $y * $blockSize, ($x + 1) * $blockSize, ($y + 1) * $blockSize, $pixelColor); 
           /* Fonction qui permet de dessiner un carré sur une image
              param 1= image dans laquel on veut dessiner nos carrés
              param 2= position x de départ (x * taille du carré)
              param 3= position y de départ (y * talle du carré)
              param 4= position x de fin (x + 1 * taille du carré)
              param 5= position y d'arrivé (y + 1 * taille du carré)
              param 6= couleur du carré
            */
        }
    }

        // Au lieu d'afficher l'image, on la stock dans la variable d'instance $image pour pouvoir la manipuler avec d'autres méthodes
        ob_start();

            imagepng($image);
            $image_data = ob_get_contents();
        ob_end_clean ();

        $this->image = $image_data;
       
    }

    // Affiche l'image, comme on le faisait dans la fonction create()
    public function display(){

        header('Content-type: image/png');

        echo($this->image);

    }

    // Exporte l'image en base64
    public function base64(){

        return 'data:image/png;base64,' . base64_encode($this->image);
    }

    //Sauvegarde l'image dans un fichier
    public function save($filename){

        if(file_put_contents($filename, $this->image)){
            return $filename;
        }
    }


}

