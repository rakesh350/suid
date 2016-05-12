<?php

class suid {

    private $table_name;
    private $conn_obj_obj;

    function __construct($table_name, $conn_obj_obj = "") {
        $this->table_name = $table_name;
        $this->conn_obj = $conn_obj_obj;
    }

    public function store($student_array = array()) {

        if (!empty($student_array)) {
            $insert_sql = "insert into $this->table_name (";
            foreach ($student_array as $k => $v) {
                $insert_sql.=$k . " , ";
            }
            $insert_sql = substr($insert_sql, 0, -3);
            $insert_sql = $insert_sql . ") values (";
            foreach ($student_array as $k => $v) {
                $insert_sql.="'" . $v . "', ";
            }
            $insert_sql = substr($insert_sql, 0, -2);
            $insert_sql = $insert_sql . ")";
            if ($this->conn_obj->query($insert_sql)) {
                return $this->conn_obj->insert_id;
            } else {
                return false;
            }
        }
    }

    public function update($condition = array(), $data = array()) {
        if (!empty($condition) && !empty($data)) {
            $update_sql = "UPDATE $this->table_name set ";
            foreach ($data as $k => $v) {
                $update_sql.=$k . "='" . $v . "', ";
            }
            $update_sql = substr($update_sql, 0, -2);
            $update_sql.="WHERE ";
            foreach ($condition as $k => $v) {
                $update_sql.=$k . "='" . $v . "' ";
            }
            if ($this->conn_obj->query($update_sql)) {
                return true;
            } else {
                return false;
            }
        }
    }

    public function delete($condition = array()) {
        if (!empty($condition)) {
            $delete_sql = "delete from $this->table_name where ";
            foreach ($condition as $k => $v) {
                $delete_sql.=$k . "='" . $v . "'";
            }
            if ($this->conn_obj->query($delete_sql)) {
                return true;
            } else {
                return false;
            }
        }
    }

    public function select($condition = "", $fields = array('*')) {
        $select_sql = "select ";
        foreach ($fields as $field) {
            $select_sql.=$field . ", ";
        }
        $select_sql = substr($select_sql, 0, -2);
        $select_sql.=" from $this->table_name ";
        if ($condition != "") {
            if (is_array($condition)) {
                $select_sql.="where ";
                foreach ($condition as $k => $v) {
                    $select_sql.=$k . "='" . $v . "'";
                }
            }
        } else {
            //  No where clause will be added
        }
        //echo $select_sql;
        $result = $this->conn_obj->query($select_sql);
        if ($result->num_rows > 0) {
            return $result;
        } else {
            return false;
        }
    }

}

?>