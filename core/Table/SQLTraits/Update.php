<?php

namespace Core\Table\SQLTraits;

trait Update {

	/**
	 * Modifie ou ajoute un élément Table dans la DB
	 * 
	 * @param string $statement Ligne de code SQL qui gère la requête
	 * @param array $attributes Tableau des données pour modifier l'Entity
	 * @return bool Retourne true si c'est réussi
	 **/
	public function update($data = [], $clause = [], $operator = [])
	{
		$datasets = "";
        $n = count($data);
        $i = 0;
        foreach ($data as $key => $value)
        {
            if($i < ($n - 1))
            {
                $datasets .= "$key = :$key, ";
            }
            else
            {
                $datasets .= "$key = :$key";
            }
            ++$i;
        }

        /*
         * CONSTRUCTION OF CONDITION
         */
        $conditions = "";
        $n = count($clause);
        $i = 0;
        foreach ($clause as $key => $value)
        {
            if($i < ($n - 1))
            {
                $conditions .= " $key = :$key " . $operator[$i];
            }
            else
            {
                $conditions .= " $key = :$key ";
            }
            ++$i;
        }

        $req = ($conditions ? "UPDATE $this->class SET $datasets WHERE $conditions;" : "UPDATE $this->class SET $datasets;");
        $q = $this->db->prepare($req);
        foreach ($data as $key => $value)
        {
            $q->bindValue(":$key", $value, $this->get_pdo_type($value));
        }

        foreach ($clause as $key => $value)
        {
            $q->bindValue(":$key", $value, $this->get_pdo_type($value));
        }
        $result = $q->execute();

        $q->closeCursor();

        return $result;
	}
}