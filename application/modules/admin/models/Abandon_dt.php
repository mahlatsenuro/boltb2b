<?php    
class Abandon_dt extends CI_Model implements DatatableModel{
    	
    public function appendToSelectStr() {
            //_protect_identifiers needs to be FALSE in the database.php when using custom expresions to avoid db errors.
            //CI is putting `` around the expression instead of just the column names
                    return array(
                            //'contactNameFull' => 'concat(c.contactFirstName, \' \', c.contactLastName)'
                    );
    }

    public function fromTableStr() {
            return 'abandon_cart a';
    }

    /**
     * @return
     *     Associative array of joins.  Return NULL or empty array  when not joining
     */
    public function joinArray(){
        return array();
    }
	    
    /**
     * 
     *@return
     *  Static where clause to be appended to all search queries.  Return NULL or empty array
     * when not filtering by additional criteria
     */
    	public function whereClauseArray(){
    		return NULL;
    	}
   }