<?php 
class Web_Pagination extends CI_Pagination {

    public function __construct() {
        parent::__construct();
    }

    public function current_place() {
        return 'You are currently viewing page '.$this->cur_page.' out of '.ceil(($this->total_rows/$this->per_page)). 'results';
    }
}
?>