<?php


class Libros
{

    
        function conectar(){
        //connect to db
        $connection = mysqli_connect('localhost', 'root', '', 'testing');
        $now = new DateTime();
        $mins = $now->getOffset() / 60;
        $sgn = ($mins < 0 ? -1 : 1);
        $mins = abs($mins);
        $hrs = floor($mins / 60);
        $mins -= $hrs * 60;
        $offset = sprintf('%+d:%02d', $hrs*$sgn, $mins);        
        $connection->query("SET time_zone='$offset'");
        if (!$connection) {
                echo "Error!".mysqli_connect_error();
            }
        return $connection;
        }


    
    public function getAll() {
        $c = $this->conectar();
        // query - u can add as many columns and conditicions as desired.
        $sql = "select * from tbl_customer";
         $result = array();
        $resultado = $c->query($sql);
        $ncampos = mysqli_num_fields($resultado);

        while ($row=mysqli_fetch_row($resultado)){
            $result_temp = array();
            for ($i=0; $i < $ncampos; $i++) { 
              $fieldinfo = mysqli_fetch_field_direct($resultado, $i);
              $result_temp[$fieldinfo -> name] = $row[$i];
            }

            $result[]=$result_temp;
        }
        return $result;
    }
    
    
}
