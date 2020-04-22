<?php
include_once 'class/dbh.inc.php';

Class Dimensions {

    protected $dimensionArray = array();

    function __construct() {

    }

    function split_dimension_to_array($dimensionArray = array()) {
        $row = $dimensionArray;
        $trimStr = preg_replace("/( )/", "", $row['Description_2']); //removes all space
        #echo $trimStr."<br>";
        $lowerStr = strtolower($trimStr);
        #$matches = preg_match("//", subject)
        $splitDescription = preg_split("/(x|X)/", $lowerStr); //makes the string lowercase, and separate each by 'X'
        #print_r($splitDescription);
        $dimension = [];
        foreach ($splitDescription as $value) {

            if ($value == 'he') {
                $value = 'hex';
            }

            if (($pos = strpos($value, ':')) !== false) { //--> check if there's any other character besides dimensions
                $newStr = substr($value, $pos + 1);
            } else {
                $newStr = $value;
            }
            #    echo "\$newStr = $newStr <br>";
            if (substr($newStr, -2) == "ft") { //--> convert to mm if the text is written as ft
                $strLen = strlen($newStr);
                $numStr = substr($newStr, 0, $strLen - 2);
                $newDescription = (floatval($numStr) * 304.80) . "mm";
                #echo "\$strLen = ".$finDescription."<br>";
            } elseif (substr($newStr, -1) == "m" AND substr($newStr, -2) !== "mm") {
                $strLen = strlen($newStr);
                $numStr = substr($newStr, 0, $strLen - 1);
                $newDescription = (floatval($numStr) * 1000) . "mm";
                #echo "\$strLen = ".$finDescription."<br>";.
            } else {
                $newDescription = $newStr;
            }
            #    echo "\$newDescription = $newDescription<br>";

            /*            //deletes DIA and MM
              $replace_array = array("dia,","dia;","dia:","dia.","dia","mm");

              $finDescription = floatval(str_replace($replace_array,"", $newDescription)); //--> removes "mm" and convert the number into float
             */       #    echo $finDescription."<br>";
            array_push($dimension, $newDescription);
#           array_push($dimension, $finDescription);
            #echo $newDescription."<br>";
        }
        #echo $lowerStr." Has been separated into : (".$dimension['0'].") (".$dimension['1'].") (".$dimension['2'].")<br>";
//        echo"<br>####################################<br>";
//        print_r($dimension);
//        echo"<br>####################################<br>";
        return $dimension;
    }

}


