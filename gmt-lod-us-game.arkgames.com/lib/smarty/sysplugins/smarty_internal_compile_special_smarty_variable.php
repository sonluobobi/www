<?php
/**
* Smarty Internal Plugin Compile Special Smarty Variable
* 
* Compiles the special $smarty variables
* 
* @package Smarty
* @subpackage Compiler
* @author Uwe Tews 
*/
/**
* Smarty Internal Plugin Compile special Smarty Variable Class
*/
class Smarty_Internal_Compile_Special_Smarty_Variable extends Smarty_Internal_CompileBase {
    /**
    * Compiles code for the speical $smarty variables
    * 
    * @param array $args array with attributes from parser
    * @param object $compiler compiler object
    * @return string compiled code
    */
    public function compile($args, $compiler)
    {
        $_index = explode(',', str_replace(array(']['), array(','), substr($args,1,strlen($args)-2)));
        $compiled_ref = ' ';
        switch (trim($_index[0], "'")) {
            case 'foreach':
                return "\$_smarty_tpl->getVariable('smarty')->value$args";
            case 'section':
                return "\$_smarty_tpl->getVariable('smarty')->value$args";
            case 'capture':
                return "\$_smarty_tpl->smarty->_smarty_vars$args";
            case 'now':
                return 'time()';

            case 'get':
                $compiled_ref = "\$_GET";
                break;

            case 'post':
                $compiled_ref = "\$_POST";
                break;

            case 'cookies':
                $compiled_ref = "\$_COOKIE";
                break;

            case 'env':
                $compiled_ref = "\$_ENV";
                break;

            case 'server':
                $compiled_ref = "\$_SERVER";
                break;

            case 'session':
                $compiled_ref = "\$_SESSION";
                break;

            case 'request':
                $compiled_ref = "\$_REQUEST";
                break;

            case 'template':
                $_template_name = basename($compiler->template->getTemplateFilepath());
                return "'$_template_name'";

            case 'current_dir':
                $_template_dir_name = dirname($compiler->template->getTemplateFilepath());
                return "'$_template_dir_name'";

            case 'version':
                $_version = Smarty::$_version;
                return "'$_version'";

            case 'const':
                if ($compiler->smarty->security && !$compiler->smarty->security_policy->allow_constants) {
                    $compiler->trigger_template_error("(secure mode) constants not permitted");
                    break;
                } 
                return '@' . trim($_index[1], "'");

            case 'config':
                return "\$_smarty_tpl->getConfigVariable($_index[1])";
            case 'ldelim':
                $_ldelim = $compiler->smarty->left_delimiter;
                return "'$_ldelim'";

            case 'rdelim':
                $_rdelim = $compiler->smarty->right_delimiter;
                return "'$_rdelim'";

            default:
                $compiler->trigger_template_error('$smarty.' . trim($_index[0], "'") . ' is an unknown reference');
                break;
        } 
        if (isset($_index[1])) {
            array_shift($_index);
            foreach ($_index as $_ind) {
                $compiled_ref = $compiled_ref . "[$_ind]";
            } 
        } 
        return $compiled_ref;
    } 
} 
?>
