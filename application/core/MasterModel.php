<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class MasterModel extends CI_Model {

    protected $db_prefix;
    protected $class_name;
    protected $db_tablename;
    protected $db_fields;

    public function __construct() {
        parent::__construct();
        $this->load->database();
        $this->db_prefix = $this->db->dbprefix;
        $this->class_name = get_class($this);
    }

    public function getDbTableName() {
        return $this->db_tablename;
    }

    public function setDbTableName($db_tablename) {
        $this->db_tablename = $this->db_prefix . $db_tablename;
    }

    public function getDbFields() {
        return $this->db_fields;
    }

    public function setDbFields($db_fields) {
        $this->db_fields = $db_fields;
    }

    public function fromArray($array, $strict = false) {
        if (is_array($array) && !empty($array)) {
            foreach ($array as $key => $value) {
                if (!$strict) {
                    $this->$key = $value;
                } else {
                    if ($this->checkProperty($key))
                        $this->$key = $value;
                }
            }
        }
    }

	public function toArray($strict = false) {
		$array = get_object_vars($this);
		if ($strict) {
			foreach ($array as $key => $value) {
				if (!$this->checkProperty($key))
					unset($array[$key]);
			}
		}
		return $array;
	}

    public function save() {
        if (!isset($this->id) || !$this->id) {
            return $this->insert();
        } else {
            return $this->update();
        }
    }

    public function insert() {
        $object_array = $this->toArray(true);

        $insert_data = array();
        foreach ($this->db_fields as $field) {
            if (isset($object_array[$field])) {
                $insert_data[$field] = $object_array[$field];
            }


            if (isset($object_array[$field]) && $object_array[$field] === 'NULL') {
                $insert_data[$field] = NULL;
            }
        }

        $this->db->insert($this->db_tablename, $insert_data);
        $insert_id = $this->db->insert_id();
        if ($this->checkProperty('id')) {
            $this->id = $insert_id;
        }
        return $insert_id;
    }

    public function update($pk = false) {
        $object_array = $this->toArray(true);

        $propery = 'id';
        if ($pk) {
            if ($this->checkProperty($pk)) {
                $propery = $pk;
            }
        }

        $update_data = array();
        foreach ($this->db_fields as $field) {
            if (isset($object_array[$field])) {
                $update_data[$field] = $object_array[$field];
            }
            if (isset($object_array[$field]) && ($object_array[$field] === 'NULL')) {
                $update_data[$field] = NULL;
            }
        }

        $this->db->where($propery, $this->$propery);
        $this->db->update($this->db_tablename, $update_data);

        $aff_rows = $this->db->affected_rows();
        return $aff_rows;
    }

    public function checkProperty($property, $property_only = false) {
        if (is_string($property)) {
            if (!$property_only) {
                if (property_exists($this, $property) && in_array($property, $this->db_fields))
                    return true;
            } else {
                if (property_exists($this, $property))
                    return true;
            }
        }
        return false;
    }

    public function getById($id) {
        if ($this->checkProperty('id')) {
            $object = $this->db->select()
                ->from($this->db_tablename)
                ->where([
                    'id' => $id,
                ])->get()->first_row(get_class($this));
            return !empty($object) ? $object : false;
        }
        return false;
    }

}
