<?php

include 'class/workpcsnew.inc.php';

// TEST DATA AREA
$test_data = array(
                array('materialcode' => 'kd21s','PHI' => '25','L' => '300'),
                array('materialcode' => '12311s','PHI' => '10','L' => '460'),
                array('materialcode' => '1050s','PHI' => '30','L' => '1000'),
                array('materialcode' => '705s','PHI' => '35','L' => '1250'),
                array('materialcode' => 'ramaxshaft','PHI' => '50','L' => '800'),
                array('materialcode' => 'msbss','PHI' => '60','L' => '900'),
                array('materialcode' => 'bssts','PHI' => '100','L' => '250.6'),
                array('materialcode' => 'crsts','PHI' => '45','L' => '1234.89'),
                array('materialcode' => 'sssts','PHI' => '80','L' => '345.89'),
                array('materialcode' => 'ss310sts','PHI' => '65','L' => '3434'),
                array('materialcode' => 'msbss','PHI' => '-60','L' => '900'),
                array('materialcode' => '705s','PHI' => NULL,'L' => '1250'),
                array('materialcode' => 'sssts','PHI' => '1.11','L' => '-0.15'),
                array('materialcode' => 'ss304pes','PHI' => '50','L' => '600'),
                array('materialcode' => 'ss316lpes','PHI' => '24','L' => '450')
            );
//====================================
foreach ($test_data as $cRow){
    $PHI = $cRow['PHI'];
    $L = $cRow['L'];
    $materialcode = $cRow['materialcode'];
    $dimension = [$PHI,$L];
    echo "\$materialcode = $materialcode , \$PHI = $PHI , \$L = $L<br><br>";
    
        if($PHI <= 0){
        #    throw new Exception("The Value of 'PHI' is not valid, please check<br>");       
            echo "The value of PHI is not valid [{$PHI}], Calculation will be incorrect<br>";      
        }elseif($L <= 0){
            #    throw new Exception("The Value of 'L' is not valid, please check<br>");
            echo "The value of L is not valid [{$L}], Calculation will be incorrect<br>"; 
        }elseif(!$materialcode){ // $materialcode is empty
            #throw new Exception("Material Code cannot be empty!<br>");
            echo "Material Code cannot be empty ! <br>";
        }else{

            $objO = new O($materialcode,$PHI,$L);

            $isShapeCodematch = $objO->isShapeCodeMatch($materialcode);
            $Shape_Code = $objO->getShape_Code();
            if ($isShapeCodematch != 'yes'){
                echo "Current process Shape_Code = {$Shape_Code}<br>";
                echo "It does not match Shape_Code contained in Material : '{materialcode}'.<br>Skipping this input<br>";
            }else{

                $materialType = $objO->getMaterialType();
                $density = $objO->grabDensitybyMType($materialType);
                $objO->setDensity($density);
                $volume = $objO->calVolume();
                $objO->setVolume($volume);
                $weight = $objO->calWeight();
                echo "\$density = $density<br>";
                echo "\$volume = $volume<br>";
                echo "\$weight = $weight<br>";
            }
        }
        
        echo "===================================================<br>";
}




