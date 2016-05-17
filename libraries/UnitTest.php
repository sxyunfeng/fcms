<?php

namespace libraries;
!defined( 'APP_ROOT' ) && exit( 'Direct Access Deny!' );

/**
 * CodeIgniter
 *
 * An open source application development framework for PHP 5.1.6 or newer
 *
 * @package CodeIgniter
 * @author ExpressionEngine Dev Team
 * @copyright Copyright (c) 2008 - 2014, EllisLab, Inc.
 * @license http://codeigniter.com/user_guide/license.html
 * @link http://codeigniter.com
 * @since Version 1.3.1
 * @filesource
 *
 *
 *
 *
 */
// ------------------------------------------------------------------------
/**
 * Unit Testing Class
 *
 * Simple testing class
 *
 * @package CodeIgniter
 * @subpackage Libraries
 * @category UnitTesting
 * @author ExpressionEngine Dev Team
 * @link http://codeigniter.com/user_guide/libraries/uri.html
 */
class UnitTest implements \Phalcon\DI\InjectionAwareInterface
{

    var $active = TRUE;

    var $results = array();

    var $strict = FALSE;

    var $_template = NULL;

    var $_template_rows = NULL;

    var $_test_items_visible = array();

    protected $_arrLangUnitTest = NULL;

    protected $_di;

    public function __construct()
    {
        // These are the default items visible when a test is run.
        $this->_test_items_visible = array(
                'test_name', 
                'test_datatype', 
                'res_datatype', 
                'result', 
                'file', 
                'line', 
                'notes'
        );
        $this->loadLanguage();
        // log_message('debug', "Unit Testing Class Initialized");
    }
    // --------------------------------------------------------------------
    /**
     * Run the tests
     *
     * Runs the supplied tests
     *
     * @access public
     * @param
     *            array
     * @return void
     */
    function set_test_items( $items = array() )
    {
        if( !empty( $items ) and is_array( $items ) )
        {
            $this->_test_items_visible = $items;
        }
    }

    function loadLanguage()
    {
        if( !$this->_arrLangUnitTest )
        {
            $this->_arrLangUnitTest = include APP_ROOT .
                     'language/unit_test_lang.php';
        }
        return $this->_arrLangUnitTest;
    }

    private function stdClassObjectToArray( $obj )
    {
        if( is_array( $obj ))
            return $obj;
        
        if( !is_object( $obj ) )
            return $obj;
        
        $_array = !is_string($obj ) && is_object( $obj ) ? get_object_vars( $obj ) : $obj;
        
        foreach( $_array as $key => $value )
        {
            $value = ( is_array( $value ) || is_object( $value ) ) ? $this->stdClassObjectToArray( 
                    $value ) : $value;
            $array[ $key ] = $value;
        }
        
        return $array;
    }

    function getLine( $line = '' )
    {
        $value = ( $line == '' or !isset( $this->_arrLangUnitTest[ $line ] ) ) ? FALSE : $this->_arrLangUnitTest[ $line ];
        return $value;
    }
    // --------------------------------------------------------------------
    /**
     * Run the tests
     *
     * Runs the supplied tests
     *
     * @access public
     * @param $test mixed
     * @param $expected mixed
     * @param $test_name string
     * @param $notes string
     * @param @iMatch string 0 for simple 1 for match keys 2 for match values 3 for match keys and values 4 for match partial
     * @param @arrPartial array
     * @return string
     */
    function run( $test, $expected = TRUE, $test_name = 'undefined', $notes = '', $iMatch = 0, 
            $arrPartial = null )
    {
        if( $this->active == FALSE )
        {
            return FALSE;
        }
        if( in_array( $expected, 
                array(
                        'is_object', 
                        'is_string', 
                        'is_bool', 
                        'is_true', 
                        'is_false', 
                        'is_int', 
                        'is_numeric', 
                        'is_float', 
                        'is_double', 
                        'is_array', 
                        'is_null'
                ), TRUE ) )
        {
            $expected = str_replace( 'is_float', 'is_double', $expected );
            $result = ( $expected( $test ) ) ? TRUE : FALSE;
            $extype = str_replace( 
                    array(
                            'true', 
                            'false'
                    ), 'bool', str_replace( 'is_', '', $expected ) );
        }
        else
        {
            $result = FALSE;
            $extype = gettype( $expected );
            
            if( !$iMatch )
            {
                $expected = $this->stdClassObjectToArray( $expected );
                $test = $this->stdClassObjectToArray( $test );
            }
            
            switch( $iMatch )
            {
                case 0: // match simple for double float int string ...
                    if( $this->strict == TRUE )
                        $result = ( $test === $expected ) ? TRUE : FALSE;
                    else
                        $result = ( $test == $expected ) ? TRUE : FALSE;
                    break;
                case 1: // match keys
                    if( empty( array_diff_key( $expected, $test ) ) )
                    {
                        $result = true;
                    }
                    break;
                case 2: // match values
                    if( empty( array_diff( $expected, $test ) ) )
                    {
                        $result = true;
                    }
                    break;
                case 3: // match keys and values
                    if( empty( array_diff_assoc( $expected, $test ) ) )
                    {
                        $result = true;
                    }
                    break;
                case 4: // match partial
                    
                    $result = true;
                    if( empty( $arrPartial))
                    {
                    	$arrPartial = array_keys( $expected );
                    }
                    foreach( $arrPartial as $partial )
                    {
                    	if( !(isset( $test[ $partial ] ) && isset( $expected[ $partial ] ) &&
                    	   $test[ $partial ] == $expected[ $partial ] ))
                    	{
                    	    $result = false;
                    	    break;
                    	} 
                    }
                    break;
            }
        }
        $back = $this->_backtrace();
        $report[] = array(
                'test_name' => $test_name, 
                'test_datatype' => gettype( $test ), 
                'res_datatype' => $extype, 
                'result' => ( $result === TRUE ) ? 'passed' : 'failed', 
                'file' => $back[ 'file' ], 
                'line' => $back[ 'line' ], 
                'notes' => $notes
        );
        $this->results[] = $report;
        
        if( PHP_SAPI == 'cli' )
        {
            return $this->cliReport( $this->result( $report ));    
        }
        
        return ( $this->report( $this->result( $report ) ) );
    }
    
