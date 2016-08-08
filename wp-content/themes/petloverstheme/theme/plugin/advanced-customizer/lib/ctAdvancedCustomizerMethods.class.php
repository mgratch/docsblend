<?php

class ctCustomizerMehods {
    /**
     * @return array
     */
    public static function pathVariables(){
        $variables = $folders = $newVariables = array();
        $array = preg_split( '/;/' , file_get_contents ( $path = CT_THEME_DIR . '/assets/less' . '/variables.less' ) );
        $pattern = '/[@]+[a-zA-Z0-9-.]+[:]+[\\s]+["\']+[a-zA-Z0-9-.\\/]+["\']/ ';
        foreach ( $array as $key => $value ){
            if ( preg_match ( $pattern , $value , $match ) ) {
                $lessVariableSplitted = preg_split('/:/',$match[0],2);
                if( preg_match ( '/[.]+[.]+[\/]/' , $lessVariableSplitted[1] ) ) {
                    $variables[] =  strtr( $lessVariableSplitted[0] ,array( ':' => '' , '@' => ''));
                    $paths[] = $lessVariableSplitted[1];
                    $pathsSpliited = preg_split('/\//', $lessVariableSplitted[1]);
                    foreach($pathsSpliited as $key2 => $folderName){
                        if (!preg_match('/[a-zA-Z0-9]/',$folderName) || preg_match('/[a]+[s]+[s]+[e]+[t]+[s]/', $folderName)){
                            unset($pathsSpliited[$key2]);
                        } else {
                            $pathsSpliited[$key2] = strtr($folderName, array('"' => ''));
                        }
                    }
                    $folders[] = $pathsSpliited;
                }
            }
        }
        foreach($variables as $key => $val){
            $path = '/' . implode('/', $folders[$key]);
            $newPath = '"' . CT_THEME_ASSETS . $path . '"';
            $newVariables[$val] = $newPath;
        }
        return $newVariables;
    }

    public static function idToLessname($id){
        if ( strpos( $id, 'ct_customizer_' ) === 0 && strlen( $id ) > 14 ) {
            $name = substr( $id, 14 );
            $name = str_replace( '_', '-', $name );

            return $name;
        }

        return false;
    }

    /**
     * create title based on name of less variable
     *
     * @param $name
     *
     * @return string
     */
    protected function lessnameToTitle( $name ) {
        $dels = array( $this->currentSection, $this->currentPanel );
        foreach ( $dels as $del ) {
            $del  = str_replace( 'ct_', '', $del );
            $del  = strtolower( $del );
            $name = str_replace( $del, '', $name );
        }
        $name = str_replace( '-', ' ', $name );
        $name = str_replace( '  ', ' ', $name );
        $name = ltrim( $name );
        $name = ucfirst( $name );

        return $name;
    }

    /**
     * create id based on name
     *
     * @param $name
     *
     * @return mixed|string
     */
    public static function nameToId( $name ) {
        $id = strtolower( $name );
        $id = str_replace( ' ', '_', $id );
        $id = 'ct_' . $id;

        return $id;
    }
    /**
     * create setting id based on name of less variable
     *
     * @param $name
     *
     * @return string
     */
    public static function lessnameToId( $name ) {
        $id = 'ct_customizer_' . str_replace( '-', '_', $name );

        return $id;
    }
    public static function optionToId( $name ) {
        $id = 'ct_option_' . str_replace( '-', '_', $name );

        return $id;
    }
    /**
     * if panels are supported by wordpress
     * @return bool
     */
    public static function idToName( $id ) {
        $id   = substr( $id, 3 );
        $name = str_replace( '_', ' ', $id );
        $name = ucfirst( $name );

        return $name;
    }
    /**
     * @param $path
     */




}