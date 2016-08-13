<?php
    /**
     * Executes arbitrary SQL with given an array of args.
     * PARAMETERS:
     *    $SQL:  (string) The SQL query to execute, with unescaped arguments
     *           replaced with $1, $2...
     *    $args: (array) A list of arguments which will be escaped and placed
     *           into the SQL string, in order.
     * RETURNS:
     *    (mysqli result array) Results of the query
     */
    function execute_sql($SQL, $args)
    {
        global $servername, $username, $password, $dbname;
        $conn = new mysqli($servername, $username, $password, $dbname);
        if( $conn->connect_error)
        {
            die("Connection failed: " . $conn->connect_error);
        }

        $counter = 1;
        foreach($args as $arg) {
            $arg = $conn->real_escape_string($arg);
            $arg_string = '$'.$counter;
            $SQL = str_replace($arg_string, $arg, $SQL);
            $counter++;
        }
        
        $results = $conn->query($SQL);
        $conn->close();
        return $results;
    }
?>
