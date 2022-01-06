<?php 
/**
	Admin Page Framework v3.8.34 by Michael Uno 
	Generated by PHP Class Files Script Generator <https://github.com/michaeluno/PHP-Class-Files-Script-Generator>
	<http://en.michaeluno.jp/sz>
	Copyright (c) 2013-2021, Michael Uno; Licensed under MIT <http://opensource.org/licenses/MIT> */
class CConfiguratorAdminPageFramework_FieldType_default extends CConfiguratorAdminPageFramework_FieldType {
    public $aDefaultKeys = array();
    public function _replyToGetField($aField) {
        return $aField['before_label'] . "<div class='sz-input-label-container'>" . "<label for='{$aField['input_id']}'>" . $aField['before_input'] . ($aField['label'] && !$aField['repeatable'] ? "<span " . $this->getLabelContainerAttributes($aField, 'sz-input-label-string') . ">" . $aField['label'] . "</span>" : "") . $aField['value'] . $aField['after_input'] . "</label>" . "</div>" . $aField['after_label'];
    }
    }
    