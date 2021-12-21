<?php

// namespace Classes\Theme;

class Theme extends Functions
{
    private $theme_dir;
    private $theme;

    private $tpl_name = null;
    private $tpl = [];
    private $set_ = [];
    private $set_block_ = [];
    private $set_block_e_ = [];

    function __construct($theme = '/theme')
    {
        $this->theme = $theme;
        $this->theme_dir = ROOT . $this->theme;
    }

    public function name($name)
    {
        $this->tpl_name = $name;
        $this->set[$this->tpl_name] = [];
    }

    public function load($tpl_name = false)
    {
        $path = $this->theme_dir . '/' . ($tpl_name ? $tpl_name : $this->tpl_name) . '.tpl';
        return (file_exists($path) ? file_get_contents($path) : "Файл " . ($tpl_name ? $tpl_name : $this->tpl_name) . ".tpl не найден");
        // return ( file_exists( $path ) ? file_get_contents( $path ) : "Файл " . $path . " не найден" );
    }

    private function _ver($tpl)
    { // Версия файла
        if (strpos($tpl, "{ver=") !== false) {
            preg_match_all("#{ver=(.*?)}#is", $tpl, $vers, PREG_SET_ORDER);
            foreach ($vers as $key => $value) {
                $tpl = str_replace($value[0], (file_exists(ROOT . $value[1]) ? filemtime(ROOT . $value[1]) : microtime(1)), $tpl);
            }
        }
        return $tpl;
    }

    public function set_block_e($tag, $value, $not = false)
    {
        $this->set_block_e_[] = ['name' => $tag, 'value' => $value, 'not' => $not];
    }

    private function _set_block_e($tpl)
    {

        foreach ($this->set_block_e_ as $key => $tag) {
            if (strpos($tpl, "[{ {$tag['name']}=") !== false) {
                $preg = "#\\[{ {$tag['name']}=(.*?) }\\](.*?)\\[{ /{$tag['name']} }\\]#is";
                preg_match_all($preg, $tpl, $blocks_e, PREG_SET_ORDER);
                foreach ($blocks_e as $key => $el) {
                    $el[1] = explode(',', $el[1]);
                    if ( $tag['not'] ) {
                        $tpl = str_replace($el[0], (in_array($tag['value'], $el[1]) ? '' : $el[2]), $tpl);
                    } else {
                        $tpl = str_replace($el[0], (in_array($tag['value'], $el[1]) ? $el[2] : ''), $tpl);
                    }
                }
            }
        }
        // die();
        return $tpl;
    }

    public function set_block($tag, $value)
    {
        $this->set_block_[$this->tpl_name][$tag] = $value;
    }

    private function _set_block($tpl)
    {
        $tags = $this->set_block_[$this->tpl_name];
        foreach ($tags as $tag => $show) {
            if (strpos($tpl, "[{ {$tag} }]") !== false) {
                $preg = "#\\[{ {$tag} }\\](.*?)\\[{ /{$tag} }\\]#is";
                preg_match_all($preg, $tpl, $blocks, PREG_SET_ORDER);
                foreach ($blocks as $key => $block)
                    $tpl = str_replace($block[0], ($show ? $block[1] : ''), $tpl);
            }
        }

        return $tpl;
    }

    public function set($tag, $value)
    {
        $this->set_[$this->tpl_name][$tag] = $value;
    }

    private function _set($tpl)
    {
        $tags = $this->set_[$this->tpl_name];
        foreach ($tags as $tag => $value) {
            $tpl = str_replace("[{ {$tag} }]", $value, $tpl);
        }
        return $tpl;
    }

    private function _theme($tpl)
    {
        $tpl = str_replace('[{ THEME }]', $this->theme, $tpl);
        return $tpl;
    }

    private function _include($tpl)
    {
        if (strpos($tpl, "[{ =") !== false) {
            preg_match_all("#\\[{ =(.*?)= }\\]#is", $tpl, $files, PREG_SET_ORDER);
            foreach ($files as $key => $value) {
                $tpl = str_replace($value[0], $this->load($value[1]), $tpl);
            }
        }
        return $tpl;
    }

    public function compile($name = false)
    {
        $tpl = $this->load();
        $tpl = $this->_include($tpl);
        $tpl = $this->_set_block_e($tpl);
        $tpl = $this->_set_block($tpl);
        $tpl = $this->_set($tpl);
        $tpl = $this->_theme($tpl);
        $tpl = $this->_ver($tpl);
        return $tpl;
    }

    public function clear()
    {
        unset($this->tpl[$this->tpl_name]);
        $this->tpl_name = null;
    }
}
