
     <?php
        $hash = strtoupper(
            md5(
                "1221879" . 
                "ItemNo12345" . 
                number_format("1000.00", 2, '.', '') . 
                "LKR" .  
                strtoupper(md5("MzA1NjE2OTYwODEyOTI0MDk3ODkyOTUxODU2MjM1ODM1ODQ5MDE1")) 
            ) 
        );
        echo $hash;
   ?>

  
   