Class SQL extends Dbh {

    protected $sql; // class common variable

    public function __construct($sql) {//from program line inject into constructor
        $this->sql = $sql; //assign the protected $sql ($this->sql to the value of
        // injected value $sql.
    }

    public function getResultRowArray() {
        $resultset = array(); //define empty array
        $sql = $this->sql; // assign private $sql by the value of protected $sql
        //                  ($this->sql)
        //echo "\$sql = $sql <br>";
        $stmt = $this->connect()->prepare($sql); // $stmt must be local variable
        $stmt->execute();
        if ($stmt->rowCount()) {
            $row = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $resultset = $row;
            //echo "line 122 \$resultset from Line 118 \$smt->execute() of \$sql<br>";
            //echo "the array of sql reuslt : <br>";
            //  print_r($resultset);
            //echo "=========================<br>";
        } else {
            // do nothing;
            //echo "no result on SQL <br>";
        }

        return $resultset;
    }

    public function getResultOneRowArray() {
        $row = array();
        $sql = $this->sql;

//        echo "\$sql = $sql <br>";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute();
        if ($stmt->rowCount()) {
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
        }

        return $row;
    }

    public function getRowCount() {

        $sql = $this->sql;
        //echo "\$sql = $sql <br>";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute();
        $number_of_rows = $stmt->fetchColumn();
        // echo "\$number_of_rows =  $number_of_rows <br>";
        return $number_of_rows;
    }

    public function getUpdate() {

        $sql = $this->sql;
        //echo "Line 165 , in getUpdate function of Class SQL,  \$sql = $sql <br>";
        $stmt = $this->connect()->prepare($sql);

        if ($stmt->execute()) {
            $result = 'updated';
        } else {
            $result = 'update fail';
        }
        return $result;
    }

    public function InsertData() {

        $sql = $this->sql;
        //echo "\$sql = $sql <br>";
        $stmt = $this->connect()->prepare($sql);

        if ($stmt->execute()) {
            $result = 'insert ok!';
        } else {
            $result = 'insert fail';
        }
        //echo "\$result = $result <br>";
        return $result;
    }

    public function getDelete() {

        $sql = $this->sql;
//        echo "\$sql = $sql <br>";
        $stmt = $this->connect()->prepare($sql);

        if ($stmt->execute()) {
            $result = 'delete ok';
        } else {
            $result = 'delete failed';
        }
        return $result;
    }

    public function getTruncate(){
        $sql = $this->sql;
        $stmt = $this->connect()->prepare($sql);

        if($stmt->execute()){
            $result = 'truncate ok';
        }else{
            $result = 'truncate failed';
        }
        return $result;
    }

//    public function getPartialLimit(){
//
//        $sql = $this->sql;
////        echo "\$sql = $sql <br>";
//        $stmt = $this->connect()->prepare($sql);
//
//        $stmt->execute();
//        if ($stmt->rowCount() > 0) {
//            // Define how we want to fetch the results
//            $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
//        }
//
//        return
//    }
}

Class SQLBINDPARAM extends SQL {

    protected $sql;
    protected $bindparamArray;

    public function __construct($sql, $bindparamArray) {

        parent::__construct($sql);
        $this->bindparamArray = $bindparamArray;
    }

    public function InsertData2() {
        
            $sql = $this->sql;
            #echo $sql."<bR>";
            $stmt = $this->connect()->prepare($sql);
            $bindparamArray = $this->bindparamArray;
            $testParamArray = array();
    //        unset($bindparamArray['submit']);
    //        print_r($bindparamArray);
    //        echo "<br>";
    //        $para = "";

            foreach ($bindparamArray as $key => $value) {
                # code...
                ${$key} = $value;
                $bindValue = $key;
                $bindParamdata = "bindParam(:{$bindValue}, $$bindValue) == " . $$bindValue; //this is for debugging purposes
                array_push($testParamArray,"\$bindParamdata = $bindParamdata");
    //            echo "\$bindParamdata = $bindParamdata <br>";
                #########################################################
                # this line not successful, how to check in the future
                //  $stmt->bindParam(":$key", $value);
                ##########################################################
    //          # this line is working,                                  #
                # {$bindValue} = calls the $key value                    #
                # $$bindValue = calls the value contained by $key array  #
                ##########################################################

                $stmt->bindParam(":{$bindValue}", $$bindValue);
            }

    //        echo "=====var_dump \$stmt==================<br>";
    //        var_dump($stmt);
    //        echo "=====end of var_dump \$stmt==================<br>";
    //    echo "<pre>";
        try{
            $stmt->execute();
            #if($stmt->execute()){
                $result = 'insert ok!';
                $_SESSION['whyMsg'] = $testParamArray;
            #}else{
            #    throw new Exception("Warning, Found Error in MySQL Statement");
            #}
        }catch(Exception $e){
            $result = 'insert fail';
            echo "Error inserting data while using above parameters, please check.<br>";
            echo "Message : ".$e->getMessage();
        }
    //    echo "</pre>";
    //        if ($stmt->execute()) {
    //            $result = 'insert ok!';
    //        } else {
    //           $result = 'insert fail';
    //        }
            return $result;
    }

    public function UpdateData2() {

        $sql = $this->sql;
        #echo $sql."<bR>";
        $stmt = $this->connect()->prepare($sql);
        $bindparamArray = $this->bindparamArray;
//        unset($bindparamArray['submit']);
//        print_r($bindparamArray);
//        echo "<br>";
//        $para = "";

        foreach ($bindparamArray as $key => $value) {
            # code...
            ${$key} = $value;
            $bindValue = $key;
            $bindParamdata = "bindParam(:{$bindValue}, $$bindValue) == " . $$bindValue; //this is for debugging purposes
            #echo "\$bindParamdata = $bindParamdata <br>";
            #########################################################
            # this line not successful, how to check in the future
            //  $stmt->bindParam(":$key", $value);
            ##########################################################
//          # this line is working,                                  #
            # {$bindValue} = calls the $key value                    #
            # $$bindValue = calls the value contained by $key array  #
            ##########################################################

            $stmt->bindParam(":{$bindValue}", $$bindValue);
        }

//        echo "=====var_dump \$stmt==================<br>";
//        var_dump($stmt);
//        echo "=====end of var_dump \$stmt==================<br>";

        try {
            $stmt->execute();
            $result = 'update ok!';
        } catch (Exception $e) {
            $result = 'update fail';
            echo "Error inserting data while using above parameters, please check.<br>";
            echo "Message : ".$e->getMessage();
            
        }

        #if ($stmt->execute()) {
        #    $result = 'update ok';
        #} else {
        #    $result = 'update fail';
        #}
        #echo "<br>$result<br>";
        return $result;
    }

}

