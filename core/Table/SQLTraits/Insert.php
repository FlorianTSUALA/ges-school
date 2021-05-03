<?php

namespace Core\Table\SQLTraits;

trait Insert {
    
    function save($data = [])
    {
        
        if(isset($data) && is_array($data)){
            if( isset($data[0]) && is_array($data[0]) ){
                foreach($data as $sub_array){
                    $this->save($sub_array);
                }
            }else{
                $fields = "";
                $values = "";
                $n = count($data);
                $i = 0;
                foreach ($data as $key => $value)
                {
                    if($i < ($n - 1))
                    {
                        $fields .= "$key, ";
                        $values .= ":$key, ";
                    }
                    else
                    {
                        $fields .= "$key";
                        $values .= ":$key";
                    }
                    ++$i;
                }
                $req = "INSERT INTO $this->table ( $fields ) VALUES ( $values );";
                // var_dump($req, $data);

                $q = $this->db->prepare($req);
                foreach ($data as $key => $value)
                {
                    $q->bindValue(":$key", $value, $this->get_pdo_type($value));
                }
                $result = $q->execute();
                $q->closeCursor();
        
                return $result;
            }
        }
    }
}