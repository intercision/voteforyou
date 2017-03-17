<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
* CSVReader Class
*
* $Id: csvreader.php 147 2007-07-09 23:12:45Z Pierre-Jean $
*
* Allows to retrieve a CSV file content as a two dimensional array.
* The first text line shall contains the column names.
*
* @author        Pierre-Jean Turpeau
* @link        http://www.codeigniter.com/wiki/CSVReader
*/
class CSVReader {

    var $fields;        /** columns names retrieved after parsing */
    var $separator = ',';    /** separator used to explode each line */

    /**
     * Parse a text containing CSV formatted data.
     *
     * @access    public
     * @param    string
     * @return    array
     */
    function parse_text($p_Text) {
        $lines = explode("\n", $p_Text);
        return $this->parse_lines($lines);
    }

    /**
     * Parse a file containing CSV formatted data.
     *
     * @access    public
     * @param    string
     * @return    array
     */
    function parse_file($p_Filepath) {
        $lines = file($p_Filepath);
        return $this->parse_lines($lines);
    }
    /**
     * Parse an array of text lines containing CSV formatted data.
     *
     * @access    public
     * @param    array
     * @return    array
     */
    function parse_lines($p_CSVLines) {
        $content = FALSE;
        foreach( $p_CSVLines as $line_num => $line ) {
            if( $line != '' ) { // skip empty lines
			
			
			// ADDED
			
			  // regular expression

                $expr="/".$this->separator."(?=(?:[^\"]*\"[^\"]*\")*(?![^\"]*\"))/";
				
                // $elements = split($this->separator, $line);
				$elements = preg_split($expr,$line);
				
				
				
                if( !is_array($content) ) { // the first line contains fields names
				
				    for ($c=0;$c<sizeof($elements);$c++){  // go through array and trim CR from elements	  
					  $elements[$c] = trim($elements[$c],"\r\n");
					}
					
                    $this->fields = $elements;
                    $content = array();
                } else {
                    $item = array();
                    foreach( $this->fields as $id => $field ) {
                        if( isset($elements[$id]) ) {
                            $item[$field] = trim($elements[$id],"\r\n"); // may change for UNIX CSV input
							$item[$field] = trim($elements[$id],"\"");
                        }
                    }
                    $content[] = $item;
                }
            }
        }
        return $content;
    }
	
	
	
    function str_getcsv($input, $delimiter = ',', $enclosure = '"', $escape = '\\', $eol = '\n') {
        if (is_string($input) && !empty($input)) {
            $output = array();
            $tmp    = preg_split("/".$eol."/",$input);
            if (is_array($tmp) && !empty($tmp)) {
                while (list($line_num, $line) = each($tmp)) {
                    if (preg_match("/".$escape.$enclosure."/",$line)) {
                        while ($strlen = strlen($line)) {
                            $pos_delimiter       = strpos($line,$delimiter);
                            $pos_enclosure_start = strpos($line,$enclosure);
                            if (
                                is_int($pos_delimiter) && is_int($pos_enclosure_start)
                                && ($pos_enclosure_start < $pos_delimiter)
                                ) {
                                $enclosed_str = substr($line,1);
                                $pos_enclosure_end = strpos($enclosed_str,$enclosure);
                                $enclosed_str = substr($enclosed_str,0,$pos_enclosure_end);
                                $output[$line_num][] = $enclosed_str;
                                $offset = $pos_enclosure_end+3;
                            } else {
                                if (empty($pos_delimiter) && empty($pos_enclosure_start)) {
                                    $output[$line_num][] = substr($line,0);
                                    $offset = strlen($line);
                                } else {
                                    $output[$line_num][] = substr($line,0,$pos_delimiter);
                                    $offset = (
                                                !empty($pos_enclosure_start)
                                                && ($pos_enclosure_start < $pos_delimiter)
                                                )
                                                ?$pos_enclosure_start
                                                :$pos_delimiter+1;
                                }
                            }
                            $line = substr($line,$offset);
                        }
                    } else {
                        $line = preg_split("/".$delimiter."/",$line);
   
                        /*
                         * Validating against pesky extra line breaks creating false rows.
                         */
                        if (is_array($line) && !empty($line[0])) {
                            $output[$line_num] = $line;
                        } 
                    }
                }
                return $output;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }



}