Class SQLbind {

    protected $inputArray;
    protected $dbtable;

    public function __construct($inputArray/*Array that would be inserted*/,
                                $dbtable/*target table*/) {

        $this->inputArray = $inputArray;
        $this->dbtable = $dbtable;
    }

    public function create() {
        $inputArray = $this->inputArray;
        $dbtable = $this->dbtable;
        $arrayCount = count($inputArray);

        $sqlInsert = "INSERT INTO $dbtable
               SET ";
        $i = 0;
        foreach ($inputArray as $key => $value) {
            $i++;
            if ($key == 'id') {
                if($dbtable == 'calpurchase'){
                    $sqlInsert .= "pid=:{$key}";
                }
            } else {
                $sqlInsert .= $key . "=:{$key}";
                $this->$key = $value;
            }
            if ($i < $arrayCount) {
                $sqlInsert .= ", ";
            }
        }
        #$qr .= "density =:density, volume=:volume, weight=:weight";
//        echo $sqlInsert . "<br>";

        $objSQL = new SQLBINDPARAM($sqlInsert, $inputArray);

        $result = $objSQL->InsertData2();
        if ($result == 'insert ok!') {
            $info = "Insert Successful<br>";
        } else {
            $info = "Insert Failed<br>";
        }
        return $info;
    }

    public function update() {

        $inputArray = $this->inputArray;
        $dbtable = $this->dbtable;
        echo "listdown array \$inputArray  :  <br>";
        print_r($inputArray);
        echo "<br>";
        //var_dump(count($inputArray));
        $arrayCount = count($inputArray);

        $sqlUpdate = "UPDATE $dbtable
               SET ";
        $i = 0;
        foreach ($inputArray as $key => $value) {
            $i++;
            if ($key == 'id') {
                if($dbtable=='calpurchase'){
                    $sqlUpdate .= "pid=:{$key}";
                }
            } else {
                $sqlUpdate .= $key . "=:{$key}";
                $this->$key = $value;
            }
            if ($i < $arrayCount) {
                $sqlUpdate .= ", ";
            }
        }
        #$qr .= "density =:density, volume=:volume, weight=:weight";
        echo $sqlUpdate . "<br>";

        $objSQL = new SQLBINDPARAM($sqlUpdate, $inputArray);

        $result = $objSQL->UpdateData2();
        if ($result == 'update ok!') {
            $info = "Update Successful<br>";
        } else {
            $info = "Update Failed<br>";
        }
        return $info;
    }

}


?>