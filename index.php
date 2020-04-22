<?php
include_once 'class/workpcsnew.inc.php';

if (isset($_POST['calculate'])) {
    try{
	$materialcode = $_POST['materialcode'];
	$PHI = $_POST['PHI'];
	$L = $_POST['L'];
        $Shape_Code = 'O';
        
        if (!$materialcode){
            throw new Exception("Material Code is Missing");
        }elseif($PHI <= 0){
            throw new Exception("PHI Value is less than 0, Please Check.");
        }elseif($L <= 0){
            throw new exception("L Value is less than 0, Please Check.");
        }
        
	$objRodO = new O($materialcode,$PHI,$L);
        //check if current materialcode has correct Shape_Code;
        $chkShapeCode = $objRodO->isShapeCodeMatch($materialcode, $Shape_Code);
        if(!$chkShapeCode){
            throw new Exception("The material code : {$materialcode} is not a '{$Shape_Code}'");
        }
        
        
	//calculate Material Type :
	$materialType = $objRodO->calMaterialType($materialcode);
        $density = $objRodO->grabDensitybyMType($materialType);
        $objRodO->setDensity($density);
        $volume = $objRodO->calVolume();
        $objRodO->setVolume($volume);
        $weight = $objRodO->calWeight();
        $objRodO->setWeight($weight);
        
        $resultMsg = "\$volume = $volume<br>\$weight = $weight";
    } catch (Exception $e){
        echo $e->getMessage();
    }        
}


?>
<form action='' method='POST'>
    <label>Shape_Code : </label>
    <select>
        <option></option>
    </select>
</form>

<form action='' method="POST">
<table>
	<tr>
        <td>Material Code</td>
        <td>PHI</td>
        <td>L</td>
	</tr>
	<tr>
        <td><input type="text" name="materialcode" id='materialcode'></td>
        <td><input type="text" name="PHI" id='PHI'></td>
        <td><input type="text" name="L" id='L'></td>
        <td><input type="submit" name="O" id='O' value='calculate'></td>
	</tr>
        
</table>
</form>
<?php
    if(isset($resultMsg)){
        Echo $resultMsg;
    }
?>