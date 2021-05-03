<?php

namespace Core\Table\SQLTraits;

trait Delete {
    
	public function delete_default(string $id)
	{
                $req = "DELETE FROM $this->class WHERE id=:id;";
                $q = $this->db->prepare($req);
                $q->bindValue(":id", $id, $this->get_pdo_type($id));
                $result = $q->execute();
                $q->closeCursor();
                return $result;
        }

        public function delete_with_condition(string $field, $value)
        {
                $req = "DELETE FROM $this->class WHERE $field=:id;";
                $q = $this->db->prepare($req);
                $q->bindValue(":id", $value, $this->get_pdo_type($value));
                $result = $q->execute();
                $q->closeCursor();
                return $result;
	}
}