/**


$thick = "25";
$width = "345";
$length = "450";
$materialcode = 'kd21p';
$dimension = [$thick, $width, $length];
$objPlaten = new PLATEN($materialcode, $thick, $width, $length);

//$myThick = $objPlaten->getT();
//$myWidth = $objPlaten->getW();
//$myLength = $objPlaten->getL();

echo "\$myThick = $thick , \$myWidth = $width ,  \$myLength = $length <br>";

$materialType = $objPlaten->getMaterialType();
$density = $objPlaten->grabDensitybyMType($materialType);
$objPlaten->setDensity($density);
$volume = $objPlaten->calVolume();
$objPlaten->setVolume($volume);
$weight = $objPlaten->calWeight();
echo "\$materialcode = $materialcode ,\$density  = $density  , \$Volume = $volume , \$weight = $weight<br>";

echo "<br>################################################################################<br>";
$DIA = "25";
$length = "450";
$materialcode = 'sssfs';
//$dimension = [$DIA, $length];
$objShaft = new O($materialcode, $DIA, $length);

echo "\$materialcode =$materialcode  \$DIA = $DIA ,  \$myLength = $length <br>";
$materialType = $objShaft->getMaterialType();
$density = $objShaft->grabDensitybyMType($materialType);
$objShaft->setDensity($density);
$volume = $objShaft->calVolume();
$objShaft->setVolume($volume);
$weight = $objShaft->calWeight();
echo "\$materialcode = $materialcode ,\$density  = $density  , \$Volume = $volume , \$weight = $weight<br>";

echo "<br>################################################################################<br>";
$thick = "25";
$width = "300";
$length = "600";
$materialcode = 'ss3041bp';
$dimension = [$thick, $width, $length];
$objPlaten = new PLATEN($materialcode, $thick, $width, $length);

//$myThick = $objPlaten->getT();
//$myWidth = $objPlaten->getW();
//$myLength = $objPlaten->getL();

echo "\$myThick = $thick , \$myWidth = $width ,  \$myLength = $length <br>";

$materialType = $objPlaten->getMaterialType();
$density = $objPlaten->grabDensitybyMType($materialType);
$objPlaten->setDensity($density);
$volume = $objPlaten->calVolume();
$objPlaten->setVolume($volume);
$weight = $objPlaten->calWeight();
echo "\$materialcode = $materialcode ,\$density  = $density  , \$Volume = $volume , \$weight = $weight<br>";

echo "<br>################################################################################<br>";

$thick = "50";
$width = "500";
$length = "900";
$materialcode = 'mspenp';
$dimension = [$thick, $width, $length];
$objPlaten = new PLATEN($materialcode, $thick, $width, $length);


echo "\$myThick = $thick , \$myWidth = $width ,  \$myLength = $length <br>";

$materialType = $objPlaten->getMaterialType();
$density = $objPlaten->grabDensitybyMType($materialType);
$objPlaten->setDensity($density);
$volume = $objPlaten->calVolume();
$objPlaten->setVolume($volume);
$weight = $objPlaten->calWeight();
echo "\$materialcode = $materialcode ,\$density  = $density  , \$Volume = $volume , \$weight = $weight<br>";

echo "<br>################################################################################<br>";

$thick = "35";
$width = "100.50";
$length = "500";
$materialcode = '705s';
$dimension = [$thick, $width, $length];
$objPlaten = new PLATEN($materialcode, $thick, $width, $length);

$isShapeCodematch = $objPlaten->isShapeCodeMatch($materialcode);
$Shape_Code = $objPlaten->getShape_Code();
if ($isShapeCodematch != 'yes') {
    echo "the Shape_Code is " . $Shape_Code . "<br>";
    echo "Do not calculate this input<br>";
} else {



    echo "\$myThick = $thick , \$myWidth = $width ,  \$myLength = $length <br>";

    $materialType = $objPlaten->getMaterialType();
    $density = $objPlaten->grabDensitybyMType($materialType);
    $objPlaten->setDensity($density);
    $volume = $objPlaten->calVolume();
    $objPlaten->setVolume($volume);
    $weight = $objPlaten->calWeight();
    echo "\$materialcode = $materialcode ,\$density  = $density  , \$Volume = $volume , \$weight = $weight<br>";
}


$thick = "50";
$width = "500";
$length = "800";
$materialcode = '3dmdlg';
$dimension = [$thick, $width, $length];
$objPlaten = new PLATEN($materialcode, $thick, $width, $length);


echo "\$myThick = $thick , \$myWidth = $width ,  \$myLength = $length <br>";

$materialType = $objPlaten->getMaterialType();
$density = $objPlaten->grabDensitybyMType($materialType);
$objPlaten->setDensity($density);
$volume = $objPlaten->calVolume();
$objPlaten->setVolume($volume);
$weight = $objPlaten->calWeight();
echo "\$materialcode = $materialcode ,\$density  = $density  , \$Volume = $volume , \$weight = $weight<br>";

echo "<br>################################################################################<br>";

**/
?>