    public function cliReport( $result = array() )
    {
        if( count( $result ) == 0 )
        {
            $result = $this->result();
        }
    
        $iPassed = 0;
        $r = '';
        foreach( $result as $res )
        {
            $test_name = $res[ 'Test Name' ];
            $test = $res[ 'Test Datatype' ];
            $exttype = $res[ 'Expected Datatype' ];
            $rres = $res[ 'Result' ];
    
            $file = $res[ 'File Name' ];
            $line = $res[ 'Line Number' ];
            $notes = $res[ 'Notes' ];
    
            $strTemp = "
            ----------------------------------------------------------------------------------------------------------\r
            Test Name\t\t$test_name \r
            Test DataType\t\t$test \r
            Expected Datatype\t$exttype \r
            Result\t\t\t$rres \r
            File Name\t\t$file \r
            Line Number\t\t$line \r
            Notes\t\t\t$notes \r";
    
            $r .= $strTemp;
    
            if( $rres == 'Passed' )
            {
                ++$iPassed;
            }
        }
    
        if( count( $result ) > 1 )
        {
            $r .= ( "\r\n\r\nSummary\r\npassed:\t$iPassed\r\nfailed:" . ( count( $result ) - $iPassed ) . "\t\r");
        }
        return $r;
    }
    
    
    // --------------------------------------------------------------------
    /**
     * Generate a report
     *
     * Displays a table with the test data
     *
     * @access public
     * @return string
     */
    function report( $result = array() )
    {
        if( count( $result ) == 0 )
        {
            $result = $this->result();
        }
        $this->_parse_template();
        $r = '';
        foreach( $result as $res )
        {
            $table = '';
            foreach( $res as $key => $val )
            {
                if( $key == $this->getLine( 'ut_result' ) )
                {
                    if( $val == $this->getLine( 'ut_passed' ) )
                    {
                        $val = '<span style="color: #0C0;">' . $val . '</span>';
                    }
                    elseif( $val == $this->getLine( 'ut_failed' ) )
                    {
                        $val = '<span style="color: #C00;">' . $val . '</span>';
                    }
                }
                $temp = $this->_template_rows;
                $temp = str_replace( '{item}', $key, $temp );
                $temp = str_replace( '{result}', $val, $temp );
                $table .= $temp;
            }
            $r .= str_replace( '{rows}', $table, $this->_template );
        }
        return $r;
    }
    // --------------------------------------------------------------------
    /**
     * Use strict comparison
     *
     * Causes the evaluation to use === rather than ==
     *
     * @access public
     * @param
     *            bool
     * @return null
     */
    function use_strict( $state = TRUE )
    {
        $this->strict = ( $state == FALSE ) ? FALSE : TRUE;
    }
    // --------------------------------------------------------------------
    /**
     * Make Unit testing active
     *
     * Enables/disables unit testing
     *
     * @access public
     * @param
     *            bool
     * @return null
     */
    function active( $state = TRUE )
    {
        $this->active = ( $state == FALSE ) ? FALSE : TRUE;
    }
    // --------------------------------------------------------------------
    /**
     * Result Array
     *
     * Returns the raw result data
     *
     * @access public
     * @return array
     */
    function result( $results = array() )
    {
        // $CI =& get_instance();
        // $CI->load->language('unit_test');
        if( count( $results ) == 0 )
        {
            $results = $this->results;
        }
        $retval = array();
        foreach( $results as $result )
        {
            $temp = array();
            foreach( $result as $key => $val )
            {
                if( !in_array( $key, $this->_test_items_visible ) )
                {
                    continue;
                }
                if( is_array( $val ) )
                {
                    foreach( $val as $k => $v )
                    {
                        if( FALSE !== ( $line = $this->getLine( 
                                strtolower( 'ut_' . $v ) ) ) )
                        {
                            $v = $line;
                        }
                        $temp[ $this->getLine( 'ut_' . $k ) ] = $v;
                    }
                }
                else
                {
                    if( FALSE !== ( $line = $this->getLine( 
                            strtolower( 'ut_' . $val ) ) ) )
                    {
                        $val = $line;
                    }
                    $temp[ $this->getLine( 'ut_' . $key ) ] = $val;
                }
            }
            $retval[] = $temp;
        }
        return $retval;
    }
    // --------------------------------------------------------------------
    /**
     * Set the template
     *
     * This lets us set the template to be used to display results
     *
     * @access public
     * @param
     *            string
     * @return void
     */
    function set_template( $template )
    {
        $this->_template = $template;
    }
    // --------------------------------------------------------------------
    /**
     * Generate a backtrace
     *
     * This lets us show file names and line numbers
     *
     * @access private
     * @return array
     */
    function _backtrace()
    {
        if( function_exists( 'debug_backtrace' ) )
        {
            $back = debug_backtrace();
            $file = ( !isset( $back[ '1' ][ 'file' ] ) ) ? '' : $back[ '1' ][ 'file' ];
            $line = ( !isset( $back[ '1' ][ 'line' ] ) ) ? '' : $back[ '1' ][ 'line' ];
            return array(
                    'file' => $file, 
                    'line' => $line
            );
        }
        return array(
                'file' => 'Unknown', 
                'line' => 'Unknown'
        );
    }
    // --------------------------------------------------------------------
    /**
     * Get Default Template
     *
     * @access private
     * @return string
     */
    function _default_template()
    {
        $this->_template = "\n" .
                 '<table style="width:100%; font-size:small; margin:10px 0; border-collapse:collapse; border:1px solid #CCC;">';
        $this->_template .= '{rows}';
        $this->_template .= "\n" . '</table>';
        $this->_template_rows = "\n\t" . '<tr>';
        $this->_template_rows .= "\n\t\t" .
                 '<th style="text-align: left; border-bottom:1px solid #CCC;">{item}</th>';
        $this->_template_rows .= "\n\t\t" .
                 '<td style="border-bottom:1px solid #CCC;">{result}</td>';
        $this->_template_rows .= "\n\t" . '</tr>';
    }
    // --------------------------------------------------------------------
    /**
     * Parse Template
     *
     * Harvests the data within the template {pseudo-variables}
     *
     * @access private
     * @return void
     */
    function _parse_template()
    {
        if( !is_null( $this->_template_rows ) )
        {
            return;
        }
        if( is_null( $this->_template ) )
        {
            $this->_default_template();
            return;
        }
        if( !preg_match( "/\{rows\}(.*?)\{\/rows\}/si", $this->_template, 
                $match ) )
        {
            $this->_default_template();
            return;
        }
        $this->_template_rows = $match[ '1' ];
        $this->_template = str_replace( $match[ '0' ], '{rows}', 
                $this->_template );
    }
    /*
     * (non-PHPdoc) @see \Phalcon\DI\InjectionAwareInterface::setDI()
     */
    public function setDI( \Phalcon\DiInterface $dependencyInjector = null )
    {
        $this->_di = $dependencyInjector;
    }
    /*
     * (non-PHPdoc) @see \Phalcon\DI\InjectionAwareInterface::getDI()
     */
    public function getDI()
    {
        return $this->_di;
    }
}
// END Unit_test Class
/**
 * Helper functions to test boolean true/false
 *
 *
 * @access private
 * @return bool
 */
function is_true( $test )
{
    return ( is_bool( $test ) and $test === TRUE ) ? TRUE : FALSE;
}

function is_false( $test )
{
    return ( is_bool( $test ) and $test === FALSE ) ? TRUE : FALSE;
}


/* End of file Unit_test.php */
/* Location: ./system/libraries/Unit_test.php */